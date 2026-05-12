<?php
// Check table schema
require_once 'app/Config/Database.php';
require_once 'system/Model.php';

$db = \Config\Database::connect();

echo "=== COMISIONES_INMOBILIARIAS SCHEMA ===\n";
$result = $db->query("DESCRIBE comisiones_inmobiliarias")->getResultArray();
foreach ($result as $col) {
    if (in_array($col['Field'], ['beneficiario_id', 'venta_id', 'estado', 'id'])) {
        echo $col['Field'] . ": " . $col['Type'] . " | Null: " . $col['Null'] . " | Default: " . $col['Default'] . "\n";
    }
}

echo "\n=== CONTRACTS SCHEMA ===\n";
$result = $db->query("DESCRIBE contracts")->getResultArray();
foreach ($result as $col) {
    if (in_array($col['Field'], ['sponsor_id', 'id', 'status'])) {
        echo $col['Field'] . ": " . $col['Type'] . " | Null: " . $col['Null'] . " | Default: " . $col['Default'] . "\n";
    }
}

echo "\n=== RECENT LOGS ===\n";
$logFile = 'writable/logs/log-' . date('Y-m-d') . '.log';
if (file_exists($logFile)) {
    $lines = file($logFile);
    $lastLines = array_slice($lines, -50);
    foreach ($lastLines as $line) {
        if (strpos($line, 'save_contract_changes') !== false || 
            strpos($line, 'approve_contract') !== false ||
            strpos($line, 'There is no data') !== false ||
            strpos($line, "beneficiario_id") !== false) {
            echo trim($line) . "\n";
        }
    }
}
?>
