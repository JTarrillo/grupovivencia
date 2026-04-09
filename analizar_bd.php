<?php
// Cargar configuración de CodeIgniter
require 'vendor/autoload.php';

$db = mysqli_connect('localhost', 'root', '', 'grupovivencia');

if (!$db) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener todas las tablas
$result = mysqli_query($db, "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='grupovivencia'");

echo "=== TABLAS EN GRUPOVIVENCIA ===\n\n";

while ($row = mysqli_fetch_assoc($result)) {
    $table = $row['TABLE_NAME'];
    echo "📊 TABLA: $table\n";
    
    // Obtener estructura de la tabla
    $columns = mysqli_query($db, "DESCRIBE $table");
    
    while ($col = mysqli_fetch_assoc($columns)) {
        $field = $col['Field'];
        $type = $col['Type'];
        $null = $col['Null'];
        $key = $col['Key'];
        $default = $col['Default'];
        
        echo "  └─ $field ($type) " . ($null === 'NO' ? '[NOT NULL]' : '') . ($key ? "[$key]" : "") . "\n";
    }
    
    // Contar registros
    $count = mysqli_query($db, "SELECT COUNT(*) as cnt FROM $table");
    $cnt_row = mysqli_fetch_assoc($count);
    echo "  📍 Registros: " . $cnt_row['cnt'] . "\n\n";
}

mysqli_close($db);
?>
