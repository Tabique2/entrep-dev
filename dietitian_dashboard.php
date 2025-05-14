<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Only allow logged-in dietitians
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'dietitian') {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$db = "enterprise";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users for viewing
$result = $conn->query("SELECT id, username, role FROM users WHERE role = 'user'");

// Fetch user health information for BMI calculation
$healthResult = $conn->query("SELECT user_id, weight, height FROM user_health_info");
$bmiData = [];

while ($healthRow = $healthResult->fetch_assoc()) {
    $userId = $healthRow['user_id'];
    $weight = $healthRow['weight'];
    $height = $healthRow['height'];

    if ($height > 0) { // Prevent division by zero
        $bmi = $weight / ($height * $height);
        $bmiData[$userId] = $bmi;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Dietitian Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Welcome, <?= htmlspecialchars($_SESSION['username']) ?> (Dietitian)</h2>

    <div class="mb-3 text-end">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <h4 class="mb-3">User List</h4>
    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars(ucfirst($row['role'])) ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <h4 class="mb-3">BMI Distribution</h4>
    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>User ID</th>
                <th>BMI</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (count($bmiData) > 0) {
            foreach ($bmiData as $userId => $bmi) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($userId) . "</td>";
                echo "<td>" . htmlspecialchars(number_format($bmi, 2)) . "</td>";
                echo "</tr>";
            }
        } else {
            echo '<tr><td colspan="2">No BMI data available</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>

