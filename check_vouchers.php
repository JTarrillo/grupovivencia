<?php
// Diagnostico de comprobantes
require 'public/index.php';

use Config\Database;

$db = Database::connect();

// Buscar todos los comprobantes en la BD
$payments = $db->query("SELECT id, voucher_url, amount, status FROM payment_schedule WHERE voucher_url IS NOT NULL AND voucher_url != '' LIMIT 20")->getResultArray();

echo "<pre>";
echo "=== DIAGNOSTICO DE COMPROBANTES ===\n\n";

$missingCount = 0;
$foundCount = 0;

foreach ($payments as $payment) {
    $id = $payment['id'];
    $url = $payment['voucher_url'];
    $filename = basename($url);
    
    echo "ID Pago: $id\n";
    echo "URL en BD: $url\n";
    echo "Filename: $filename\n";
    
    // Rutas posibles
    $paths = [
        WRITEPATH . 'uploads/comprobantes/' . $filename,
        FCPATH . 'uploads/comprobantes/' . $filename,
        ROOTPATH . 'public/uploads/comprobantes/' . $filename,
        ROOTPATH . 'writable/uploads/comprobantes/' . $filename
    ];
    
    $found = false;
    foreach ($paths as $path) {
        if (file_exists($path)) {
            echo "✓ ENCONTRADO: $path\n";
            $found = true;
            $foundCount++;
            break;
        }
    }
    
    if (!$found) {
        echo "✗ NO ENCONTRADO en ninguna ruta\n";
        $missingCount++;
    }
    
    echo "\n";
}

echo "\n=== RESUMEN ===\n";
echo "Total pagos con comprobante: " . count($payments) . "\n";
echo "Encontrados: $foundCount\n";
echo "Faltantes: $missingCount\n";

// Listar archivos en carpetas
echo "\n=== ARCHIVOS EN CARPETAS ===\n";
echo "writable/uploads/comprobantes/: " . count(glob(WRITEPATH . 'uploads/comprobantes/*')) . " archivos\n";
echo "public/uploads/comprobantes/: " . count(glob(FCPATH . 'uploads/comprobantes/*')) . " archivos\n";

echo "</pre>";
?>
