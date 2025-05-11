<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

$host = "localhost";
$db = "ep";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // LOGIN
    if (isset($_POST["login"])) {
        $username = $_POST["login_username"];
        $password = $_POST["login_password"];

        // Fetch both password and role
        $stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($hashed_password, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION["username"] = $username;
                $_SESSION["role"] = $role;

                if ($role === 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit();
            } else {
                echo "<script>alert('Invalid password.'); window.location.href='login.php';</script>";
            }
        } else {
            echo "<script>alert('User not found.'); window.location.href='login.php';</script>";
        }

        $stmt->close();
    }

    // REGISTER
    if (isset($_POST["register"])) {
        $username = $_POST["register_username"];
        $password = $_POST["register_password"];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Account Created Successfully for $username!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='login.php';</script>";
        }

        $stmt->close();
    }

    $conn->close();

} else {
    // Redirect to login form if accessed directly
    header("Location: login.php");
    exit();
}
?>
