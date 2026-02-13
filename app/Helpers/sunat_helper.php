<?php
use Config\SunatTokens;

if (!function_exists('consultar_dni_sunat')) {
    function consultar_dni_sunat($dni)
    {
        $config = new SunatTokens();
        $token = $config->tokens[0]; // Puedes mejorar la lógica para rotar tokens si lo necesitas
        $endpoint = $config->endpoint . '?numero=' . urlencode($dni);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Authorization: Bearer ' . $token
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $response) {
            $data = json_decode($response, true);
            // Mapear los campos correctos de la API Decolecta
            return [
                'nombres' => $data['first_name'] ?? '',
                'apellidoPaterno' => $data['first_last_name'] ?? '',
                'apellidoMaterno' => $data['second_last_name'] ?? ''
            ];
        }
        return null;
    }
}
    