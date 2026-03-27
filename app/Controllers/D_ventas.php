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
        $tipo    = $request->getPost('tipo'); // 'send', 'pdf', 'xml', 'cdr'
        $nombre  = $request->getPost('nombre'); // Ej: B001-000001

        $session = session();
        $token   = $session->get('api_access_token');
        $tType   = $session->get('api_token_type') ?? 'Bearer';

        // 1. Configurar URL según la acción
        $baseUrlApi = "https://apifacturacion.groupdispensersac.com/api/v1/boletas/{$id}/";

        switch ($tipo) {
            case 'send':
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

        $client = \Config\Services::curlrequest();

        try {
            $response = $client->request($tipo == 'send' ? 'POST' : 'GET', $url, [
                'headers' => [
                    'Authorization' => "{$tType} {$token}",
                    'Accept'        => 'application/json',
                ],
                'http_errors' => false,
                'verify' => false // Para evitar problemas de SSL en Localhost
            ]);

            $body = $response->getBody();

            // CASO 1: EMISIÓN A SUNAT (Respuesta JSON)
            if ($tipo == 'send') {
                return $this->response->setJSON(json_decode($body));
            }

            // CASO 2: DESCARGAS (Guardar en carpeta)
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
}
