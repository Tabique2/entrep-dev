<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url('platebackground.png'); /* Set image as background */
            background-size: cover; /* Ensure image covers the entire screen */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent repeating the image */
            background-attachment: fixed; /* Keep the background fixed when scrolling */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
            padding-top: 40px; /* Extra space above */
            padding-bottom: 40px; /* Extra space below */
        }

        .box {
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent white background for the form */
            padding: 40px; /* Increased padding for better spacing */
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 300px; /* Set width for the form */
            height: auto; /* Adjust height */
            text-align: center;
            margin: 0 20px; /* Ensure spacing on both sides */
        }

        h2 {
            color: #333;
            margin-bottom: 20px; /* Increased margin for spacing */
            font-size: 22px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px; /* Increased margin */
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
            width: 120px; /* Adjusted logo size */
            height: auto;
            margin-bottom: 25px; /* Increased space below logo */
        }

        .signup-link {
            margin-top: 20px;
            font-size: 14px;
        }

        .signup-link a {
            color: #27ae60;
            text-decoration: none;
            font-weight: bold;
        }

        .signup-link a:hover {
            color: #2ecc71;
        }

        .social-buttons {
            margin-top: 20px;
            font-size: 14px;
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
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .social-buttons img {
            width: 20px;
            height: 20px;
            margin-right: 8px;
            object-fit: contain;
        }

        .gmail-btn {
            background-color: #db4437;
        }

        .facebook-btn {
            background-color: #4267b2;
        }

        .or-container {
            margin: 20px 0;
            font-size: 16px;
        }

        .or-container span {
            color: #333;
        }
    </style>
</head>
<body>

<div class="form-container">
    <!-- Login Box -->
    <div class="box" id="loginBox">
        <div class="logo-container">
            <img src="platelogin.png" alt="Login Logo" class="logo-img">
        </div>
        <h2>Login</h2>
        <form action="index.php" method="post">
            <input type="text" name="login_username" placeholder="Username" required>
            <input type="password" name="login_password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
        </form>
        <!-- Sign Up Link -->
        <div class="signup-link">
            <p>Don't have an account? <a href="register.php">Sign Up</a></p>
        </div>
        
        <!-- OR Section -->
        <div class="or-container">
            <span>OR</span>
        </div>

        <!-- Social Media Signup Options -->
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