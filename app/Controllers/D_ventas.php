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
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $contractModel = new \App\Models\ContractModel();
        $contratos = $contractModel->getContractsWithDetails();

        return view('admin/ventas/index', [
            'hola'      => 'hola',
            'contratos' => $contratos,
            'api_url'   => 'https://apifacturacion.cleaningli.com',
        ]);
    }

    public function contratos()
    {
        $contractModel = new \App\Models\ContractModel();
        $contratos = $contractModel->getContractsWithDetails();

        return view('admin/ventas/contratos', [
            'title'     => 'Contratos',
            'contratos' => $contratos,
            'api_url'   => 'https://apifacturacion.cleaningli.com',
        ]);
    }

    public function comprobantes_ajax($contract_id)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'No autorizado'])->setStatusCode(401);
        }

        $db = \Config\Database::connect();
        $comprobantes = $db->table('comprobantes_emitidos')
            ->where('contract_id', $contract_id)
            ->orderBy('id', 'ASC')  // ← orden por id ascendente
            ->get()->getResultArray();

        return $this->response->setJSON([
            'success'      => true,
            'comprobantes' => $comprobantes,
        ]);
    }


    public function anular_comprobante()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'No autorizado'])->setStatusCode(401);
        }

        $json        = $this->request->getJSON();
        $comp_id     = $json->comp_id     ?? null;
        $contract_id = $json->contract_id ?? null;
        $motivo      = $json->motivo      ?? 'Error en emisión';

        if (!$comp_id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID de comprobante requerido']);
        }

        // Obtener comprobante local
        $db   = \Config\Database::connect();
        $comp = $db->table('comprobantes_emitidos')->where('id', $comp_id)->get()->getRowArray();

        if (!$comp) {
            return $this->response->setJSON(['success' => false, 'message' => 'Comprobante no encontrado']);
        }

        // Armar payload para /api/dar-baja
        $esBoleta = $comp['tipo_documento'] === '03';

        if ($esBoleta) {
            $payload = [
                "cabecera" => [
                    "FECHA_EMISION"   => date('Y-m-d'),
                    "FECHA_REFERENCIA" => $comp['fecha_emision'],
                    "CORRELATIVO"     => "1"
                ],
                "detalles" => [[
                    "TIPO_DOCUMENTO"       => "03",
                    "NUMERO_DOCUMENTO"     => $comp['numero_completo'],
                    "ESTADO_ITEM"          => "3",
                    "CLIENTE_NOMBRE"       => $comp['cliente_nombre']   ?? 'ANONIMO',
                    "CLIENTE_NRO_DOCUMENTO" => $comp['cliente_num_doc']  ?? '00000000',
                    "CLIENTE_TIPO_IDENTIDAD" => "1",
                    "CODIGO_MONEDA"        => $comp['moneda'] ?? 'PEN',
                    "TOTAL_VENTA"          => $comp['monto_total'],
                    "TOTAL_GRAVADAS"       => "0.00",
                    "TOTAL_TRIBUTO_IGV"    => "0.00",
                ]]
            ];
        } else {
            $payload = [
                "cabecera" => [
                    "FECHA_EMISION"   => date('Y-m-d'),
                    "NUMERO_DOCUMENTO" => $comp['correlativo'],
                    "FECHA_REFERENCIA" => $comp['fecha_emision'],
                ],
                "detalles" => [[
                    "TIPO_DOCUMENTO"       => "01",
                    "DOCUMENTO_BAJA_SERIE" => $comp['serie'],
                    "DOCUMENTO_BAJA_NUMERO" => $comp['correlativo'],
                    "BAJA_DESCRIPCION"     => $motivo,
                ]]
            ];
        }

        // Llamar a la API Laravel
        $url  = 'https://apifacturacion.cleaningli.com/api/dar-baja';
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => ['Accept: application/json', 'Content-Type: application/json'],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT        => 60,
        ]);
        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error de conexión: ' . $err]);
        }

        $data = json_decode($response, true);

        // Actualizar estado local
        if (!empty($data['success'])) {
            $db->table('comprobantes_emitidos')
                ->where('id', $comp_id)
                ->update(['estado' => 'Anulado', 'updated_at' => date('Y-m-d H:i:s')]);
        }

        return $this->response->setJSON($data);
    }
}
