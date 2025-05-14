<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) {
        $username = $_POST["register_username"];
        $password = $_POST["register_password"];
        $role = $_POST["role"];
        $full_name = $_POST["full_name"] ?? '';
        $contact_email = $_POST["contact_email"] ?? '';


        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $conn = new mysqli("localhost", "root", "", "enterprise");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $role);

        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;

            if ($role === "dietitian") {
                $dietStmt = $conn->prepare("INSERT INTO dietitians (user_id, full_name, contact_email) VALUES (?, ?, ?)");
                $dietStmt->bind_param("iss", $user_id, $full_name, $contact_email);

                $dietStmt->execute();
                $dietStmt->close();
            }

            echo "<script>alert('Account created successfully for $username!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function toggleDietitianFields() {
            const role = document.getElementById("role").value;
            const dietitianFields = document.getElementById("dietitianFields");
            dietitianFields.style.display = (role === "dietitian") ? "block" : "none";
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('image/platebackground.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
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

        #dietitianFields {
            display: none;
        }
    </style>
</head>
<body>

<div class="card text-dark text-center">
    <div class="logo-container">
        <img src="image/platelogin.png" alt="Register Logo">
    </div>
    <h2 class="mb-3">Create Account</h2>
    <form action="register.php" method="post">
        <div class="mb-3">
            <input type="text" name="register_username" class="form-control" placeholder="Username" required>
        </div>
        <div class="mb-3">
            <input type="password" name="register_password" class="form-control" placeholder="Password" required>
        </div>
        <div class="mb-3">
            <select name="role" id="role" class="form-select" onchange="toggleDietitianFields()" required>
                <option value="">Select Role</option>
                <option value="user">User</option>
                <option value="dietitian">Dietitian</option>
            </select>
        </div>

        <div id="dietitianFields">
            <div class="mb-3">
                <input type="text" name="full_name" class="form-control" placeholder="Full Name">
            </div>
            <div class="mb-3">
                <input type="email" name="contact_email" class="form-control" placeholder="Email Address">

            </div>
        </div>

        <button type="submit" name="register" class="btn btn-success w-100">Register</button>
    </form>

    <div class="mt-3">
        <p>Already have an account? <a href="index.php" class="text-success fw-bold">Login</a></p>
    </div>

    <hr>

    <div class="d-flex flex-column">
        <a href="https://accounts.google.com" class="btn-social gmail-btn">
            <img src="image/Googleicon.jpg" alt="Gmail Icon"> Google
        </a>
        <a href="https://www.facebook.com" class="btn-social facebook-btn">
            <img src="image/facebook logo.png" alt="Facebook Icon"> Facebook
        </a>
    </div>
</div>

</body>
</html>
