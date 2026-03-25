<?php
namespace App\Libraries;

class Sunat
{
    private $apiUrl;
    private $token;
    private $companyId;

    public function __construct()
    {
        // Obtener configuración del .env
        $this->apiUrl = env('SUNAT_API_URL');
        $this->token = env('SUNAT_TOKEN');
        $this->companyId = env('SUNAT_COMPANY_ID', 1);
    }

    public function emitirComprobante($data)
    {
        // Agregar company_id si no está incluido
        if (!isset($data['company_id'])) {
            $data['company_id'] = $this->companyId;
        }

        $jsonData = json_encode($data);
        $headers = [
            'Authorization: Bearer ' . $this->token,
            'Content-Type: application/json',
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            log_message('error', 'SUNAT API Error: ' . $error);
            return ['error' => $error];
        }

        $result = json_decode($response, true);
        log_message('debug', 'SUNAT Response (' . $httpCode . '): ' . $response);
        
        return $result;
    }
}
