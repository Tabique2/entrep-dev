<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
            background-image: url('PLATE LOGIN.png'); /* Set image as background */
            background-size: cover; /* Make sure the image covers the entire screen */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent repeating the image */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .box {
            background: rgba(255, 255, 255, 0.7); /* Semi-transparent white background for the form */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            color: #fff;
            background: #27ae60; /* Green color for the submit button */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background: #2ecc71; /* Lighter green on hover */
        }

        .logo-container img {
            width: 120px;
            margin-bottom: 20px;
        }

        .toggle {
            margin-top: 20px;
            font-size: 16px;
        }

        .toggle a {
            color: #27ae60;
            text-decoration: none;
            font-weight: bold;
        }

        .toggle a:hover {
            color: #2ecc71;
        }
    </style>
</head>
<body>

<div class="form-container">
    <!-- Register Box -->
    <div class="box" id="registerBox">
        <h2>Create Account</h2>
        <form action="register.php" method="post" id="registerForm">
            <input type="text" name="register_name" placeholder="Full Name" required>
            <input type="email" name="register_email" placeholder="Email" required>
            <input type="password" name="register_password" placeholder="Password" required>
            <input type="submit" name="register" value="Register">
        </form>
        
        <!-- Toggle Login Link -->
        <div class="toggle">
            <a href="index.php">Already have an account? Login here.</a>
        </div>
    </div>
</div>

</body>
</html>
