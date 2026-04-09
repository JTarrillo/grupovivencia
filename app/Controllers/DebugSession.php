<?php
namespace App\Controllers;

class DebugSession extends BaseController
{
    public function index()
    {
        $session = session();
        
        // Mostrar todas las variables de sesión
        echo "<pre>";
        echo "=== VARIABLES DE SESIÓN ===\n\n";
        
        echo "client_id: " . $session->get('client_id') . "\n";
        echo "client_name: " . $session->get('client_name') . "\n";
        echo "client_dni: " . $session->get('client_dni') . "\n";
        echo "client_isLoggedIn: " . $session->get('client_isLoggedIn') . "\n";
        echo "\n";
        echo "admin_id: " . $session->get('admin_id') . "\n";
        echo "admin_name: " . $session->get('admin_name') . "\n";
        echo "admin_isLoggedIn: " . $session->get('admin_isLoggedIn') . "\n";
        echo "\n";
        echo "=== DUMP COMPLETO ===\n";
        print_r($_SESSION);
        echo "</pre>";
    }
}
?>
