<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = "localhost";
$db = "enterprise";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Get current user's ID
$username = $_SESSION["username"];
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($userId);
$stmt->fetch();
$stmt->close();

if (!$userId) {
    die("User ID not found.");
}

// Function to insert dishes into DB
function saveDishes($conn, $userId, $category, $dishes) {
    foreach ($dishes as $dish) {
        // Avoid duplicates
        $check = $conn->prepare("SELECT id FROM user_dish_selections WHERE user_id = ? AND category = ? AND dish_name = ?");
        $check->bind_param("iss", $userId, $category, $dish);
        $check->execute();
        $check->store_result();

        if ($check->num_rows === 0) {
            $insert = $conn->prepare("INSERT INTO user_dish_selections (user_id, category, dish_name, selected_at) VALUES (?, ?, ?, NOW())");
            $insert->bind_param("iss", $userId, $category, $dish);
            $insert->execute();
            $insert->close();
        }

        $check->close();
    }
}

// Save selections to SESSION and DB
if (isset($_POST['selected_dishes'])) {
    $_SESSION['selected_vegetables'] = $_POST['selected_dishes'];
    saveDishes($conn, $userId, 'vegetable', $_POST['selected_dishes']);
    $_SESSION['message'] = "Vegetable selection saved successfully!";
}

if (isset($_POST['selected_meats'])) {
    $_SESSION['selected_meats'] = $_POST['selected_meats'];
    saveDishes($conn, $userId, 'meat', $_POST['selected_meats']);
    $_SESSION['message'] = "Meat selection saved successfully!";
}

if (isset($_POST['selected_proteins'])) {
    $_SESSION['selected_proteins'] = $_POST['selected_proteins'];
    saveDishes($conn, $userId, 'protein', $_POST['selected_proteins']);
    $_SESSION['message'] = "Protein selection saved successfully!";
}

$conn->close();

// Redirect back
header("Location: " . $_SERVER["HTTP_REFERER"]);
exit();
?>
