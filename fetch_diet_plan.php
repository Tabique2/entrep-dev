// fetch_diet_plan.php
<?php
session_start();
include('db.php');  // Include the database connection

if (!isset($_SESSION["username"])) {
    echo json_encode(["error" => "Not logged in"]);
    exit();
}

$username = $_SESSION['username'];
$date = $_GET['date']; // The date passed via query parameter

// Function to fetch diet plan from the database
function fetchDietPlan($username, $date, $conn) {
    $stmt = $conn->prepare("SELECT diet_plan FROM diet_plans WHERE username = ? AND meal_date = ?");
    $stmt->bind_param("ss", $username, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

$dietPlan = fetchDietPlan($username, $date, $conn);
if ($dietPlan) {
    echo json_encode($dietPlan);
} else {
    echo json_encode(["diet_plan" => ""]);
}
?>
