<?php
// Script para arreglar referencias de sesión en B_*.php

$controllers_dir = 'app/Controllers/';
$files = glob($controllers_dir . 'B_*.php');

$replacements = [
    "\$_SESSION['id']" => "\$_SESSION['client_id']",
    "\$_SESSION['name']" => "\$_SESSION['client_name']",
    "\$_SESSION['lastname']" => "\$_SESSION['client_lastname']",
    "\$_SESSION['email']" => "\$_SESSION['client_email']",
    "\$_SESSION['dni']" => "\$_SESSION['client_dni']",
    "\$_SESSION['active']" => "\$_SESSION['client_active']",
];

$count = 0;
foreach ($files as $file) {
    $content = file_get_contents($file);
    $new_content = $content;
    
    foreach ($replacements as $old => $new) {
        $new_content = str_replace($old, $new, $new_content);
    }
    
    if ($new_content !== $content) {
        file_put_contents($file, $new_content);
        $count++;
        echo "Actualizado: " . basename($file) . PHP_EOL;
    }
}

echo PHP_EOL . "Total archivos actualizados: $count" . PHP_EOL;
?>
