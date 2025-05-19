<?php
session_start();

$host = "localhost";
$db = "enterprise";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in and necessary POST variables are set
if (!isset($_SESSION['user_id']) || !isset($_POST['receiver_id']) || !isset($_POST['message'])) {
    header("Location: login.php");
    exit();
}

$sender_id = $_SESSION['user_id'];
$receiver_id = intval($_POST['receiver_id']);
$message = trim($_POST['message']);

// Check if the message is not empty
if ($message !== "") {
    // Prepare the SQL statement to insert the message
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    if ($stmt->execute()) {
        // Set a success message in the session
        $_SESSION['message_status'] = "Message sent successfully!";
    } else {
        // Set an error message in the session
        $_SESSION['message_status'] = "Error sending message. Please try again.";
    }
    $stmt->close();
} else {
    // Set an error message if the message is empty
    $_SESSION['message_status'] = "Message cannot be empty.";
}

// Redirect back to the previous page
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
