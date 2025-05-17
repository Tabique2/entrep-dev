<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the message ID from the form
$message_id = $_POST['message_id'];
$user_id = $_SESSION['user_id'];

// Connect to database
$host = "localhost";
$db = "enterprise";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete the message from the database
$stmt = $conn->prepare("DELETE FROM messages WHERE id = ? AND receiver_id = ?");
$stmt->bind_param("ii", $message_id, $user_id); // Ensure that the message belongs to the current user
if ($stmt->execute()) {
    header("Location: message_center.php");  // Redirect to message center after deletion
    exit();
} else {
    echo "Error deleting message.";
}

$stmt->close();
$conn->close();
?>
