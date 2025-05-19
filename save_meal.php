<?php
session_start();
require_once 'db.php';

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

    // 🔴 Insert into your original table (meal_logs)
    $stmt1 = $conn->prepare("INSERT INTO meal_logs (user_id, food_name, quantity, food_group, protein, carbs, fat) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("isdsddd", $user_id, $food_name, $quantity, $food_group, $protein, $carbs, $fat);

    // ✅ Insert into user_logged_meals too
    $stmt2 = $conn->prepare("INSERT INTO user_logged_meals (user_id, food_name, quantity, category, protein, carbs, fat) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param("isdsddd", $user_id, $food_name, $quantity, $food_group, $protein, $carbs, $fat);

    // Execute both inserts
    $success1 = $stmt1->execute();
    $success2 = $stmt2->execute();

    if ($success1 && $success2) {
        echo "success";
    } else {
        echo "error: ";
        if (!$success1) echo "meal_logs: " . $stmt1->error . " ";
        if (!$success2) echo "user_logged_meals: " . $stmt2->error;
    }

    $stmt1->close();
    $stmt2->close();
    $conn->close();
}
?>
