<?php
$db = new mysqli('localhost', 'root', '', 'grupovivencia');
$db->query('SET FOREIGN_KEY_CHECKS = 0');
$db->query('TRUNCATE TABLE commission_sales');
$db->query('TRUNCATE TABLE commission_reports');
$db->query('SET FOREIGN_KEY_CHECKS = 1');
echo 'Tablas truncadas correctamente.';
$db->close();
?>