<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION['role'] !== 'dietitian') {
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
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users (to assign diet plans)
$userQuery = "SELECT id, username FROM users WHERE role = 'user'";
$result = $conn->query($userQuery);

// Fetch all available dishes (or you can customize this by category)
$dishQuery = "SELECT id, dish_name FROM dishes";  // Assuming a 'dishes' table
$dishResult = $conn->query($dishQuery);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $userId = intval($_POST['user_id']);
    $mealDate = $_POST['meal_date'];
    $mealTime = $_POST['meal_time'];
    $dishId = intval($_POST['dish_id']);
    $createdBy = $_SESSION['user_id'];  // Dietitian's ID

    // Insert into diet_plans table
    $stmt = $conn->prepare("INSERT INTO diet_plans (user_id, meal_date, meal_time, dish_name, created_by) VALUES (?, ?, ?, (SELECT dish_name FROM dishes WHERE id = ?), ?)");
    $stmt->bind_param("issii", $userId, $mealDate, $mealTime, $dishId, $createdBy);
    $stmt->execute();
    $stmt->close();
    $_SESSION['message_status'] = "Diet plan assigned successfully!";
    header("Location: assign_diet_plan.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assign Diet Plan</title>
</head>
<body>
    <h2>Assign Diet Plan</h2>
    <form method="POST">
        <label for="user_id">Select User:</label>
        <select name="user_id" required>
            <?php while ($user = $result->fetch_assoc()): ?>
                <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['username']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="meal_date">Select Meal Date:</label>
        <input type="date" name="meal_date" required><br><br>

        <label for="meal_time">Select Meal Time:</label>
        <select name="meal_time" required>
            <option value="breakfast">Breakfast</option>
            <option value="lunch">Lunch</option>
            <option value="dinner">Dinner</option>
            <option value="snack">Snack</option>
        </select><br><br>

        <label for="dish_id">Select Dish:</label>
        <select name="dish_id" required>
            <?php while ($dish = $dishResult->fetch_assoc()): ?>
                <option value="<?= $dish['id'] ?>"><?= htmlspecialchars($dish['dish_name']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit">Assign Meal</button>
    </form>

    <?php
    if (isset($_SESSION['message_status'])) {
        echo "<div class='message'>{$_SESSION['message_status']}</div>";
        unset($_SESSION['message_status']);
    }
    ?>
</body>
</html>

<?php $conn->close(); ?>
