<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class ApiController extends ResourceController
{
    use ResponseTrait;

    public function consulta_dni()
    {
        $request = $this->request->getJSON();
        $dni = isset($request->dni) ? trim($request->dni) : null;
        if (!$dni || strlen($dni) !== 8 || !is_numeric($dni)) {
            return $this->respond(["success" => false, "message" => "DNI inválido"], 400);
        }
        helper('sunat');
        $data = consultar_dni_sunat($dni);
        // DEBUG: Ver respuesta del helper
        file_put_contents(WRITEPATH . 'logs/dni_debug.log', print_r($data, true), FILE_APPEND);
        if ($data && isset($data['nombres'])) {
            // Estandarizar respuesta para JS
            return $this->respond([
                "success" => true,
                "nombres" => $data['nombres'],
                "apellidoPaterno" => $data['apellidoPaterno'] ?? '',
                "apellidoMaterno" => $data['apellidoMaterno'] ?? ''
            ]);
        } else {
            return $this->respond([
                "success" => false,
                "message" => "No se encontraron datos para el DNI."
            ], 404);
        }
    }
}