<?php
$db = new mysqli('localhost', 'root', '', 'grupovivencia');
$result = $db->query("SHOW CREATE TABLE commission_reports");
$row = $result->fetch_assoc();
echo $row['Create Table'];
$db->close();
?>