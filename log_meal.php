<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$food_name = trim($_POST['food_name']);
$quantity = floatval($_POST['quantity']);
$category = trim($_POST['food_group']);
$protein = floatval($_POST['protein']);
$carbs = floatval($_POST['carbs']);
$fat = floatval($_POST['fat']);

// DB connection
$conn = new mysqli("localhost", "root", "", "enterprise");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert log
$stmt = $conn->prepare("
    INSERT INTO user_logged_meals 
    (user_id, food_name, quantity, category, protein, carbs, fat) 
    VALUES (?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param("isdssss", $user_id, $food_name, $quantity, $category, $protein, $carbs, $fat);

if ($stmt->execute()) {
    $_SESSION['meal_status'] = "Meal logged successfully.";
} else {
    $_SESSION['meal_status'] = "Failed to log meal.";
}

$stmt->close();
$conn->close();

header("Location: user_dashboard.php");
exit();
