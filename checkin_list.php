<?php
header('Content-Type: application/json');

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

$username = $conn->real_escape_string($_GET['username']);
$result = $conn->query("SELECT checkin_date FROM checkins WHERE username = '$username'");

$dates = [];
while ($row = $result->fetch_assoc()) {
    $dates[] = $row['checkin_date'];
}

echo json_encode($dates);
