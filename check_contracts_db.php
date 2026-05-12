<?php
$db = mysqli_connect('localhost', 'root', '', 'grupovivencia');
if (!$db) {
    echo "Error: " . mysqli_connect_error();
    exit;
}

echo "=== ÚLTIMO CONTRATO CREADO ===\n";
$result = mysqli_query($db, "SELECT id, customer_id, sponsor_id FROM contracts ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($result);
echo json_encode($row, JSON_PRETTY_PRINT) . "\n";

echo "\n=== TODOS LOS CONTRACTS (últimos 5) ===\n";
$result = mysqli_query($db, "SELECT id, customer_id, sponsor_id FROM contracts ORDER BY id DESC LIMIT 5");
while ($row = mysqli_fetch_assoc($result)) {
    echo "ID: " . $row['id'] . ", customer_id: " . $row['customer_id'] . ", sponsor_id: " . ($row['sponsor_id'] ?? 'NULL') . "\n";
}

mysqli_close($db);
?>
