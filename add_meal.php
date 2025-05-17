<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Only allow logged-in dietitians
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'dietitian') {
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

$dietitianId = $_SESSION['user_id'];

// Handle meal input for the health calendar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['meal_name'], $_POST['meal_category'], $_POST['meal_date'])) {
    $user_id = intval($_POST['user_id']);
    $meal_name = trim($_POST['meal_name']);
    $meal_category = trim($_POST['meal_category']);
    $meal_date = $_POST['meal_date'];
    
    if ($user_id && $meal_name && $meal_category && $meal_date) {
        // Insert meal into the user_meals table
        $stmt = $conn->prepare("INSERT INTO user_meals (user_id, dietitian_id, meal_name, meal_category, meal_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $user_id, $dietitianId, $meal_name, $meal_category, $meal_date);
        $stmt->execute();
        $stmt->close();
        $_SESSION['message_status'] = "Meal added successfully.";
    } else {
        $_SESSION['message_status'] = "Please fill in all fields.";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch users
$userQuery = "SELECT id, username FROM users WHERE role = 'user'";
$userResult = $conn->query($userQuery);

// Fetch meals for the health calendar
$mealQuery = "
    SELECT um.id, u.username, um.meal_name, um.meal_category, um.meal_date 
    FROM user_meals um
    JOIN users u ON um.user_id = u.id
    WHERE um.dietitian_id = ?
    ORDER BY um.meal_date DESC
";
$stmt = $conn->prepare($mealQuery);
$stmt->bind_param("i", $dietitianId);
$stmt->execute();
$mealResult = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dietitian Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .header { background-color: #20c997; color: white; padding: 1rem 2rem; border-bottom: 4px solid #17a589; }
        .section-card { background: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05); padding: 20px; margin-bottom: 30px; }
    </style>
</head>
<body>

<div class="header d-flex justify-content-between align-items-center">
    <h3 class="mb-0">Dietitian Dashboard</h3>
    <div>
        <span class="me-3">👋 Hello, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
</div>

<div class="container mt-4">
    <?php if (isset($_SESSION['message_status'])): ?>
        <div class="alert alert-info"><?= $_SESSION['message_status']; unset($_SESSION['message_status']); ?></div>
    <?php endif; ?>

    <!-- Add Meal Form -->
    <div class="section-card">
        <h4>🍽️ Add Meal to Health Calendar</h4>
        <form method="POST">
            <div class="mb-3">
                <label for="user_id" class="form-label">Select User</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">Select a user</option>
                    <?php while ($user = $userResult->fetch_assoc()): ?>
                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['username']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="meal_name" class="form-label">Meal Name</label>
                <input type="text" name="meal_name" id="meal_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="meal_category" class="form-label">Meal Category</label>
                <input type="text" name="meal_category" id="meal_category" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="meal_date" class="form-label">Meal Date</label>
                <input type="date" name="meal_date" id="meal_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Meal</button>
        </form>
    </div>

    <!-- Display Meals -->
    <div class="section-card">
        <h4>📅 Health Calendar</h4>
        <?php if ($mealResult->num_rows > 0): ?>
            <table class="table table-bordered text-center">
                <thead class="table-secondary">
                    <tr><th>User</th><th>Meal</th><th>Category</th><th>Date</th></tr>
                </thead>
                <tbody>
                    <?php while ($meal = $mealResult->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($meal['username']) ?></td>
                            <td><?= htmlspecialchars($meal['meal_name']) ?></td>
                            <td><?= htmlspecialchars($meal['meal_category']) ?></td>
                            <td><?= htmlspecialchars($meal['meal_date']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No meals added yet.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
