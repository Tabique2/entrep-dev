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

// Fetch users
$userQuery = "SELECT id, username, role FROM users WHERE role = 'user'";
$result = $conn->query($userQuery);

// Fetch user health info
$healthQuery = "SELECT user_id, weight, height FROM user_health_info";
$healthResult = $conn->query($healthQuery);
$bmiData = [];
while ($healthRow = $healthResult->fetch_assoc()) {
    if ($healthRow['height'] > 0) {
        $bmiData[$healthRow['user_id']] = $healthRow['weight'] / ($healthRow['height'] ** 2);
    }
}

// Fetch dish selections
$dishQuery = "
    SELECT u.username, d.category, d.dish_name, d.selected_at
    FROM user_dish_selections d
    JOIN users u ON d.user_id = u.id
    ORDER BY d.selected_at DESC
";
$dishResult = $conn->query($dishQuery);

// Fetch messages for the dietitian (Inbox)
$dietitianId = $_SESSION['user_id']; // Assuming the dietitian's user ID is stored in session
$messageQuery = "
    SELECT m.id, u.username AS sender_username, m.message, m.sent_at
    FROM messages m
    JOIN users u ON m.sender_id = u.id
    WHERE m.receiver_id = $dietitianId
    ORDER BY m.sent_at DESC
";
$messageResult = $conn->query($messageQuery);

// Handle sending message (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['message'])) {
    $receiver_id = $_POST['user_id']; // The user to send the message to
    $message = trim($_POST['message']);
    
    if ($message !== "") {
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $dietitianId, $receiver_id, $message);
        $stmt->execute();
        $stmt->close();
        $_SESSION['message_status'] = "Message sent successfully!";
    } else {
        $_SESSION['message_status'] = "Message cannot be empty.";
    }

    // Redirect back to the Dietitian Dashboard after sending the message
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dietitian Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }
        .header {
            background-color: #20c997;
            color: white;
            padding: 1rem 2rem;
            border-bottom: 4px solid #17a589;
        }
        .section-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            padding: 20px;
            margin-bottom: 30px;
        }
        .table thead {
            background-color: #343a40;
            color: white;
        }
        .table-secondary thead {
            background-color: #6c757d;
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header d-flex justify-content-between align-items-center">
    <h3 class="mb-0">Dietitian Dashboard</h3>
    <div>
        <span class="me-3">👋 Hello, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
</div>

<div class="container mt-4">

    <!-- Display any session message -->
    <?php if (isset($_SESSION['message_status'])): ?>
        <div class="alert alert-info"><?= $_SESSION['message_status']; unset($_SESSION['message_status']); ?></div>
    <?php endif; ?>

    <!-- User List -->
    <div class="section-card">
        <h4 class="mb-3">📋 Registered Users</h4>
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= ucfirst(htmlspecialchars($row['role'])) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- BMI Data -->
    <div class="section-card">
        <h4 class="mb-3">📊 BMI Information</h4>
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>BMI</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($bmiData)): ?>
                <?php foreach ($bmiData as $userId => $bmi): ?>
                    <tr>
                        <td><?= htmlspecialchars($userId) ?></td>
                        <td><?= number_format($bmi, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="2">No BMI data available.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Dish Selections -->
    <div class="section-card">
        <h4 class="mb-3">🍽️ Recent Dish Selections</h4>
        <?php if ($dishResult && $dishResult->num_rows > 0): ?>
            <table class="table table-bordered text-center table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th>Username</th>
                        <th>Category</th>
                        <th>Dish</th>
                        <th>Selected At</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $dishResult->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= ucfirst(htmlspecialchars($row['category'])) ?></td>
                        <td><?= htmlspecialchars($row['dish_name']) ?></td>
                        <td><?= htmlspecialchars($row['selected_at']) ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No dish selections found.</div>
        <?php endif; ?>
    </div>

    <!-- Message Sending Form -->
    <div class="section-card">
        <h4 class="mb-3">📬 Send a Message</h4>
        <form action="dietitian_dashboard.php" method="POST">
            <div class="mb-3">
                <label for="user_id" class="form-label">Select User</label>
                <select class="form-select" id="user_id" name="user_id" required>
                    <?php
                    // Fetch the users list to send a message to
                    $userListQuery = "SELECT id, username FROM users WHERE role = 'user'";
                    $userListResult = $conn->query($userListQuery);
                    while ($user = $userListResult->fetch_assoc()) {
                        echo "<option value=\"" . $user['id'] . "\">" . htmlspecialchars($user['username']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>

    <!-- Inbox -->
    <div class="section-card">
        <h4 class="mb-3">📥 Inbox</h4>
        <?php if ($messageResult && $messageResult->num_rows > 0): ?>
            <table class="table table-bordered table-striped text-center">
                <thead class="table-secondary">
                    <tr>
                        <th>Sender</th>
                        <th>Message</th>
                        <th>Sent At</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($message = $messageResult->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($message['sender_username']) ?></td>
                        <td><?= htmlspecialchars($message['message']) ?></td>
                        <td><?= htmlspecialchars($message['sent_at']) ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No messages in your inbox.</div>
        <?php endif; ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
