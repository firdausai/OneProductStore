<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = 'db_millenis';

$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

?> 