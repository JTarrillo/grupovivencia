<?php
// Script para arreglar referencias de sesión en vistas

function getAllPhpFiles($dir) {
    $result = [];
    $cdir = scandir($dir);
    foreach ($cdir as $key => $value) {
        if (!in_array($value, ['.', '..'])) {
            $path = $dir . '/' . $value;
            if (is_dir($path)) {
                $result = array_merge($result, getAllPhpFiles($path));
            } else if (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                $result[] = $path;
            }
        }
    }
    return $result;
}

$views_dir = 'app/Views/';
$files = getAllPhpFiles($views_dir);

$client_replacements = [
    "\$_SESSION['id']" => "\$_SESSION['client_id']",
    "\$_SESSION['name']" => "\$_SESSION['client_name']",
    "\$_SESSION['lastname']" => "\$_SESSION['client_lastname']",
    "\$_SESSION['email']" => "\$_SESSION['client_email']",
    "\$_SESSION['dni']" => "\$_SESSION['client_dni']",
    "\$_SESSION['active']" => "\$_SESSION['client_active']",
];

$admin_replacements = [
    "echo \$_SESSION['first_name']" => "echo \$_SESSION['admin_name']",
    "echo \$_SESSION['last_name']" => "echo \$_SESSION['admin_lastname']",
];

$count = 0;
foreach ($files as $file) {
    if (!is_file($file)) continue;
    
    $content = file_get_contents($file);
    $new_content = $content;
    
    // Check if la vista es de backoffice o admin
    $is_admin = strpos($file, 'admin') !== false;
    
    if ($is_admin) {
        foreach ($admin_replacements as $old => $new) {
            $new_content = str_replace($old, $new, $new_content);
        }
    }
    
    // Apply client replacements to backoffice
    if (strpos($file, 'backoffice') !== false) {
        foreach ($client_replacements as $old => $new) {
            $new_content = str_replace($old, $new, $new_content);
        }
    }
    
    if ($new_content !== $content) {
        file_put_contents($file, $new_content);
        $count++;
        echo "Actualizado: " . str_replace('app/Views/', '', $file) . PHP_EOL;
    }
}

echo PHP_EOL . "Total vistas actualizadas: $count" . PHP_EOL;
?>
