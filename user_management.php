<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Ensure only admins can access
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

// Save admin ID to prevent self-delete
$currentAdminId = $_SESSION['user_id'] ?? 0;

// Handle deletion
if (isset($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];
    if ($deleteId == $currentAdminId) {
        echo "<script>alert('You cannot delete your own account.'); window.location.href='user_management.php';</script>";
        exit();
    }
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('User deleted successfully.'); window.location.href='user_management.php';</script>";
}

// Handle new user creation
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['create_user'])) {
    $new_username = $_POST['new_username'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $new_role = $_POST['new_role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $new_username, $new_password, $new_role);
    if ($stmt->execute()) {
        echo "<script>alert('New user created.'); window.location.href='user_management.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// Fetch all users
$stmt = $conn->prepare("SELECT id, username, role FROM users");
$stmt->execute();
$result = $stmt->get_result();

// Separate users into admins and regular users
$admins = [];
$users = [];

while ($row = $result->fetch_assoc()) {
    if ($row['role'] === 'admin') {
        $admins[] = $row;
    } else {
        $users[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Admin - User Management</h2>

    <!-- Create New User Form -->
    <div class="card p-4 mb-4">
        <h4>Create New User</h4>
        <form method="POST" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="new_username" class="form-control" placeholder="Username" required>
            </div>
            <div class="col-md-4">
                <input type="password" name="new_password" class="form-control" placeholder="Password" required>
            </div>
            <div class="col-md-2">
                <select name="new_role" class="form-select" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" name="create_user" class="btn btn-primary w-100">Add</button>
            </div>
        </form>
    </div>

    <!-- Admin Users List -->
    <div class="card p-4 mb-4">
        <h4>Admin Users</h4>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($admins as $admin) { ?>
                <tr>
                    <td><?= htmlspecialchars($admin['id']) ?></td>
                    <td><?= htmlspecialchars($admin['username']) ?></td>
                    <td><?= ucfirst(htmlspecialchars($admin['role'])) ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $admin['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <?php if ($admin['id'] != $currentAdminId): ?>
                            <a href="user_management.php?delete=<?= $admin['id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Delete this user?');">Delete</a>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-sm" disabled>Protected</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Regular Users List -->
    <div class="card p-4">
        <h4>Regular Users</h4>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= ucfirst(htmlspecialchars($user['role'])) ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="user_management.php?delete=<?= $user['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this user?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Back Button to go to the Admin Dashboard -->
    <div class="text-start mb-3">
        <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <div class="text-end mb-3">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
