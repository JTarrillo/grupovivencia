<?php
// Script para arreglar referencias de sesión en D_*.php

$controllers_dir = 'app/Controllers/';
$files = glob($controllers_dir . 'D_*.php');

$replacements = [
    "\$_SESSION['id']" => "\$_SESSION['admin_id']",
    "\$_SESSION['first_name']" => "\$_SESSION['admin_name']",
    "\$_SESSION['last_name']" => "\$_SESSION['admin_lastname']",
    "\$_SESSION['name']" => "\$_SESSION['admin_name']",
    "\$_SESSION['email']" => "\$_SESSION['admin_email']",
    "\$_SESSION['active']" => "\$_SESSION['admin_active']",
    "\$_SESSION['privilegio']" => "\$_SESSION['admin_privilegio']",
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