<?php
// hs.php - Script para actualizar la contraseña de un usuario por su código
// Uso: http://localhost:8081/hs.php?code=51001GSA&password=nueva_contraseña

// Configuración de conexión
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'rere';

// Obtener parámetros
$code = isset($_GET['code']) ? $_GET['code'] : '';
$password = isset($_GET['password']) ? $_GET['password'] : '';

if (!$code || !$password) {
    die('Faltan parámetros: code y password');
}

// Conexión
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

// Encriptar la contraseña
$hash = password_hash($password, PASSWORD_DEFAULT);

// Actualizar contraseña
$sql = "UPDATE customers SET password = '$hash' WHERE code = '$code'";
if ($conn->query($sql) === TRUE) {
    echo 'Contraseña actualizada correctamente para el código: ' . htmlspecialchars($code);
} else {
    echo 'Error al actualizar: ' . $conn->error;
}

$conn->close();
?>