<?php
// Script para verificar y actualizar sponsor_id en contratos

$db = mysqli_connect('localhost', 'root', '', 'grupovivencia');
if (!$db) die('Error: ' . mysqli_connect_error());

// 1. Buscar el admin (Rolando) 
$admin = mysqli_query($db, "SELECT id FROM users WHERE email = 'software.contreras@gmail.com' LIMIT 1");
$admin_id = mysqli_fetch_assoc($admin)['id'] ?? null;

echo "Admin ID: " . ($admin_id ?? 'NO ENCONTRADO') . "\n";

if ($admin_id) {
    // 2. Buscar contratos sin sponsor_id
    $result = mysqli_query($db, "SELECT id, contract_number, customer_id, sponsor_id FROM contracts WHERE sponsor_id IS NULL ORDER BY id DESC");
    
    $count = mysqli_num_rows($result);
    echo "Contratos sin sponsor_id: " . $count . "\n\n";
    
    if ($count > 0) {
        // 3. Actualizar todos los contratos sin sponsor_id con el admin_id
        $update = mysqli_query($db, "UPDATE contracts SET sponsor_id = $admin_id WHERE sponsor_id IS NULL");
        
        if ($update) {
            echo "✓ Contratos actualizados con sponsor_id = $admin_id\n";
            
            // Verificar la actualización
            $verify = mysqli_query($db, "SELECT * FROM contracts WHERE sponsor_id = $admin_id");
            echo "Total contratos con sponsor_id = $admin_id: " . mysqli_num_rows($verify) . "\n";
        } else {
            echo "✗ Error al actualizar: " . mysqli_error($db) . "\n";
        }
    }
}

mysqli_close($db);
?>
