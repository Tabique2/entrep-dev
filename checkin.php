<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);

$host = "localhost";
$db = "enterprise";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed"]);
    exit;
}

$username = $conn->real_escape_string($data['username']);
$date = $conn->real_escape_string($data['date']);
$action = $data['action'];

if ($action === 'add') {
    $stmt = $conn->prepare("INSERT IGNORE INTO checkins (username, checkin_date) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $date);
    $stmt->execute();
} elseif ($action === 'remove') {
    $stmt = $conn->prepare("DELETE FROM checkins WHERE username = ? AND checkin_date = ?");
    $stmt->bind_param("ss", $username, $date);
    $stmt->execute();
}

echo json_encode(["status" => "ok"]);
