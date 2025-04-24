<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login & Create Account</title>
    <style>
        /* Base styling */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #3498db, #8e44ad); /* Gradient background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }
        .box {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 350px;
            transition: all 0.3s ease-in-out;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="submit"],
        .supergreen-btn {
            width: 100%;
            padding: 12px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
            font-size: 16px;
        }
        input[type="submit"] {
            background: #3498db;
            transition: background 0.3s ease;
        }
        input[type="submit"]:hover {
            background: #2980b9;
        }
        .supergreen-btn {
            background: #27ae60;
            transition: background 0.3s ease;
        }
        .supergreen-btn:hover {
            background: #2ecc71;
        }
        .toggle {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
        .toggle a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }
        .toggle a:hover {
            text-decoration: underline;
        }
        .register-link {
            display: none;
            text-align: center;
            margin-top: 20px;
        }
        /* Transition effect when switching between login and register */
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
    </style>
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
        <button type="button" id="showRegisterLink" class="supergreen-btn">Create Account</button>
        
        <div class="toggle">
            <a href="javascript:void(0)" onclick="toggleForm('login')">Already have an account?</a>
        </div>
    </div>

    <!-- Register Box -->
    <div class="box" id="registerBox" style="display: none;">
        <h2>Create Account</h2>
        <form action="index.php" method="post" id="registerForm">
            <input type="text" name="register_name" placeholder="Full Name" required>
            <input type="email" name="register_email" placeholder="Email" required>
            <input type="password" name="register_password" placeholder="Password" required>
            <input type="submit" name="register" value="Register">
        </form>
        
        <div class="toggle">
            <a href="javascript:void(0)" onclick="toggleForm('register')">Already have an account? Login here.</a>
        </div>
    </div>
</div>

<script>
    // Toggle between login and register forms
    function toggleForm(form) {
        if (form === 'login') {
            document.getElementById('loginBox').style.display = 'block';
            document.getElementById('registerBox').style.display = 'none';
        } else if (form === 'register') {
            document.getElementById('loginBox').style.display = 'none';
            document.getElementById('registerBox').style.display = 'block';
        }
    }

    // Show Register Form when "Create Account" is clicked
    document.getElementById('showRegisterLink').addEventListener('click', function() {
        toggleForm('register');  // Switch to Register Form
    });
</script>

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

    // Handle Registration
    if (isset($_POST["register"])) {
        $name = $_POST["register_name"];
        $email = $_POST["register_email"];
        $pass = $_POST["register_password"];

        // Placeholder for registration (you would typically save this data to a database)
        echo "<script>alert('Account Created Successfully for $name!');</script>";
        // You can redirect or process further here (e.g., saving user data in a database)
    }
}
?>

</body>
</html>
