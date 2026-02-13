<?php
namespace App\Libraries;

class Nubefact
{
    private $apiUrl;
    private $token;

    public function __construct()
    {
        $this->apiUrl = env('NUBFACT_API_URL');
        $this->token = env('NUBFACT_TOKEN');
    }

    public function emitirComprobante($data)
    {
        $jsonData = json_encode($data);
        $headers = [
            'Authorization: Token ' . $this->token,
            'Content-Type: application/json',
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['error' => $error];
        }
        return json_decode($response, true);
    }
}