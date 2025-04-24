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
    <link rel="stylesheet" href="style.css"> <!-- Link to the external CSS file -->
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
        
        <div class="toggle">
            <a href="index.php">Already have an account? Login here.</a>
        </div>
    </div>
</div>

</body>
</html>
