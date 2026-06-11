<?php
$conn = new mysqli("localhost", "root", "", "grupovivencia");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("SHOW COLUMNS FROM commission_reports");
while($row = $result->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}