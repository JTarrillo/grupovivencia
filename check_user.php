<?php
$config = new \Config\Database();
$db = $config->connect();
$result = $db->query('SELECT id, name, lastname, email, privilage FROM users WHERE email = "coordinador.viveland@grupovivencia.club" LIMIT 1')->getResult();
if ($result) {
    foreach ($result as $row) {
        echo 'ID: ' . $row->id . PHP_EOL;
        echo 'Nombre: ' . $row->name . ' ' . $row->lastname . PHP_EOL;
        echo 'Email: ' . $row->email . PHP_EOL;
        echo 'Privilage: ' . $row->privilage . PHP_EOL;
    }
} else {
    echo 'No existe';
}
