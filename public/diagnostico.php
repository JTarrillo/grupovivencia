<?php
/**
 * DIAGNÓSTICO DE RUTAS - VIVELAND
 * Accede a: https://grupovivencia.club/diagnostico.php
 */

echo "<h1>🔍 Diagnóstico de Rutas VIVELAND</h1>";
echo "<hr>";

// Información del servidor
echo "<h2>📋 Información del Servidor</h2>";
echo "<pre>";
echo "PHP Version: " . phpversion() . "\n";
echo "Current File: " . __FILE__ . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Current URL: " . "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "\n";
echo "</pre>";

// Verificar directorios
echo "<h2>📁 Estructura de Directorios</h2>";
echo "<pre>";
$dirs = [
    'assets' => '/assets/',
    'assets/css' => '/assets/css/',
    'assets/js' => '/assets/js/',
    'assets/front/img' => '/assets/front/img/',
];

foreach ($dirs as $name => $path) {
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $path;
    $exists = is_dir($fullPath) ? '✅' : '❌';
    echo "$exists $name -> $fullPath\n";
}
echo "</pre>";

// Verificar archivos críticos
echo "<h2>📄 Archivos Críticos</h2>";
echo "<pre>";
$files = [
    'main.css' => '/assets/css/main.css',
    'main.js' => '/assets/js/main.js',
    'carousel.js' => '/assets/js/carousel.js',
    'debug.js' => '/assets/js/debug.js',
];

foreach ($files as $name => $path) {
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $path;
    $exists = file_exists($fullPath) ? '✅' : '❌';
    $size = file_exists($fullPath) ? ' (' . filesize($fullPath) . ' bytes)' : '';
    echo "$exists $name -> $path$size\n";
}
echo "</pre>";

// URLs relativas
echo "<h2>🌐 URLs Relativas</h2>";
echo "<pre>";
$baseUrl = "http://" . $_SERVER['HTTP_HOST'];
$relativePaths = [
    'CSS Principal' => '/assets/css/main.css',
    'JS Carousel' => '/assets/js/carousel.js',
    'JS Main' => '/assets/js/main.js',
    'JS Debug' => '/assets/js/debug.js',
];

foreach ($relativePaths as $name => $path) {
    $fullUrl = $baseUrl . $path;
    echo "$name:\n";
    echo "  Ruta: $path\n";
    echo "  URL Completa: $fullUrl\n\n";
}
echo "</pre>";

// Verificar permisos
echo "<h2>🔐 Permisos de Archivos</h2>";
echo "<pre>";
$testFile = '/assets/css/main.css';
$fullPath = $_SERVER['DOCUMENT_ROOT'] . $testFile;
if (file_exists($fullPath)) {
    $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
    echo "✅ $testFile\n";
    echo "   Permisos: $perms\n";
    echo "   Readable: " . (is_readable($fullPath) ? 'Sí' : 'No') . "\n";
} else {
    echo "❌ $testFile no existe\n";
}
echo "</pre>";

// Resumen
echo "<h2>📊 Resumen</h2>";
echo "<pre>";
echo "Si ves muchos ❌, contacta a soporte con esta información.\n";
echo "Los ✅ indican que todo está en su lugar correcto.\n";
echo "</pre>";

echo "<hr>";
echo "<small style='color: #666;'>Generado: " . date('Y-m-d H:i:s') . "</small>";
?>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background: #f5f5f5;
}
h1, h2 {
    color: #333;
}
pre {
    background: white;
    padding: 15px;
    border-radius: 5px;
    border-left: 4px solid #4A90E2;
    overflow-x: auto;
}
</style>
