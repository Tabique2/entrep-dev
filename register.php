<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) {
        $username = $_POST["register_username"];
        $password = $_POST["register_password"];

        // Placeholder logic — in production, save this to a database
        echo "<script>alert('Account Created Successfully for $username!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url('plateregister.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .box {
            background: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 22px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            color: #fff;
            background: #27ae60;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        input[type="submit"]:hover {
            background: #2ecc71;
        }

        .logo-container img {
            width: 120px;
            height: auto;
            margin-bottom: 25px;
        }

        .toggle {
            margin-top: 20px;
            font-size: 14px;
        }

        .toggle a {
            color: #27ae60;
            text-decoration: none;
            font-weight: bold;
        }

        .toggle a:hover {
            color: #2ecc71;
        }

        .or-container {
            margin: 20px 0;
            font-size: 16px;
        }

        .or-container span {
            color: #333;
        }

        .social-buttons {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .social-buttons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48%;
            height: 40px;
            border-radius: 5px;
            text-decoration: none;
            background-color: #fff; /* White background */
            color: #333; /* Dark text for contrast */
            font-weight: bold;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .social-buttons img {
            width: 20px;
            height: 20px;
            margin-right: 8px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <div class="box" id="registerBox">
        <div class="logo-container">
            <img src="platelogin.png" alt="Register Logo" class="logo-img">
        </div>
        <h2>Create Account</h2>
        <form action="register.php" method="post">
            <input type="text" name="register_username" placeholder="Username" required>
            <input type="password" name="register_password" placeholder="Password" required>
            <input type="submit" name="register" value="Register">
        </form>

        <div class="toggle">
            <p>Already have an account? <a href="index.php">Login here</a></p>
        </div>

        <div class="or-container">
            <span>OR</span>
        </div>

        <div class="social-buttons">
            <a href="https://accounts.google.com" class="gmail-btn">
                <img src="Googleicon.jpg" alt="Gmail Icon">
                <span>Google</span>
            </a>
            <a href="https://www.facebook.com" class="facebook-btn">
                <img src="facebook logo.png" alt="Facebook Icon">
                <span>Facebook</span>
            </a>
        </div>
    </div>
</div>

</body>
</html>
