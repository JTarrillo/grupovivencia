<?php
// Script para migrar datos de planes de pago
// Ejecutar desde la raíz del proyecto

require_once 'app/Config/Database.php';
require_once 'app/Models/PaymentPlanModel.php';

$db = \Config\Database::connect();

// Actualizar planes que no tengan down_payment_type definido
$db->table('payment_plans')
    ->set(['down_payment_type' => 'percentage'])
    ->where('down_payment_type IS NULL')
    ->update();

// Actualizar planes que no tengan min_amount definido
$db->table('payment_plans')
    ->set(['min_amount' => 0])
    ->where('min_amount IS NULL')
    ->update();

echo "✓ Migración completada\n";
echo "✓ Todos los planes tienen down_payment_type = 'percentage' por defecto\n";
echo "✓ Todos los planes tienen min_amount = 0\n";
