<?php

namespace App\Controllers;

use App\Models\DocumentoModel;

class D_documentos extends BaseController
{
    protected $documentoModel;

    public function __construct()
    {
        $this->documentoModel = new DocumentoModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        try {
            $documentos = $this->documentoModel->listar();
        } catch (\Exception $e) {
            $documentos = [];
        }

        return view('admin/documentos/index', [
            'documentos'   => $documentos,
            'descripciones' => $this->getDescripciones(),
        ]);
    }

    // Catálogo de "Descripción del Movimiento" para el select
    private function getDescripciones(): array
    {
        $db = db_connect();
        if (!$db->tableExists('movimiento_descripciones')) {
            return [];
        }
        return $db->query("
            SELECT id, nombre
            FROM movimiento_descripciones
            WHERE activo = 1
            ORDER BY nombre ASC
        ")->getResultArray();
    }

    public function upload()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'error' => 'Petición inválida.']);
        }

        $file = $this->request->getFile('archivo');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['success' => false, 'error' => 'Archivo no válido.']);
        }

        if ($file->getMimeType() !== 'application/pdf') {
            return $this->response->setJSON(['success' => false, 'error' => 'Solo se permiten archivos PDF.']);
        }

        $nombre_original = $file->getClientName();
        $nuevo_nombre    = time() . '_' . $file->getRandomName();
        $destino         = WRITEPATH . 'uploads/documentos/';

        if (!is_dir($destino)) {
            mkdir($destino, 0777, true);
        }

        $file->move($destino, $nuevo_nombre);

        $this->documentoModel->insertarDocumento([
            'nombre'      => pathinfo($nombre_original, PATHINFO_FILENAME),
            'archivo'     => $nuevo_nombre,
            'descripcion' => $this->request->getPost('descripcion') ?? '',
            'tipo'        => 'pdf',
            'tamanio'     => $file->getSize(),
            'created_by'  => session()->get('user_name') ?? 'sistema',
        ]);

        return $this->response->setJSON(['success' => true, 'message' => 'Documento subido correctamente.']);
    }

    public function procesar($id)
    {
        set_time_limit(300);
        ini_set('max_execution_time', 300);

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'error' => 'Petición inválida.']);
        }

        $doc = $this->documentoModel->find($id);
        if (!$doc) {
            return $this->response->setJSON(['success' => false, 'error' => 'Documento no encontrado.']);
        }

        $ruta = WRITEPATH . 'uploads/documentos/' . $doc['archivo'];
        if (!file_exists($ruta)) {
            return $this->response->setJSON(['success' => false, 'error' => 'Archivo PDF no encontrado.']);
        }

        $apiKey = getenv('GEMINI_API_KEY');
        if (empty($apiKey)) {
            return $this->response->setJSON(['success' => false, 'error' => 'GEMINI_API_KEY no configurada en .env']);
        }

        // Gemini lee el PDF directamente en base64 (ASCII puro, sin problemas de encoding)
        $pdfBase64 = base64_encode(file_get_contents($ruta));

        // Construir lista de descripciones de movimiento disponibles para que la IA sugiera
        $descripciones = $this->getDescripciones();
        $listaDesc = [];
        foreach ($descripciones as $d) {
            $listaDesc[] = $d['id'] . '=' . $d['nombre'];
        }
        $descTexto = implode('; ', $listaDesc);

        $instruccion = 'Analiza este estado de cuenta bancario y extrae TODAS las transacciones. '
            . 'Devuelve ÚNICAMENTE JSON con esta estructura (sin markdown, sin texto extra): '
            . '{"banco":"nombre","cuenta":"numero","titular":"nombre","moneda":"PEN o USD","periodo":"mes año",'
            . '"saldo_inicial":0.00,"saldo_final":0.00,"total_abonos":0.00,"total_cargos":0.00,'
            . '"transacciones":[{"fecha":"DD/MM/YYYY","movimiento":"tipo","detalle":"descripcion",'
            . '"monto":0.00,"tipo":"abono o cargo","saldo":0.00,"mov_descripcion_id":null}]} '
            . 'monto siempre positivo. tipo=abono si entra dinero, cargo si sale. Incluir ITF y comisiones. '
            . 'Para "mov_descripcion_id": elige el ID de la descripción de movimiento que MEJOR corresponda a cada '
            . 'transacción (aplica tanto a abonos como a cargos). Si ninguna aplica claramente usa null. '
            . 'Descripciones disponibles (formato ID=Nombre): ' . $descTexto;

        // Modelos a intentar en orden (todos verificados como disponibles)
        $modelos = [
            'gemini-2.5-flash',
            'gemini-2.5-flash-lite',
            'gemini-flash-latest',
            'gemini-2.0-flash',
        ];

        $texto     = null;
        $lastError = 'No se pudo conectar con ningún modelo.';

        foreach ($modelos as $modelo) {

            $payload = [
                'contents' => [[
                    'parts' => [
                        ['inline_data' => ['mime_type' => 'application/pdf', 'data' => $pdfBase64]],
                        ['text' => $instruccion],
                    ],
                ]],
                'generationConfig' => [
                    'temperature'     => 0.1,
                    'maxOutputTokens' => 65536,
                ],
            ];

            $jsonPayload = json_encode($payload);
            if (!$jsonPayload) {
                $lastError = 'Error al codificar JSON: ' . json_last_error_msg();
                continue;
            }

            $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $modelo . ':generateContent?key=' . $apiKey;

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL            => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $jsonPayload,
                CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT        => 180,
            ]);

            $response = curl_exec($curl);
            $curlErr  = curl_error($curl);
            curl_close($curl);

            if ($curlErr) {
                $lastError = 'Error cURL: ' . $curlErr;
                continue;
            }

            $apiResp = json_decode($response, true);

            if (isset($apiResp['error'])) {
                $msg = $apiResp['error']['message'] ?? 'Error de API';
                $lastError = '[' . $modelo . '] ' . $msg;
                // Si es alta demanda reintenta, si es error de formato pasa al siguiente
                if (str_contains($msg, 'demand') || str_contains($msg, '503')) {
                    sleep(3);
                }
                continue;
            }

            $texto = $apiResp['candidates'][0]['content']['parts'][0]['text'] ?? '';
            if (!empty($texto)) {
                break;
            }

            $lastError = '[' . $modelo . '] Respuesta vacía. Raw: ' . substr($response, 0, 300);
        }

        if (empty($texto)) {
            return $this->response->setJSON(['success' => false, 'error' => $lastError]);
        }

        // Limpiar posible markdown
        $texto = preg_replace('/^```json\s*/i', '', trim($texto));
        $texto = preg_replace('/\s*```$/i', '', $texto);

        $datos = json_decode($texto, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->response->setJSON([
                'success' => false,
                'error'   => 'No se pudo parsear la respuesta.',
                'raw'     => substr($texto, 0, 800),
            ]);
        }

        // Aplicar reglas automáticas de clasificación según el texto del movimiento
        if (!empty($datos['transacciones']) && is_array($datos['transacciones'])) {
            foreach ($datos['transacciones'] as &$t) {
                $sugerido = $this->autoClasificar(
                    ($t['movimiento'] ?? '') . ' ' . ($t['detalle'] ?? '')
                );
                // La regla por palabra clave tiene prioridad sobre la sugerencia de la IA
                if ($sugerido !== null) {
                    $t['mov_descripcion_id'] = $sugerido;
                }
            }
            unset($t);
        }

        return $this->response->setJSON(['success' => true, 'data' => $datos]);
    }

    // Reglas por palabra clave -> devuelve el ID de movimiento_descripciones
    private function autoClasificar(string $texto): ?int
    {
        $txt = mb_strtoupper($texto);

        // Mapa de descripciones nombre -> id (cacheado)
        static $mapa = null;
        if ($mapa === null) {
            $mapa = [];
            foreach ($this->getDescripciones() as $d) {
                $mapa[mb_strtoupper($d['nombre'])] = (int) $d['id'];
            }
        }

        // Reglas en orden de prioridad (la primera que coincida gana)
        $reglas = [
            // patrón en el texto          => nombre de la descripción
            ['I-BANC',         'TRANSFERENCIAS BANCARIAS'],
            ['COM.O/C',        'TRANSFERENCIAS BANCARIAS'],
            ['N/D AUTORIZADA', 'COMISIONES'],
            ['ITF',            'COMISIONES'],
            ['CONSUMO POS',    'GASTOS'],
        ];

        foreach ($reglas as [$patron, $nombreDesc]) {
            if (mb_strpos($txt, $patron) !== false && isset($mapa[$nombreDesc])) {
                return $mapa[$nombreDesc];
            }
        }

        return null;
    }

    // Guarda las transacciones leídas (con su categoría) en conciliacion_movimientos
    public function cargarConciliacion()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'error' => 'Petición inválida.']);
        }

        $payload = $this->request->getJSON(true);

        $documentoId  = $payload['documento_id']  ?? null;
        $meta         = $payload['meta']          ?? [];
        $transacciones = $payload['transacciones'] ?? [];

        if (empty($transacciones)) {
            return $this->response->setJSON(['success' => false, 'error' => 'No hay transacciones para cargar.']);
        }

        $db = db_connect();

        // Evitar duplicados: borrar lo previo de este mismo documento
        if (!empty($documentoId)) {
            $db->table('conciliacion_movimientos')->where('documento_id', $documentoId)->delete();
        }

        $usuario = session()->get('user_name') ?? 'sistema';
        $insertados = 0;
        $batch = [];

        foreach ($transacciones as $t) {
            $batch[] = [
                'documento_id'       => $documentoId,
                'banco'              => $meta['banco']   ?? null,
                'cuenta'             => $meta['cuenta']  ?? null,
                'periodo'            => $meta['periodo'] ?? null,
                'fecha'              => $this->normalizarFecha($t['fecha'] ?? null),
                'movimiento'         => mb_substr($t['movimiento'] ?? '', 0, 120),
                'detalle'            => mb_substr($t['detalle'] ?? '', 0, 500),
                'monto'              => (float) ($t['monto'] ?? 0),
                'tipo'               => ($t['tipo'] ?? 'cargo') === 'abono' ? 'abono' : 'cargo',
                'saldo'              => isset($t['saldo']) ? (float) $t['saldo'] : null,
                'mov_descripcion_id' => !empty($t['mov_descripcion_id']) ? (int) $t['mov_descripcion_id'] : null,
                'desc_operacion'     => isset($t['desc_operacion']) ? mb_substr($t['desc_operacion'], 0, 500) : null,
                'created_by'         => $usuario,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ];
            $insertados++;
        }

        if (!empty($batch)) {
            $db->table('conciliacion_movimientos')->insertBatch($batch);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => "Se cargaron {$insertados} movimientos a Conciliación.",
            'total'   => $insertados,
        ]);
    }

    // Convierte DD/MM/YYYY o DD/MM a formato Y-m-d
    private function normalizarFecha(?string $fecha): ?string
    {
        if (empty($fecha)) return null;

        if (preg_match('#^(\d{1,2})/(\d{1,2})/(\d{4})$#', $fecha, $m)) {
            return sprintf('%04d-%02d-%02d', $m[3], $m[2], $m[1]);
        }
        if (preg_match('#^(\d{1,2})/(\d{1,2})$#', $fecha, $m)) {
            return sprintf('%04d-%02d-%02d', date('Y'), $m[2], $m[1]);
        }
        $ts = strtotime($fecha);
        return $ts ? date('Y-m-d', $ts) : null;
    }

    public function delete(int $id)
    {
        $doc = $this->documentoModel->find($id);
        if (!$doc) {
            return $this->response->setJSON(['success' => false, 'error' => 'Documento no encontrado.']);
        }

        $archivo = WRITEPATH . 'uploads/documentos/' . $doc['archivo'];
        if (file_exists($archivo)) {
            unlink($archivo);
        }

        $this->documentoModel->delete($id);
        return $this->response->setJSON(['success' => true]);
    }

    public function ver(int $id)
    {
        $doc = $this->documentoModel->find($id);
        if (!$doc) {
            return $this->response->setStatusCode(404)->setBody('Documento no encontrado.');
        }

        $ruta = WRITEPATH . 'uploads/documentos/' . $doc['archivo'];
        if (!file_exists($ruta)) {
            return $this->response->setStatusCode(404)->setBody('Archivo no encontrado.');
        }

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $doc['nombre'] . '.pdf"')
            ->setBody(file_get_contents($ruta));
    }
}
