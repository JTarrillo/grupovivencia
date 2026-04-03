<?php
// Cargar la configuración de CodeIgniter
require_once APPPATH . 'Config/App.php';
require_once APPPATH . 'Config/Database.php';

// Obtener la conexión a la base de datos
$db = \Config\Database::connect();

$sql = "ALTER TABLE `contracts` 
ADD COLUMN `api_factura_id` INT NULL COMMENT 'ID de la boleta/factura en la API' AFTER `bonus_id`,
ADD COLUMN `factura_serie_correlativo` VARCHAR(20) NULL COMMENT 'Ej: B001-000002' AFTER `api_factura_id`,
ADD COLUMN `factura_emitida` TINYINT(1) DEFAULT 0 AFTER `factura_serie_correlativo`";

try {
    $db->query($sql);
    echo "✓ Columnas agregadas exitosamente a la tabla contracts\n";
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>
