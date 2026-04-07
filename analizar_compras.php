<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = mysqli_connect('localhost', 'root', '', 'grupovivencia');

if (!$db) {
    die("Error de conexión: " . mysqli_connect_error());
}

echo "═══════════════════════════════════════════════════════════\n";
echo "           ANÁLISIS DETALLADO - MÓDULO DE COMPRAS           \n";
echo "═══════════════════════════════════════════════════════════\n\n";

// 1. Ver clasificaciones existentes
echo "📊 TABLA: clasificaciones_compra\n";
echo "───────────────────────────────────\n";
$result = mysqli_query($db, "SELECT * FROM clasificaciones_compra");
$clasificaciones = [];
while ($row = mysqli_fetch_assoc($result)) {
    $clasificaciones[] = $row;
    echo "  ID: {$row['id']} | Nombre: {$row['nombre']} | Código: {$row['codigo']}\n";
    if (!empty($row['descripcion'])) {
        echo "  └─ Descripción: {$row['descripcion']}\n";
    }
}
echo "\n";

// 2. Ver estructura de compras
echo "📋 TABLA: compras (Estructura Actual)\n";
echo "───────────────────────────────────────\n";
$columns = mysqli_query($db, "DESCRIBE compras");
while ($col = mysqli_fetch_assoc($columns)) {
    echo "  • {$col['Field']} ({$col['Type']}, " . ($col['Null'] === 'NO' ? 'NOT NULL' : 'NULL') . ")\n";
}
echo "\n";

// 3. Ver registros en compras
echo "📦 Registros en COMPRAS\n";
echo "──────────────────────\n";
$compras = mysqli_query($db, "SELECT * FROM compras");
$count = mysqli_num_rows($compras);
echo "  Total de compras: $count\n";
if ($count > 0) {
    while ($row = mysqli_fetch_assoc($compras)) {
        echo "  └─ ID: {$row['id']} | Proveedor: {$row['proveedor_id']} | Total: {$row['total']} | Estado: {$row['estado']}\n";
    }
} else {
    echo "  ✓ Tabla vacía (lista para llenar)\n";
}
echo "\n";

// 4. Ver tabla incoming
echo "📥 TABLA: incoming (Recepción de Compras)\n";
echo "──────────────────────────────────────────\n";
$incoming = mysqli_query($db, "SELECT * FROM incoming LIMIT 5");
$incoming_count = mysqli_num_rows($incoming);
echo "  Total de registros: $incoming_count\n";
if ($incoming_count > 0) {
    while ($row = mysqli_fetch_assoc($incoming)) {
        echo "  └─ ID: {$row['id']} | Proveedor: {$row['supplier_id']} | Usuario: {$row['user_id']} | Total: {$row['total_cost']}\n";
    }
}
echo "\n";

// 5. Ver tabla archivos_digitales
echo "📄 TABLA: archivos_digitales\n";
echo "────────────────────────────\n";
$archivos = mysqli_query($db, "SELECT * FROM archivos_digitales LIMIT 5");
$archivos_count = mysqli_num_rows($archivos);
echo "  Total de archivos: $archivos_count\n";
echo "  Estado: Vacía (lista para almacenar PDFs/fotos)\n";
echo "\n";

// 6. Ver proveedores disponibles
echo "🏢 PROVEEDORES DISPONIBLES\n";
echo "──────────────────────────\n";
$proveedores = mysqli_query($db, "SELECT id, name, ruc, active FROM suppliers");
while ($row = mysqli_fetch_assoc($proveedores)) {
    $estado = $row['active'] == 1 ? '✓ Activo' : '✗ Inactivo';
    echo "  ID: {$row['id']} | {$row['name']} | RUC: {$row['ruc']} | {$estado}\n";
}
echo "\n";

// 7. Ver usuarios
echo "👤 USUARIOS DEL SISTEMA\n";
echo "──────────────────────\n";
$usuarios = mysqli_query($db, "SELECT id, name, lastname, email, type FROM users LIMIT 10");
while ($row = mysqli_fetch_assoc($usuarios)) {
    echo "  ID: {$row['id']} | {$row['name']} {$row['lastname']} | Tipo: {$row['type']} | Email: {$row['email']}\n";
}
echo "\n";

echo "═══════════════════════════════════════════════════════════\n";
echo "              ✓ ANÁLISIS COMPLETADO\n";
echo "═══════════════════════════════════════════════════════════\n";

mysqli_close($db);
?>