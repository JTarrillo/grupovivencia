<?php
namespace App\Libraries\SunatDni;

use Exception;

class SunatDniApi
{
    private $tokenManager;
    private $baseUrl = 'https://api.apis.net.pe/v2/reniec/dni';

    public function __construct(TokenManager $tokenManager)
    {
        $this->tokenManager = $tokenManager;
    }

    public function consultarDni($dni)
    {
        $token = $this->tokenManager->getToken();
        if (!$token) {
            throw new Exception('No hay tokens disponibles para la consulta.');
        }
        $url = $this->baseUrl . '?numero=' . urlencode($dni);
        $headers = [
            'Authorization: Bearer ' . $token
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $this->tokenManager->incrementUsage();
        if ($httpcode == 200) {
            return json_decode($result, true);
        } else {
            return null;
        }
    }
}
