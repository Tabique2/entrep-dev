<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== 'user') {
    header("Location: login.php");
    exit();
}

// Connect to database
$host = "localhost";
$db = "enterprise";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Logged-in user ID
$user_id = $_SESSION['user_id'];

// Get list of available dietitians
$dietitians = $conn->query("SELECT id, username FROM users WHERE role = 'dietitian'");

// Fetch received messages
$inbox = $conn->query("
    SELECT m.*, u.username AS sender_name
    FROM messages m
    JOIN users u ON m.sender_id = u.id
    WHERE m.receiver_id = $user_id
    ORDER BY m.sent_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>NutriFit Message Center</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

<h3>💬 NutriFit Message Center</h3>
<a href="user_dashboard.php" class="btn btn-outline-primary mb-4">🏠 Back to Dashboard</a>

<!-- Send Message Form -->
<form action="send_message.php" method="POST" class="mb-4">
  <div class="form-group">
    <label>Send To (Dietitian):</label>
    <select name="receiver_id" class="form-control" required>
      <?php while ($dietitian = $dietitians->fetch_assoc()): ?>
        <option value="<?= $dietitian['id'] ?>"><?= htmlspecialchars($dietitian['username']) ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="form-group">
    <label>Your Message:</label>
    <textarea name="message" class="form-control" rows="4" required></textarea>
  </div>
  <button type="submit" class="btn btn-success">📨 Send</button>
</form>

<!-- Inbox -->
<h5>📥 Inbox (Messages from Dietitians)</h5>
<ul class="list-group">
  <?php if ($inbox && $inbox->num_rows > 0): ?>
    <?php while ($msg = $inbox->fetch_assoc()): ?>
      <li class="list-group-item">
        <strong><?= htmlspecialchars($msg['sender_name']) ?>:</strong>
        <?= htmlspecialchars($msg['message']) ?><br>
        <small class="text-muted"><?= htmlspecialchars($msg['sent_at']) ?></small>
      </li>
    <?php endwhile; ?>
  <?php else: ?>
    <li class="list-group-item text-muted">No messages found.</li>
  <?php endif; ?>
</ul>

</body>
</html>
