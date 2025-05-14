<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Database connection
$host = "localhost";
$db = "enterprise";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    // 1. CAPTCHA Verification
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $secretKey = '6LfDezQrAAAAALzoUGd3WZd2Ct0ORXedwjBO4Gqn';
    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify";
    $verifyResponse = file_get_contents("$verifyUrl?secret=$secretKey&response=$recaptchaResponse");
    $responseData = json_decode($verifyResponse);

    if (!$responseData->success) {
        echo "<script>alert('Captcha verification failed. Please try again.'); window.location.href='login.php';</script>";
        exit();
    }

    // 2. Credential Verification
    $username = $_POST["login_username"];
    $password = $_POST["login_password"];

    // Fetch both password and role from the database
    $stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashed_password, $role);
        $stmt->fetch();

        // Handle admin login separately for direct password check
        if ($username == 'admin' && $password == 'adminonly') {
            $_SESSION["username"] = $username;
            $_SESSION["role"] = 'admin';
            header("Location: admin_dashboard.php");
            exit();
        }

        // Check password for user login using password_verify()
        if (password_verify($password, $hashed_password)) {
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;

            // Redirect based on role
                    if ($role === 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } elseif ($role === 'dietitian') {
                header("Location: dietitian_dashboard.php");
                exit();
            } else {
                header("Location: dashboard.php");
                exit();
            }

        } else {
            echo "<script>alert('Invalid password.'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href='login.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- HTML Login Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('image/platebackground.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        .logo-container img {
            width: 120px;
            height: auto;
            margin-bottom: 20px;
        }
        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            padding: 0.5rem;
            margin-top: 0.5rem;
        }
        .gmail-btn {
            background-color: #db4437;
        }
        .facebook-btn {
            background-color: #4267b2;
        }
        .btn-social img {
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>

<div class="card text-dark text-center">
    <div class="logo-container">
        <img src="image/platelogin.png" alt="Login Logo">
    </div>
    <h2 class="mb-3">Login</h2>
    <form action="login.php" method="post">
        <div class="mb-3">
            <input type="text" name="login_username" class="form-control" placeholder="Username" required>
        </div>
        <div class="mb-3">
            <input type="password" name="login_password" class="form-control" placeholder="Password" required>
        </div>
        <div class="mb-3 d-flex justify-content-center">
            <div class="g-recaptcha" data-sitekey="6LfDezQrAAAAAAYlNZx5iLWnZEMDztRcwYz3a5ns"></div>
        </div>
        <button type="submit" name="login" class="btn btn-success w-100">Login</button>
    </form>

    <div class="mt-3">
        <p>Don't have an account? <a href="register.php" class="text-success fw-bold">Sign Up</a></p>
    </div>

    <hr>

    <div class="d-flex flex-column">
        <a href="https://accounts.google.com" class="btn-social gmail-btn">
            <img src="image/Googleicon.jpg" alt="Gmail Icon"> Google
        </a>
        <a href="https://www.facebook.com" class="btn-social facebook-btn">
            <img src="image/facebook logo.png " alt="Facebook Icon"> Facebook
        </a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
