<?php
session_start();

$host = "localhost";
$db = "enterprise";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Logged-in user ID
$user_id = $_SESSION['user_id'];

// Get list of available dietitians
$dietitians = $conn->query("SELECT id, username FROM users WHERE role = 'dietitian'");

// Fetch received messages
$inbox = $conn->query("SELECT m.*, u.username AS sender_name FROM messages m JOIN users u ON m.sender_id = u.id WHERE m.receiver_id = $user_id ORDER BY m.sent_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>NutriFit Message Center</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', sans-serif;
    }
    .container {
        margin-top: 40px;
    }
    .reply-form {
        display: none;
        margin-top: 10px;
    }
  </style>
</head>
<body class="container">

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
        <small class="text-muted"><?= htmlspecialchars($msg['sent_at']) ?></small><br>
        
        <!-- Reply Button -->
        <button class="btn btn-link btn-sm" onclick="toggleReplyForm(<?= $msg['id'] ?>)">Reply</button>

        <!-- Reply Form (Initially Hidden) -->
        <div id="reply-form-<?= $msg['id'] ?>" class="reply-form">
            <form action="send_message.php" method="POST">
                <input type="hidden" name="sender_id" value="<?= $_SESSION['user_id'] ?>">
                <input type="hidden" name="receiver_id" value="<?= $msg['sender_id'] ?>">
                <textarea name="message" class="form-control" rows="3" required placeholder="Your reply..."></textarea>
                <button type="submit" class="btn btn-primary mt-2">Send Reply</button>
            </form>
        </div>
        
        <!-- Delete Button -->
        <form action="delete_message.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');" style="display:inline;">
            <input type="hidden" name="message_id" value="<?= $msg['id'] ?>">
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
      </li>
    <?php endwhile; ?>
  <?php else: ?>
    <li class="list-group-item text-muted">No messages found.</li>
  <?php endif; ?>
</ul>

<script>
function toggleReplyForm(messageId) {
    var form = document.getElementById('reply-form-' + messageId);
    form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
}
</script>

</body>
</html>
