<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["login"])) {
        $name = $_POST["login_name"];
        $email = $_POST["login_email"];
        $pass = $_POST["login_password"];

        if ($email === "admin@example.com" && $pass === "123456") {
            echo "<script>alert('Welcome back, $name! Login Successful.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Invalid credentials, $name.'); window.location.href='login.php';</script>";
        }
        exit;
    }

    if (isset($_POST["register"])) {
        $name = $_POST["register_name"];
        $email = $_POST["register_email"];
        $pass = $_POST["register_password"];

        // Save to DB in real app
        echo "<script>alert('Account Created Successfully for $name!'); window.location.href='login.php';</script>";
        exit;
    }

} else {
    // Redirect to login form if accessed directly
    header("Location: login.php");
    exit();
}
?>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["login"])) {
        $name = $_POST["login_name"];
        $email = $_POST["login_email"];
        $pass = $_POST["login_password"];

        if ($email === "admin@example.com" && $pass === "123456") {
            echo "<script>alert('Welcome back, $name! Login Successful.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Invalid credentials, $name.'); window.location.href='login.php';</script>";
        }
        exit;
    }

    if (isset($_POST["register"])) {
        $name = $_POST["register_name"];
        $email = $_POST["register_email"];
        $pass = $_POST["register_password"];

        // Save to DB in real app
        echo "<script>alert('Account Created Successfully for $name!'); window.location.href='login.php';</script>";
        exit;
    }

} else {
    // Redirect to login form if accessed directly
    header("Location: login.php");
    exit();
}
?>
