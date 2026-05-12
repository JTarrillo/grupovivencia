<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'grupovivencia');

if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

// SQL para actualizar la tabla
$sql = "
ALTER TABLE `payment_plans` 
ADD COLUMN IF NOT EXISTS `department_id` INT DEFAULT NULL AFTER `location`,
ADD COLUMN IF NOT EXISTS `province_id` VARCHAR(100) DEFAULT NULL AFTER `department_id`,
ADD COLUMN IF NOT EXISTS `district_id` VARCHAR(100) DEFAULT NULL AFTER `province_id`,
ADD COLUMN IF NOT EXISTS `down_payment_type` VARCHAR(50) DEFAULT 'percentage' AFTER `min_down_payment_percentage`,
ADD COLUMN IF NOT EXISTS `min_down_payment_amount` DECIMAL(10,2) DEFAULT NULL AFTER `down_payment_type`;
";

if ($conn->multi_query($sql)) {
    echo "✓ Tabla actualizada correctamente\n";
    
    // Mostrar estructura de la tabla
    $result = $conn->query("DESCRIBE payment_plans");
    echo "\nEstructura de la tabla payment_plans:\n";
    while ($row = $result->fetch_assoc()) {
        echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
    }
} else {
    echo "✗ Error al actualizar la tabla: " . $conn->error . "\n";
}

$conn->close();
?>
