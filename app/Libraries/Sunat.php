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
        log_message('info', '========== INICIO EMISIÓN COMPROBANTE ==========');
        
        // Validar configuración
        if (!$this->apiUrl) {
            log_message('error', 'SUNAT_API_URL no está configurada en .env');
            return ['error' => 'SUNAT_API_URL no configurada', 'missing_config' => 'SUNAT_API_URL'];
        }
        
        if (!$this->token) {
            log_message('error', 'SUNAT_TOKEN no está configurado en .env');
            return ['error' => 'SUNAT_TOKEN no configurado', 'missing_config' => 'SUNAT_TOKEN'];
        }

        // Agregar company_id si no está incluido
        if (!isset($data['company_id'])) {
            $data['company_id'] = $this->companyId;
        }

        $jsonData = json_encode($data);
        
        log_message('info', '[REQUEST] URL: ' . $this->apiUrl);
        log_message('info', '[REQUEST] Método: POST');
        log_message('info', '[REQUEST] Company ID: ' . $data['company_id']);
        log_message('info', '[REQUEST] Data: ' . $jsonData);

        $headers = [
            'Authorization: Bearer ' . $this->token,
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Para logs más detallados

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        log_message('info', '[RESPONSE] HTTP Code: ' . $httpCode);
        log_message('info', '[RESPONSE] Content Type: ' . ($info['content_type'] ?? 'N/A'));
        log_message('info', '[RESPONSE] Size: ' . strlen($response) . ' bytes');
        log_message('info', '[RESPONSE] Raw Response: ' . $response);

        if ($error) {
            log_message('error', '[ERROR] CURL Error: ' . $error);
            return [
                'success' => false,
                'error' => 'CURL Error: ' . $error,
                'curl_errno' => curl_errno($ch),
                'http_code' => $httpCode
            ];
        }

        // Si la respuesta está vacía
        if (empty($response)) {
            log_message('error', '[ERROR] Empty response from SUNAT API (HTTP ' . $httpCode . ')');
            return [
                'success' => false,
                'error' => 'Empty response from SUNAT API',
                'http_code' => $httpCode
            ];
        }

        $result = json_decode($response, true);
        
        // Si no es JSON válido
        if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', '[ERROR] JSON Decode Error: ' . json_last_error_msg());
            log_message('error', '[ERROR] Response Content: ' . substr($response, 0, 2000));
            return [
                'success' => false,
                'error' => 'Invalid JSON response: ' . json_last_error_msg(),
                'raw_response' => substr($response, 0, 500),
                'http_code' => $httpCode
            ];
        }
        
        // Log resultado final
        if ($httpCode >= 400) {
            log_message('error', "[ERROR] HTTP {$httpCode}: " . json_encode($result));
        } else {
            log_message('info', '[SUCCESS] Comprobante emitido exitosamente');
        }
        
        log_message('info', '========== FIN EMISIÓN COMPROBANTE ==========');
        
        return $result;
    }
}
