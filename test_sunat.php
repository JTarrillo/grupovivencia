<?php
// Test SUNAT API - con autenticación

echo "=== INTENTO 1: Obtener Token de Autenticación ===\n\n";

// Primero intentar login para obtener un token válido
$loginUrl = 'http://localhost:8000/api/auth/login';
$loginData = [
    'email' => 'admin@sunatapi.com',
    'password' => 'admin123456'
];

$ch = curl_init($loginUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($loginData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "Login URL: " . $loginUrl . "\n";
echo "HTTP Code: " . $httpCode . "\n";

if ($error) {
    echo "Error: " . $error . "\n\n";
} else {
    echo "Response:\n" . $response . "\n\n";
    
    $loginResult = json_decode($response, true);
    
    if (isset($loginResult['token'])) {
        $token = $loginResult['token'];
        echo "✓ Token obtenido: " . substr($token, 0, 30) . "...\n\n";
        
        // Ahora intentar crear una boleta con el token válido
        echo "=== INTENTO 2: Crear Boleta con Token Válido ===\n\n";
        
        $apiUrl = 'http://localhost:8000/v1/boletas';
        $token_auth = $token;
        
        $data = [
            "scenario" => "Boleta Gravada",
            "company_id" => 1,
            "branch_id" => 1,
            "serie" => "B001",
            "fecha_emision" => date('Y-m-d'),
            "moneda" => "PEN",
            "tipo_operacion" => "0101",
            "metodo_envio" => "resumen_diario",
            "forma_pago_tipo" => "Contado",
            "client" => [
                "tipo_documento" => "1",
                "numero_documento" => "12345678",
                "razon_social" => "Test Cliente",
                "direccion" => "Av. Test 123",
                "telefono" => "999999999",
                "email" => "test@test.com"
            ],
            "detalles" => [
                [
                    "codigo" => "TEST-001",
                    "descripcion" => "Producto Test",
                    "unidad" => "NIU",
                    "cantidad" => 1,
                    "mto_valor_unitario" => 100.00,
                    "porcentaje_igv" => 18,
                    "tip_afe_igv" => "10",
                    "codigo_producto_sunat" => "95121601"
                ]
            ],
            "usuario_creacion" => "test"
        ];
        
        $jsonData = json_encode($data);
        
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token_auth,
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        echo "API URL: " . $apiUrl . "\n";
        echo "HTTP Code: " . $httpCode . "\n";
        echo "Token usado: " . substr($token_auth, 0, 30) . "...\n";
        
        if ($error) {
            echo "Error: " . $error . "\n\n";
        } else {
            echo "Response:\n";
            if (strlen($response) > 1000) {
                echo substr($response, 0, 1000) . "\n...(truncado)\n";
            } else {
                echo $response . "\n";
            }
        }
    } else {
        echo "ERROR: No se obtuvo token. Respuesta:\n";
        var_dump($loginResult);
    }
}
?>
