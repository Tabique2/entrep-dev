<?php
// File: db_connect.php

$host = 'localhost'; // Your database host
$db   = 'enterprise'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

try {
    // Establish PDO connection to MySQL database
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, stop the script and show error message
    die("Connection failed: " . $e->getMessage());
}
?>
