<?php
// Test database structure
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

// Check comprobantes_emitidos
$sql = "DESC comprobantes_emitidos";
$result = $conn->query($sql);

echo "=== TABLA: comprobantes_emitidos ===\n";
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " | " . $row['Type'] . " | " . ($row['Null'] ?? '') . " | " . ($row['Key'] ?? '') . "\n";
    }
}

echo "\n=== PRIMEROS 5 REGISTROS ===\n";
$sql = "SELECT * FROM comprobantes_emitidos LIMIT 5";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo json_encode($row) . "\n";
    }
} else {
    echo "Sin registros\n";
}

$conn->close();
?>
