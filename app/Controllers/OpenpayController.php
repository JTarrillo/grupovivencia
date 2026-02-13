<?php
namespace App\Controllers;

class OpenpayController extends BaseController
{
    public function pagoEjemplo()
    {
        // Cargar configuración
        $config = include(APPPATH . 'Config/Openpay.php');

        // Incluir el SDK manualmente
        require_once APPPATH . 'ThirdParty/Openpay/Openpay.php';

        // Configurar Openpay
        \Openpay::setProductionMode($config['production_mode']);
        \Openpay::setMerchantId($config['merchant_id']);
        \Openpay::setPrivateKey($config['private_key']);

        // Obtener datos del POST (JSON)
        $input = $this->request->getJSON(true);
        $token_id = isset($input['token_id']) ? $input['token_id'] : null;
        $device_session_id = isset($input['device_session_id']) ? $input['device_session_id'] : null;

        // Datos de cliente (puedes obtenerlos del usuario logueado o del formulario)
        $customerData = [
            'name' => 'Juan',
            'last_name' => 'Pérez',
            'email' => 'juan.perez@email.com',
            'phone_number' => '999999999',
        ];

        if (!$token_id || !$device_session_id) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Faltan datos para procesar el pago.'
            ]);
        }

        try {
            $customer = \Openpay::getInstance()->customers->add($customerData);
            $chargeData = [
                'method' => 'card',
                'source_id' => $token_id,
                'amount' => 10.00, // Puedes recibir el monto por POST
                'currency' => 'PEN',
                'description' => 'Pago de prueba',
                'device_session_id' => $device_session_id,
            ];
            $charge = $customer->charges->create($chargeData);
            return $this->response->setJSON([
                'status' => 'ok',
                'charge_id' => $charge->id,
                'message' => 'Pago realizado correctamente'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
