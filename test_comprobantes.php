<?php
// Test to verify contract and invoices
$config = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'database' => 'grupovivencia'
];

$conn = new mysqli($config['host'], $config['user'], $config['password'], $config['database']);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Get contract GV-2026-001
$sql = "SELECT id, contract_number, customer_id FROM contracts WHERE contract_number LIKE '%GV-2026-001%' LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $contract = $result->fetch_assoc();
    echo "=== CONTRATO ===\n";
    echo json_encode($contract) . "\n\n";
    
    $contract_id = $contract['id'];
    
    // Get comprobantes for this contract
    echo "=== COMPROBANTES PARA CONTRATO ID: $contract_id ===\n";
    $sql2 = "SELECT * FROM comprobantes_emitidos WHERE contract_id = " . $contract_id;
    $result2 = $conn->query($sql2);
    
    if ($result2 && $result2->num_rows > 0) {
        while ($comp = $result2->fetch_assoc()) {
            echo json_encode($comp) . "\n";
        }
    } else {
        echo "Sin comprobantes\n";
    }
} else {
    echo "Contrato no encontrado\n";
    
    // Try to find all contracts
    echo "\n=== TODOS LOS CONTRATOS ===\n";
    $sql = "SELECT id, contract_number FROM contracts LIMIT 5";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " | Contrato: " . $row['contract_number'] . "\n";
    }
}

$conn->close();
?>
