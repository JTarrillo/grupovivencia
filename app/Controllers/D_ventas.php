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
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Error de autenticación: No se encontró un token válido.'
            ])->setStatusCode(401);
        }

        // 2. Configurar el cliente HTTP de CodeIgniter
        $client = \Config\Services::curlrequest();

        try {
            // 3. Petición GET a la API externa
            // Nota: Puedes mover la URL base a un archivo .env para más seguridad
            $url = 'https://apifacturacion.groupdispensersac.com/api/v1/boletas';

            $response = $client->get($url, [
                'headers' => [
                    'Authorization' => $tokenType . ' ' . $token,
                    'Accept'        => 'application/json',
                ],
                'query' => [
                    'company_id' => 1,
                    'branch_id'  => 1,
                    'per_page'   => 20
                ],
                'http_errors' => false // Evita que CI4 lance una excepción si la API da 400 o 500
            ]);

            // 4. Retornar la respuesta tal cual la da la API
            $body = json_decode($response->getBody());
            return $this->response->setJSON($body);
        } catch (\Exception $e) {
            // Manejo de errores de conexión o red
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'No se pudo conectar con el servidor de facturación: ' . $e->getMessage()
            ])->setStatusCode(500);
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

        // 1. Detección de Factura o Boleta para el segmento de la URL
        $esFactura = (strpos(strtoupper($nombre), 'F') === 0);
        $segmento  = $esFactura ? 'invoices' : 'boletas';

        // 2. Definir URL y MÉTODO (POST para 'send' y 'generate')
        $metodoHttp = 'GET';

        if ($tipo === 'generate') {
            $metodoHttp = 'POST'; // <--- CAMBIO CLAVE: La API exige POST para generar
            $url = "https://apifacturacion.groupdispensersac.com/api/v1/{$segmento}/{$id}/generate-pdf?format=A4";
        } else {
            // Tus rutas de descarga/envío que ya te funcionan
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
                    return $this->response->setJSON(['status' => false, 'msg' => 'Tipo no válido']);
            }
        }

        $client = \Config\Services::curlrequest();

        try {
            // Usamos el $metodoHttp dinámico (POST o GET)
            $response = $client->request($metodoHttp, $url, [
                'headers' => [
                    'Authorization' => "{$tType} {$token}",
                    'Accept'        => 'application/json',
                ],
                'http_errors' => false,
                'verify' => false
            ]);

            $body = $response->getBody();

            // 3. Respuesta para GENERAR (JSON con link)
            if ($tipo === 'generate') {
                $apiRes = json_decode($body, true);
                return $this->response->setJSON([
                    'status'   => $apiRes['success'] ?? false,
                    'message'  => $apiRes['message'] ?? 'PDF Generado',
                    'file_url' => $apiRes['data']['file_url'] ?? $apiRes['link'] ?? '#'
                ]);
            }

            // 4. Tu lógica de descarga local para 'pdf', 'xml', 'cdr' (Binarios)
            if ($tipo == 'send') {
                return $this->response->setJSON(json_decode($body));
            }

            if ($response->getStatusCode() === 200) {
                $folderPath = FCPATH . 'comprobantes/' . $nombre;
                if (!is_dir($folderPath)) mkdir($folderPath, 0777, true);

                $extension = ($tipo == 'pdf') ? '.pdf' : '.xml';
                $fileName  = $nombre . '_' . strtoupper($tipo) . $extension;
                $fullPath  = $folderPath . '/' . $fileName;

                file_put_contents($fullPath, $body);

                return $this->response->setJSON([
                    'status' => true,
                    'message' => "Archivo {$tipo} guardado en local.",
                    'file_url' => base_url("comprobantes/{$nombre}/{$fileName}")
                ]);
            }

            return $this->response->setJSON(['status' => false, 'message' => "Error API: " . $response->getStatusCode()]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => false, 'message' => $e->getMessage()]);
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
