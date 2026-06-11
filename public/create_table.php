<?php
$db = new mysqli('localhost', 'root', '', 'grupovivencia');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS `commission_sales` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `report_id` bigint(20) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `manzana` varchar(50) NOT NULL,
  `lote` varchar(50) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `deposit_number` varchar(100) NOT NULL,
  `deposit_amount` decimal(10,2) NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  `commission_amount` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `report_id` (`report_id`),
  CONSTRAINT `commission_sales_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `commission_reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($db->query($sql) === TRUE) {
    echo "Table commission_sales created successfully";
} else {
    echo "Error creating table: " . $db->error;
}
$db->close();
?>