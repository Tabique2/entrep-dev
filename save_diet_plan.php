<?php
session_start();
include('db.php');  // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $username = $data['username'];
    $date = $data['date'];
    $dietPlan = $data['diet_plan'];

    // Update or insert the diet plan
    $stmt = $conn->prepare("INSERT INTO diet_plans (username, meal_date, diet_plan) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE diet_plan = ?");
    $stmt->bind_param("ssss", $username, $date, $dietPlan, $dietPlan);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['status' => 'success']);
}
?>
