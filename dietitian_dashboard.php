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

// Handle deletion of messages
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_message_id'])) {
    $deleteId = intval($_POST['delete_message_id']);
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ? AND receiver_id = ?");
    $stmt->bind_param("ii", $deleteId, $dietitianId);
    $stmt->execute();
    $stmt->close();
    $_SESSION['message_status'] = "Message deleted.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle dish removal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_dish_id'])) {
    $deleteDishId = intval($_POST['delete_dish_id']);
    $stmt = $conn->prepare("DELETE FROM user_dish_selections WHERE id = ?");
    $stmt->bind_param("i", $deleteDishId);
    $stmt->execute();
    $stmt->close();
    $_SESSION['message_status'] = "Dish removed.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle meal log deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_meal_log_id'])) {
    $deleteLogId = intval($_POST['delete_meal_log_id']);
    $stmt = $conn->prepare("DELETE FROM user_logged_meals WHERE id = ?");
    $stmt->bind_param("i", $deleteLogId);
    $stmt->execute();
    $stmt->close();
    $_SESSION['message_status'] = "Meal log deleted.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle sending or replying to message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['message'])) {
    $receiver_id = intval($_POST['user_id']);
    $message = trim($_POST['message']);
    if ($message !== "") {
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $dietitianId, $receiver_id, $message);
        $stmt->execute();
        $stmt->close();
        $_SESSION['message_status'] = "Message sent.";
    } else {
        $_SESSION['message_status'] = "Message cannot be empty.";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle adding meal to user calendar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_meal_btn'])) {
    $mealUserId = intval($_POST['meal_user_id']);
    $mealDate = $_POST['meal_date'];
    $mealTime = $_POST['meal_time'];
    $mealPlan = trim($_POST['meal_plan']);

    if (!empty($mealPlan) && !empty($mealDate) && !empty($mealTime)) {
        $stmt = $conn->prepare("
            INSERT INTO diet_plans (user_id, meal_date, meal_time, dish_name, created_by, date)
            VALUES (?, ?, ?, ?, ?, CURDATE())
            ON DUPLICATE KEY UPDATE dish_name = VALUES(dish_name), date = CURDATE()
        ");
        $stmt->bind_param("isssi", $mealUserId, $mealDate, $mealTime, $mealPlan, $dietitianId);
        $stmt->execute();
        $stmt->close();
        $_SESSION['message_status'] = "Meal added to user's calendar.";
    } else {
        $_SESSION['message_status'] = "All meal details are required.";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch users
$userQuery = "SELECT id, username, role FROM users WHERE role = 'user'";
$result = $conn->query($userQuery);

// Fetch health info
$healthQuery = "SELECT user_id, weight, height FROM user_health_info";
$healthResult = $conn->query($healthQuery);
$bmiData = [];
while ($row = $healthResult->fetch_assoc()) {
    if ($row['height'] > 0) {
        $bmiData[$row['user_id']] = $row['weight'] / ($row['height'] ** 2);
    }
}

// Fetch dish selections
$dishQuery = "
    SELECT d.id, u.username, d.category, d.dish_name, d.selected_at
    FROM user_dish_selections d
    JOIN users u ON d.user_id = u.id
    ORDER BY d.selected_at DESC
";
$dishResult = $conn->query($dishQuery);

// Fetch messages
$messageQuery = "
    SELECT m.id, u.username AS sender_username, u.id AS sender_id, m.message, m.sent_at
    FROM messages m
    JOIN users u ON m.sender_id = u.id
    WHERE m.receiver_id = $dietitianId
    ORDER BY m.sent_at DESC
";
$messageResult = $conn->query($messageQuery);

// Fetch dietitians
$dietitianResult = $conn->query("SELECT id, username FROM users WHERE role = 'dietitian'");

// Fetch user meal logs
$mealLogQuery = "
    SELECT l.id, u.username, l.food_name, l.quantity, l.category, l.protein, l.carbs, l.fat, l.logged_at
    FROM user_logged_meals l
    JOIN users u ON l.user_id = u.id
    ORDER BY l.logged_at DESC
";
$mealLogs = $conn->query($mealLogQuery);
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
        .table thead { background-color: #343a40; color: white; }
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

    <!-- Users -->
    <div class="section-card">
        <h4>📋 Registered Users</h4>
        <table class="table table-bordered text-center">
            <thead><tr><th>ID</th><th>Username</th><th>Role</th></tr></thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= ucfirst($row['role']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- BMI -->
    <div class="section-card">
        <h4>📊 BMI Information</h4>
        <table class="table table-bordered text-center">
            <thead><tr><th>User ID</th><th>BMI</th></tr></thead>
            <tbody>
                <?php foreach ($bmiData as $userId => $bmi): ?>
                    <tr><td><?= $userId ?></td><td><?= number_format($bmi, 2) ?></td></tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Dietitians -->
    <div class="section-card">
        <h4>👨‍⚕️ Available Dietitians</h4>
        <table class="table table-bordered text-center">
            <thead><tr><th>ID</th><th>Username</th></tr></thead>
            <tbody>
                <?php while ($row = $dietitianResult->fetch_assoc()): ?>
                    <tr><td><?= $row['id'] ?></td><td><?= htmlspecialchars($row['username']) ?></td></tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Dishes -->
    <div class="section-card">
        <h4>🍽️ Dish Selections</h4>
        <table class="table table-bordered text-center">
            <thead><tr><th>User</th><th>Category</th><th>Dish</th><th>Selected At</th><th>Action</th></tr></thead>
            <tbody>
                <?php while ($row = $dishResult->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= ucfirst($row['category']) ?></td>
                        <td><?= htmlspecialchars($row['dish_name']) ?></td>
                        <td><?= $row['selected_at'] ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="delete_dish_id" value="<?= $row['id'] ?>">
                                <button class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Meal -->
    <div class="section-card">
        <h4>📆 Add Meal to User Calendar</h4>
        <form method="POST">
            <div class="row mb-2">
                <div class="col-md-3">
                    <label class="form-label">User</label>
                    <select name="meal_user_id" class="form-select" required>
                        <option value="">Select user</option>
                        <?php
                        $userResult = $conn->query("SELECT id, username FROM users WHERE role = 'user'");
                        while ($u = $userResult->fetch_assoc()):
                        ?>
                            <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['username']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="meal_date" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Meal Time</label>
                    <select name="meal_time" class="form-select" required>
                        <option value="">Select meal time</option>
                        <option value="breakfast">Breakfast</option>
                        <option value="lunch">Lunch</option>
                        <option value="dinner">Dinner</option>
                        <option value="snack">Snack</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Meal Plan</label>
                    <input type="text" name="meal_plan" class="form-control" placeholder="Enter meal details..." required>
                </div>
            </div>
            <button type="submit" name="add_meal_btn" class="btn btn-success">Add Meal</button>
        </form>
    </div>

    <!-- Inbox -->
    <div class="section-card">
        <h4>📥 Inbox</h4>
        <?php if ($messageResult->num_rows > 0): ?>
            <table class="table table-bordered text-center">
                <thead><tr><th>Sender</th><th>Message</th><th>Sent At</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php while ($message = $messageResult->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($message['sender_username']) ?></td>
                            <td><?= htmlspecialchars($message['message']) ?></td>
                            <td><?= $message['sent_at'] ?></td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="delete_message_id" value="<?= $message['id'] ?>">
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                <button class="btn btn-secondary btn-sm" onclick="toggleReplyForm(<?= $message['id'] ?>)">Reply</button>
                                <div id="reply-form-<?= $message['id'] ?>" class="d-none mt-2">
                                    <form method="POST">
                                        <input type="hidden" name="user_id" value="<?= $message['sender_id'] ?>">
                                        <textarea name="message" rows="2" class="form-control mt-1" required></textarea>
                                        <button class="btn btn-primary btn-sm mt-1">Send</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?><p>No messages found.</p><?php endif; ?>
    </div>

    <!-- Meal Logs -->
    <div class="section-card">
        <h4>📘 User Meal Logs</h4>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Food</th>
                    <th>Category</th>
                    <th>Qty</th>
                    <th>Protein (g)</th>
                    <th>Carbs (g)</th>
                    <th>Fat (g)</th>
                    <th>Logged At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($log = $mealLogs->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($log['username']) ?></td>
                        <td><?= htmlspecialchars($log['food_name']) ?></td>
                        <td><?= htmlspecialchars($log['category']) ?></td>
                        <td><?= $log['quantity'] ?></td>
                        <td><?= $log['protein'] ?></td>
                        <td><?= $log['carbs'] ?></td>
                        <td><?= $log['fat'] ?></td>
                        <td><?= $log['logged_at'] ?></td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Delete this meal log?');">
                                <input type="hidden" name="delete_meal_log_id" value="<?= $log['id'] ?>">
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function toggleReplyForm(id) {
    const form = document.getElementById('reply-form-' + id);
    form.classList.toggle('d-none');
}
</script>
</body>
</html>

<?php $conn->close(); ?>
