<?php
session_start();

// Redirect to login if user is not authenticated
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

// Check connection
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

// Function to insert selected dishes (avoiding duplicates)
function saveDishes($conn, $userId, $category, $dishes) {
    foreach ($dishes as $dish) {
        $dish = trim($dish); // Sanitize dish name

        // Check if already selected
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

// Save vegetable selection
if (isset($_POST['selected_dishes']) && is_array($_POST['selected_dishes'])) {
    $_SESSION['selected_vegetables'] = $_POST['selected_dishes'];
    saveDishes($conn, $userId, 'vegetable', $_POST['selected_dishes']);
    $_SESSION['message'] = "Vegetable selection saved successfully!";
}

// Save meat selection
if (isset($_POST['selected_meats']) && is_array($_POST['selected_meats'])) {
    $_SESSION['selected_meats'] = $_POST['selected_meats'];
    saveDishes($conn, $userId, 'meat', $_POST['selected_meats']);
    $_SESSION['message'] = "Meat selection saved successfully!";
}

// Save protein selection
if (isset($_POST['selected_proteins']) && is_array($_POST['selected_proteins'])) {
    $_SESSION['selected_proteins'] = $_POST['selected_proteins'];
    saveDishes($conn, $userId, 'protein', $_POST['selected_proteins']);
    $_SESSION['message'] = "Protein selection saved successfully!";
}

// Close the database connection
$conn->close();

// Redirect back to the referring page or fallback
$redirectTo = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "dashboard.php";
header("Location: $redirectTo");
exit();
?>
