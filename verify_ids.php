<?php
$db = mysqli_connect('localhost', 'root', '', 'grupovivencia');

echo "=== USERS (ADMIN) ===\n";
$users = mysqli_query($db, "SELECT id, name, email FROM users LIMIT 5");
while ($user = mysqli_fetch_assoc($users)) {
    echo 'ID: ' . $user['id'] . ' | Name: ' . $user['name'] . ' | Email: ' . $user['email'] . "\n";
}

echo "\n=== CUSTOMERS ===\n";
$customers = mysqli_query($db, "SELECT id, name, dni FROM customers WHERE id = 1");
while ($cust = mysqli_fetch_assoc($customers)) {
    echo 'ID: ' . $cust['id'] . ' | Name: ' . $cust['name'] . ' | DNI: ' . $cust['dni'] . "\n";
}

mysqli_close($db);
?>
