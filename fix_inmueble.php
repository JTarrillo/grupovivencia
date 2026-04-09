<?php
// Script para actualizar Inmueble.php

$file = 'app/Controllers/Inmueble.php';
$content = file_get_contents($file);

$new_content = str_replace(
    "'session_name' => \$_SESSION['name']",
    "'session_name' => \$_SESSION['admin_name']",
    $content
);

if ($new_content !== $content) {
    file_put_contents($file, $new_content);
    echo "Inmueble.php actualizado correctamente";
} else {
    echo "No se encontraron cambios";
}
?>
