<?php

$host = 'localhost';
$username = 'root';
$password = ''; // default XAMPP password is empty
$dbname = 'paytabs_integration';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
