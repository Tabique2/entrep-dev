<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Ensure admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$db = "ep";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from URL
if (!isset($_GET['id'])) {
    echo "No user selected.";
    exit();
}

$user_id = $_GET['id'];

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST["username"];
    $new_password = $_POST["password"];
    $new_role = $_POST["role"];

    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssi", $new_username, $hashed_password, $new_role, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssi", $new_username, $new_role, $user_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully.'); window.location.href='admin_dashboard.php';</script>";
        exit();
    } else {
        echo "Error updating user: " . $stmt->error;
    }
    $stmt->close();
}

// Get existing user data
$stmt = $conn->prepare("SELECT username, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $role);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .position-relative {
            position: relative;
        }
    </style>
</head>
<body class="container mt-5">
    <h2>Edit User</h2>
    <form method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" class="form-control" id="username" value="<?php echo htmlspecialchars($username); ?>" required>
        </div>
        <div class="mb-3 position-relative">
            <label for="password" class="form-label">New Password (leave blank to keep current):</label>
            <input type="password" name="password" class="form-control" id="password">
            <span class="eye-icon" onclick="togglePasswordVisibility()">
                👁️
            </span>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role:</label>
            <select name="role" class="form-select" id="role">
                <option value="user" <?php echo ($role == 'user') ? 'selected' : ''; ?>>User</option>
                <option value="admin" <?php echo ($role == 'admin') ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update User</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Back</a>
    </form>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            passwordInput.type = passwordInput.type === "password" ? "text" : "password";
        }
    </script>
</body>
</html>
