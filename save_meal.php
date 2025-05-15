<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo "error: not logged in";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $food_name = $_POST['food_name'];
    $quantity = floatval($_POST['quantity']);
    $food_group = $_POST['food_group'];
    $protein = floatval($_POST['protein']);
    $carbs = floatval($_POST['carbs']);
    $fat = floatval($_POST['fat']);

    $stmt = $conn->prepare("INSERT INTO meal_logs (user_id, food_name, quantity, food_group, protein, carbs, fat) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isdsddd", $user_id, $food_name, $quantity, $food_group, $protein, $carbs, $fat);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
