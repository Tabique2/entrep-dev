<?php
// Database configuration
$host = 'localhost';       // Host name (usually 'localhost' for XAMPP, WAMP, etc.)
$username = 'root';        // Default username for local server
$password = '';            // Default password is usually empty
$dbname = 'enterprise';    // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
