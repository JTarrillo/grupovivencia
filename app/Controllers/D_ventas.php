<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\UnilevelsModel;
use App\Models\CalificationModel;
use App\Models\InvoicesModel;
use App\Models\StoreModel;
use App\Models\CountriesModel;
use App\Models\Invoice_detail_membershipModel;
use App\Models\MembershipsModel;
use App\Controllers\B_home;


class D_ventas extends BaseController
{
    /**
     * Muestra la vista principal del módulo de ventas
     */
    public function index()
    {
        $session = session();

        // Seguridad: Si no está logueado, al login
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'session_id'   => $session->get('id'),
            'session_name' => $session->get('name') . " " . $session->get('lastname'),
            'title'        => 'Módulo de Ventas',
            // Pasamos los tokens por si quieres usarlos directamente en la vista (opcional)
            'api_token'    => $session->get('api_access_token'),
            'token_type'   => $session->get('api_token_type') ?? 'Bearer',
        ];

        return view('admin/ventas/index', $data);
    }

    /**
     * Endpoint de prueba para verificar tokens en sesión
     */
    public function test_token()
    {
        $session = session();
        $token = $session->get('api_access_token');
        $tokenType = $session->get('api_token_type');

        $data = [
            'isLoggedIn' => $session->get('isLoggedIn'),
            'token_exists' => !empty($token),
            'token_type_exists' => !empty($tokenType),
            'token_preview' => $token ? substr($token, 0, 20) . '...' : 'null',
            'token_type' => $tokenType ?? 'null',
            'session_data' => [
                'api_access_token' => $token ? 'present' : 'MISSING',
                'api_token_type' => $tokenType ? 'present' : 'MISSING'
            ]
        ];

        return $this->response
            ->setContentType('application/json')
            ->setBody(json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Endpoint de test para debugging profundo
     */
    public function test_api_debug()
    {
        $session = session();
        $token = $session->get('api_access_token');
        $tokenType = $session->get('api_token_type');

        $debug = [
            'step' => 'inicio',
            'token_null' => is_null($token),
            'tokenType_null' => is_null($tokenType)
        ];

        if (!$token) {
            $debug['error'] = 'Token is null or empty';
            return $this->response
                ->setContentType('application/json')
                ->setStatusCode(401)
                ->setBody(json_encode($debug, JSON_PRETTY_PRINT));
        }

        $debug['step'] = 'token_is_valid';

        // Convertir a string seguramente
        $tokenStr = (string)$token;
        $tokenTypeStr = isset($tokenType) ? (string)$tokenType : 'Bearer';

        $debug['tokenStr_length'] = strlen($tokenStr);
        $debug['tokenTypeStr'] = $tokenTypeStr;

        // Construir header
        $authHeader = $tokenTypeStr . ' ' . $tokenStr;
        $debug['authHeader_length'] = strlen($authHeader);
        $debug['step'] = 'ready_for_curl';

        return $this->response
            ->setContentType('application/json')
            ->setBody(json_encode($debug, JSON_PRETTY_PRINT));
    }

    /**
     * Endpoint que consume la API de facturación externa
     * Este es el que llamarás con jQuery.ajax
     */
    public function get_boletas_api()
    {
        $session = session();

        // 1. Validar Token de sesión
        $token     = $session->get('api_access_token');
        $tokenType = $session->get('api_token_type') ?? 'Bearer';

        if (!$token) {
            return $this->response
                ->setContentType('application/json')
                ->setStatusCode(401)
                ->setBody(json_encode([
                    'status'  => false,
                    'message' => 'Error de autenticación: No se encontró un token válido.'
                ], JSON_PRETTY_PRINT));
        }

        try {
            // 2. Usar CURL puro sin cliente de CI4
            $url = 'https://apifacturacion.groupdispensersac.com/api/v1/boletas?company_id=1&branch_id=1&per_page=20';
            
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: ' . $tokenType . ' ' . $token,
                    'Accept: application/json',
                    'Content-Type: application/json'
                ],
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 15
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if (!empty($curlError)) {
                log_message('error', 'CURL Error: ' . $curlError);
                return $this->response
                    ->setContentType('application/json')
                    ->setStatusCode(500)
                    ->setBody(json_encode([
                        'status'  => false,
                        'message' => 'Error de CURL: ' . $curlError
                    ], JSON_PRETTY_PRINT));
            }

            log_message('info', 'API Response Status: ' . $httpCode . ', Body Length: ' . strlen($response ?? ''));

            return $this->response
                ->setContentType('application/json')
                ->setStatusCode($httpCode)
                ->setBody($response ?? '{}');
        } catch (\Exception $e) {
            log_message('error', 'Error en get_boletas_api: ' . $e->getMessage());
            return $this->response
                ->setContentType('application/json')
                ->setStatusCode(500)
                ->setBody(json_encode([
                    'status'  => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], JSON_PRETTY_PRINT));
        }
    }



    public function operacion_facturacion()
    {
        $request = \Config\Services::request();
        $id      = $request->getPost('id');
        $tipo    = $request->getPost('tipo');   // 'send', 'pdf', 'xml', 'cdr', 'generate'
        $nombre  = $request->getPost('nombre'); // Ej: B001-000001

        $session = session();
        $token   = $session->get('api_access_token');
        $tType   = $session->get('api_token_type') ?? 'Bearer';

        // Validaciones iniciales
        if (!$token || !$id || !$tipo || !$nombre) {
            return $this->response
                ->setStatus(400)
                ->setContentType('application/json')
                ->setBody(json_encode(['status' => false, 'message' => 'Parámetros incompletos']));
        }

        // 1. Detección de Factura o Boleta para el segmento de la URL
        $esFactura = (strpos(strtoupper($nombre), 'F') === 0);
        $segmento  = $esFactura ? 'invoices' : 'boletas';

        // 2. Definir URL y MÉTODO (POST para 'send' y 'generate')
        $metodoHttp = 'GET';

        if ($tipo === 'generate') {
            $metodoHttp = 'POST';
            $url = "https://apifacturacion.groupdispensersac.com/api/v1/{$segmento}/{$id}/generate-pdf?format=A4";
        } else {
            // Rutas de descarga/envío
            $baseUrlApi = "https://apifacturacion.groupdispensersac.com/api/v1/boletas/{$id}/";
            switch ($tipo) {
                case 'send':
                    $metodoHttp = 'POST';
                    $url = $baseUrlApi . "send-sunat";
                    break;
                case 'pdf':
                    $url = $baseUrlApi . "download-pdf?format=A4";
                    break;
                case 'xml':
                    $url = $baseUrlApi . "download-xml";
                    break;
                case 'cdr':
                    $url = $baseUrlApi . "download-cdr";
                    break;
                default:
                    return $this->response
                        ->setStatus(400)
                        ->setContentType('application/json')
                        ->setBody(json_encode(['status' => false, 'message' => 'Tipo de operación no válida']));
            }
        }

        try {
            $client = \Config\Services::curlrequest();
            
            // Usar CURL puro en lugar de CI4 HTTP client
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => $url,
                CURLOPT_CUSTOMREQUEST  => $metodoHttp,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_HTTPHEADER     => [
                    "Authorization: {$tType} {$token}",
                    "Accept: application/json"
                ]
            ]);

            $body = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            // Manejo de errores CURL
            if ($curlError) {
                return $this->response
                    ->setStatus(500)
                    ->setContentType('application/json')
                    ->setBody(json_encode(['status' => false, 'message' => 'Error CURL: ' . $curlError]));
            }

            // 3. Respuesta para GENERAR (JSON con link)
            if ($tipo === 'generate') {
                $apiRes = is_string($body) ? json_decode($body, true) : $body;
                $result = [
                    'status'   => isset($apiRes['success']) ? $apiRes['success'] : false,
                    'message'  => isset($apiRes['message']) ? $apiRes['message'] : 'PDF Generado',
                    'file_url' => isset($apiRes['data']['file_url']) ? $apiRes['data']['file_url'] : 
                                 (isset($apiRes['link']) ? $apiRes['link'] : '')
                ];
                return $this->response
                    ->setContentType('application/json')
                    ->setBody(json_encode($result));
            }

            // 4. Lógica para operaciones JSON (send)
            if ($tipo === 'send') {
                $apiRes = is_string($body) ? json_decode($body, true) : $body;
                $result = isset($apiRes) && is_array($apiRes) ? $apiRes : ['status' => false, 'message' => 'Respuesta inválida'];
                return $this->response
                    ->setContentType('application/json')
                    ->setBody(json_encode($result));
            }

            // 5. Validar respuesta HTTP para descargas (pdf, xml, cdr)
            if ($httpCode === 200 && !empty($body)) {
                $folderPath = FCPATH . 'comprobantes/' . $nombre;
                if (!is_dir($folderPath)) mkdir($folderPath, 0777, true);

                $extension = ($tipo === 'pdf') ? '.pdf' : (($tipo === 'xml') ? '.xml' : '.zip');
                $fileName  = $nombre . '_' . strtoupper($tipo) . $extension;
                $fullPath  = $folderPath . '/' . $fileName;

                // Guardar archivo
                if (file_put_contents($fullPath, $body)) {
                    $result = [
                        'status'   => true,
                        'message'  => "Archivo {$tipo} descargado correctamente",
                        'file_url' => base_url("comprobantes/{$nombre}/{$fileName}")
                    ];
                } else {
                    $result = [
                        'status'   => false,
                        'message'  => "Error al guardar archivo {$tipo} localmente"
                    ];
                }
                return $this->response
                    ->setContentType('application/json')
                    ->setBody(json_encode($result));
            }

            // Error HTTP
            $result = [
                'status'  => false,
                'message' => "Error API (HTTP {$httpCode}): No se pudo obtener el archivo"
            ];
            return $this->response
                ->setStatus($httpCode)
                ->setContentType('application/json')
                ->setBody(json_encode($result));

        } catch (\Exception $e) {
            $result = [
                'status'  => false,
                'message' => 'Excepción: ' . $e->getMessage()
            ];
            return $this->response
                ->setStatus(500)
                ->setContentType('application/json')
                ->setBody(json_encode($result));
        }
    }

    public function generar_pdf_api()
    {
        $session = session();
        $token     = $session->get('api_access_token');
        $tokenType = $session->get('api_token_type') ?? 'Bearer';

        // Recibir datos del AJAX
        $id     = $this->request->getPost('id');     // ID interno de la API
        $numero = $this->request->getPost('nombre'); // Ejemplo: B001-12 o F001-5

        if (!$id || !$numero) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID o Número de documento faltante.']);
        }

        // 1. Determinar el tipo de documento según la primera letra del número
        $primeraLetra = strtoupper(substr($numero, 0, 1));

        // Configurar URL según el tipo (Factura o Boleta)
        if ($primeraLetra === 'F') {
            $endpoint = "https://apifacturacion.groupdispensersac.com/api/v1/invoices/{$id}/generate-pdf";
        } else {
            // Por defecto Boleta si empieza con B
            $endpoint = "https://apifacturacion.groupdispensersac.com/api/v1/boletas/{$id}/generate-pdf";
        }

        $client = \Config\Services::curlrequest();

        try {
            $response = $client->get($endpoint, [
                'headers' => [
                    'Authorization' => $tokenType . ' ' . $token,
                    'Accept'        => 'application/json',
                ],
                'http_errors' => false
            ]);

            $result = json_decode($response->getBody(), true);

            // La API suele devolver un success y el file_url o link del PDF
            if (isset($result['success']) && $result['success']) {
                return $this->response->setJSON([
                    'status'   => true,
                    'message'  => 'PDF generado con éxito',
                    'file_url' => $result['data']['file_url'] ?? $result['link'] ?? '#'
                ]);
            } else {
                return $this->response->setJSON([
                    'status'  => false,
                    'message' => $result['message'] ?? 'La API no pudo generar el PDF.'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Error de conexión: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}