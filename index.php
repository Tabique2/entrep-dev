<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle Login
    if (isset($_POST["login"])) {
        $name = $_POST["login_name"];
        $email = $_POST["login_email"];
        $pass = $_POST["login_password"];

        // Placeholder check for login
        if ($email == "admin@example.com" && $pass == "123456") {
            echo "<script>alert('Welcome back, $name! Login Successful.');</script>";
        } else {
            echo "<script>alert('Invalid credentials, $name.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to the external CSS file -->
</head>
<body>

<div class="form-container">
    <!-- Login Box -->
    <div class="box" id="loginBox">
        <h2>Login</h2>
        <form action="index.php" method="post" id="loginForm">
            <input type="text" name="login_name" placeholder="Full Name" required>
            <input type="email" name="login_email" placeholder="Email" required>
            <input type="password" name="login_password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
        </form>
        
        <!-- Create Account Button -->
        <button type="button" id="showRegisterLink" class="supergreen-btn" onclick="window.location.href='register.php'">Create Account</button>
        
        <div class="toggle">
            <a href="javascript:void(0)" onclick="toggleForm('login')">Already have an account?</a>
        </div>
    </div>
</div>

</body>
</html>
