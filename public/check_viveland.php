<?php
/**
 * Verificador de archivos VIVELAND - Sube a producción en public/check_viveland.php
 */

echo "<!DOCTYPE html>
<html>
<head>
    <title>Verificador VIVELAND</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .ok { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        h2 { border-bottom: 2px solid #ccc; padding-bottom: 10px; }
        .box { background: #f5f5f5; padding: 10px; margin: 10px 0; border-left: 3px solid #ddd; }
    </style>
</head>
<body>
<h1>Verificador VIVELAND en Producción</h1>
<hr>";

$checks = [];
$baseDir = dirname(__DIR__);

// 1. Verificar archivos del controlador
echo "<h2>1. Controlador</h2>";
$controllerPath = $baseDir . '/app/Controllers/D_viveland_registros.php';
if (file_exists($controllerPath)) {
    echo "<div class='box'><span class='ok'>✅</span> Controlador existe: D_viveland_registros.php</div>";
    $checks['controller'] = true;
} else {
    echo "<div class='box'><span class='error'>❌</span> Falta: app/Controllers/D_viveland_registros.php</div>";
    $checks['controller'] = false;
}

// 2. Verificar modelo
echo "<h2>2. Modelo</h2>";
$modelPath = $baseDir . '/app/Models/VivelandRegistroModel.php';
if (file_exists($modelPath)) {
    echo "<div class='box'><span class='ok'>✅</span> Modelo existe: VivelandRegistroModel.php</div>";
    $checks['model'] = true;
} else {
    echo "<div class='box'><span class='error'>❌</span> Falta: app/Models/VivelandRegistroModel.php</div>";
    $checks['model'] = false;
}

// 3. Verificar vistas
echo "<h2>3. Vistas</h2>";
$viewListPath = $baseDir . '/app/Views/admin/viveland_registros/list.php';
$viewDetailPath = $baseDir . '/app/Views/admin/viveland_registros/view.php';

if (file_exists($viewListPath)) {
    echo "<div class='box'><span class='ok'>✅</span> Vista lista existe: app/Views/admin/viveland_registros/list.php</div>";
    $checks['view_list'] = true;
} else {
    echo "<div class='box'><span class='error'>❌</span> Falta: app/Views/admin/viveland_registros/list.php</div>";
    $checks['view_list'] = false;
}

if (file_exists($viewDetailPath)) {
    echo "<div class='box'><span class='ok'>✅</span> Vista detalle existe: app/Views/admin/viveland_registros/view.php</div>";
    $checks['view_detail'] = true;
} else {
    echo "<div class='box'><span class='error'>❌</span> Falta: app/Views/admin/viveland_registros/view.php</div>";
    $checks['view_detail'] = false;
}

// 4. Verificar BD
echo "<h2>4. Base de Datos</h2>";
try {
    if (function_exists('db_connect')) {
        $db = db_connect();
    } else {
        $db = \Config\Database::connect();
    }
    
    $result = $db->query("SELECT COUNT(*) as total FROM viveland_registros");
    $row = $result->getRow();
    echo "<div class='box'><span class='ok'>✅</span> Tabla viveland_registros existe. Registros: " . $row->total . "</div>";
    $checks['db'] = true;
} catch (\Exception $e) {
    echo "<div class='box'><span class='error'>❌</span> Error BD: " . $e->getMessage() . "</div>";
    $checks['db'] = false;
}

// 5. Resumen
echo "<h2>Resumen</h2>";
$missingFiles = array_filter($checks, function($v) { return !$v; });

if (empty($missingFiles)) {
    echo "<div class='box' style='border-left: 3px solid green;'><span class='ok'>✅ TODO OK</span> - Todos los archivos existen</div>";
} else {
    echo "<div class='box' style='border-left: 3px solid red;'><span class='error'>❌ FALTAN ARCHIVOS</span></div>";
    echo "<p>Archivos faltantes:</p>";
    echo "<ul>";
    if (!$checks['controller']) echo "<li>app/Controllers/D_viveland_registros.php</li>";
    if (!$checks['model']) echo "<li>app/Models/VivelandRegistroModel.php</li>";
    if (!$checks['view_list']) echo "<li>app/Views/admin/viveland_registros/list.php</li>";
    if (!$checks['view_detail']) echo "<li>app/Views/admin/viveland_registros/view.php</li>";
    echo "</ul>";
}

echo "</body>
</html>";
?>
