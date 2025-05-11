<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Ensure only admins can access
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Admin Dashboard</h2>

    <div class="card p-4 mb-4">
        <h4>Welcome, Admin</h4>
        <p>Choose an option to manage the system:</p>
        <a href="user_management.php" class="btn btn-primary">Manage Users</a>
    </div>

  

    <div class="text-end mb-3">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
