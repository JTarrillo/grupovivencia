<?php
// Test de carga de vouchers
require 'public/index.php';

use Config\Database;

$db = Database::connect();

echo "<pre>";
echo "=== TEST VOUCHER UPLOAD ===\n\n";

// 1. Ver estructura de carpetas
echo "1. ESTRUCTURA DE CARPETAS:\n";
$paths = [
    'WRITEPATH' => WRITEPATH,
    'FCPATH' => FCPATH,
    'ROOTPATH' => ROOTPATH,
    'APPPATH' => APPPATH
];

foreach ($paths as $name => $path) {
    echo "   $name = $path\n";
}

// 2. Verificar que la carpeta de uploads existe
echo "\n2. CARPETA DE COMPROBANTES:\n";
$uploadDir = WRITEPATH . 'uploads/comprobantes';
echo "   Path: $uploadDir\n";
echo "   ¿Existe?: " . (is_dir($uploadDir) ? "✓ SÍ" : "✗ NO") . "\n";
echo "   ¿Escribible?: " . (is_writable($uploadDir) ? "✓ SÍ" : "✗ NO") . "\n";

if (is_dir($uploadDir)) {
    $archivos = glob($uploadDir . '/*');
    echo "   Archivos en la carpeta: " . count($archivos) . "\n";
    
    // Mostrar últimos 5 archivos
    echo "   Últimos 5 archivos:\n";
    $ultimos = array_slice(array_reverse($archivos), 0, 5);
    foreach ($ultimos as $archivo) {
        echo "      - " . basename($archivo) . " (" . filesize($archivo) . " bytes)\n";
    }
}

// 3. Ver pagos con voucher en la BD
echo "\n3. PAGOS CON VOUCHER EN BD:\n";
$payments = $db->query("
    SELECT 
        ps.id,
        ps.contract_id,
        ps.amount,
        ps.status,
        ps.voucher_url,
        ps.paid_date,
        c.code as contract_code
    FROM payment_schedule ps
    LEFT JOIN contracts c ON ps.contract_id = c.id
    WHERE ps.voucher_url IS NOT NULL AND ps.voucher_url != ''
    ORDER BY ps.created_at DESC
    LIMIT 10
")->getResultArray();

if (empty($payments)) {
    echo "   ⚠️  No hay pagos con voucher registrados\n";
} else {
    echo "   Encontrados: " . count($payments) . "\n\n";
    
    foreach ($payments as $payment) {
        $id = $payment['id'];
        $url = $payment['voucher_url'];
        $status = $payment['status'];
        $filename = basename($url);
        
        echo "   ID Pago: $id (Contrato: {$payment['contract_code']})\n";
        echo "   URL en BD: $url\n";
        echo "   Estado: $status\n";
        echo "   Fecha Pago: {$payment['paid_date']}\n";
        
        // Buscar el archivo
        $fullPath = WRITEPATH . $url;
        echo "   Path Completo: $fullPath\n";
        
        if (file_exists($fullPath)) {
            $size = filesize($fullPath);
            echo "   ✓ ARCHIVO EXISTE ($size bytes)\n";
        } else {
            echo "   ✗ ARCHIVO NO EXISTE\n";
            
            // Intentar encontrarlo en otras rutas
            $possiblePaths = [
                FCPATH . 'uploads/comprobantes/' . $filename,
                ROOTPATH . 'public/uploads/comprobantes/' . $filename,
                ROOTPATH . 'public/upload/comprobantes/' . $filename
            ];
            
            foreach ($possiblePaths as $altPath) {
                if (file_exists($altPath)) {
                    echo "      → ENCONTRADO EN: $altPath\n";
                    break;
                }
            }
        }
        
        echo "\n";
    }
}

// 4. Ver los últimos logs de uploads
echo "\n4. ÚLTIMOS LOGS DE UPLOAD:\n";
$logFile = WRITEPATH . 'logs/log-' . date('Y-m-d') . '.log';
if (file_exists($logFile)) {
    $lines = file($logFile);
    $uploads = array_filter($lines, function($line) {
        return stripos($line, 'registrarPagoCuota') !== false || 
               stripos($line, 'mostrarComprobante') !== false ||
               stripos($line, 'comprobante') !== false;
    });
    
    if (!empty($uploads)) {
        echo "   Entradas relevantes encontradas: " . count($uploads) . "\n";
        foreach (array_slice(array_reverse($uploads), 0, 5) as $log) {
            echo "   " . trim($log) . "\n";
        }
    } else {
        echo "   No hay logs de upload\n";
    }
} else {
    echo "   Log actual no disponible: $logFile\n";
}

echo "\n</pre>";
?>
