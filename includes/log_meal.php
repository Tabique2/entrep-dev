<?php
session_start();
require_once 'db_connect.php'; // Ensure this is correctly including your DB connection

// Check if the form was submitted via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "error: User not logged in";
        exit(); // Stop the script execution if user is not logged in
    }

    // Retrieve form data
    $user_id = $_SESSION['user_id']; // User ID from session
    $food_name = $_POST['food_name'];
    $quantity = floatval($_POST['quantity']); // Convert to float for precise calculations
    $food_group = $_POST['food_group'];
    $protein = floatval($_POST['protein']);
    $carbs = floatval($_POST['carbs']);
    $fat = floatval($_POST['fat']);

    try {
        // Prepare the SQL statement to insert data into the meal_logs table
        $stmt = $conn->prepare("
            INSERT INTO meal_logs (user_id, food_name, quantity, food_group, protein, carbs, fat) 
            VALUES (:user_id, :food_name, :quantity, :food_group, :protein, :carbs, :fat)
        ");

        // Execute the statement with the provided data
        $stmt->execute([
            ':user_id' => $user_id,
            ':food_name' => $food_name,
            ':quantity' => $quantity,
            ':food_group' => $food_group,
            ':protein' => $protein,
            ':carbs' => $carbs,
            ':fat' => $fat
        ]);

        echo "success"; // Meal was successfully logged

    } catch (PDOException $e) {
        // Catch any PDOException and show an error message
        echo "error: " . $e->getMessage();
    }
}
?>
