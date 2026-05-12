<?php
$conn = new mysqli("localhost", "root", "", "grupovivencia");
if ($conn->connect_error) die("Error: " . $conn->connect_error);

$result = $conn->query("DESCRIBE payment_plans");
echo "=== PAYMENT_PLANS TABLE STRUCTURE ===\n";
while ($row = $result->fetch_assoc()) {
    echo "Field: " . $row['Field'] . " | Type: " . $row['Type'] . " | Null: " . $row['Null'] . " | Default: " . $row['Default'] . "\n";
}
$conn->close();
?>
