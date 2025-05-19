<?php
// diet_plan.php
include('db_connection.php'); // Include your database connection

if (isset($_GET['username']) && isset($_GET['date'])) {
    $username = $_GET['username'];
    $date = $_GET['date'];

    // Query the diet plan for this user on the selected date
    $sql = "SELECT meal_time, dish_name FROM diet_plans 
            WHERE user_id = (SELECT id FROM users WHERE username = ?) AND meal_date = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $date]);
    $dietPlan = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($dietPlan);
}
?>
