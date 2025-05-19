<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("User ID not found in session.");
}

$stmt = $conn->prepare("SELECT full_name, age, gender, activity_level, health_goal, dietary_pref FROM user_profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if (!$userData) {
    $stmt = $conn->prepare("INSERT INTO user_profiles (user_id) VALUES (?)");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $userData = ['full_name' => '', 'age' => '', 'gender' => '', 'activity_level' => '', 'health_goal' => '', 'dietary_pref' => ''];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $age = $_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $activity_level = $_POST['activity_level'] ?? '';
    $health_goal = $_POST['health_goal'] ?? '';
    $dietary_pref = $_POST['dietary_pref'] ?? '';

    $stmt = $conn->prepare("UPDATE user_profiles SET full_name=?, age=?, gender=?, activity_level=?, health_goal=?, dietary_pref=? WHERE user_id=?");
    $stmt->bind_param("sissssi", $full_name, $age, $gender, $activity_level, $health_goal, $dietary_pref, $user_id);
    $stmt->execute();

    $message = "✅ Profile updated successfully!";
    $userData = compact('full_name', 'age', 'gender', 'activity_level', 'health_goal', 'dietary_pref');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>👤 My Profile | NutriTrack ERP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f9fc;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }
        label {
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 4px;
        }
        .form-control {
            font-size: 0.9rem;
            padding: 0.45rem 0.75rem;
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        h2 {
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card p-4">
                <h2 class="mb-3 text-center">👤 My Profile</h2>
                <p class="text-muted text-center">Update your health details to receive personalized nutrition plans.</p>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-success"><?= $message ?></div>
                <?php endif; ?>

                <form method="POST" action="profile.php">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="full_name" required value="<?= htmlspecialchars($userData['full_name']) ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Age</label>
                            <input type="number" class="form-control" name="age" min="10" max="100" value="<?= htmlspecialchars($userData['age']) ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Gender</label>
                            <select name="gender" class="form-control">
                                <option value="">Select</option>
                                <option <?= $userData['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                                <option <?= $userData['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                                <option <?= $userData['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Activity Level</label>
                            <select name="activity_level" class="form-control">
                                <option value="">Select</option>
                                <option <?= $userData['activity_level'] === 'Sedentary' ? 'selected' : '' ?>>Sedentary</option>
                                <option <?= $userData['activity_level'] === 'Moderate' ? 'selected' : '' ?>>Moderate</option>
                                <option <?= $userData['activity_level'] === 'Active' ? 'selected' : '' ?>>Active</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Health Goal</label>
                            <select name="health_goal" class="form-control">
                                <option value="">Select</option>
                                <option <?= $userData['health_goal'] === 'Weight Loss' ? 'selected' : '' ?>>Weight Loss</option>
                                <option <?= $userData['health_goal'] === 'Muscle Gain' ? 'selected' : '' ?>>Muscle Gain</option>
                                <option <?= $userData['health_goal'] === 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Dietary Preference</label>
                        <select name="dietary_pref" class="form-control">
                            <option value="">Select</option>
                            <option <?= $userData['dietary_pref'] === 'None' ? 'selected' : '' ?>>None</option>
                            <option <?= $userData['dietary_pref'] === 'Vegetarian' ? 'selected' : '' ?>>Vegetarian</option>
                            <option <?= $userData['dietary_pref'] === 'Vegan' ? 'selected' : '' ?>>Vegan</option>
                            <option <?= $userData['dietary_pref'] === 'Keto' ? 'selected' : '' ?>>Keto</option>
                            <option <?= $userData['dietary_pref'] === 'Low Carb' ? 'selected' : '' ?>>Low Carb</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">💾 Save Changes</button>
                    <a href="dashboard.php" class="btn btn-secondary btn-block mt-2">← Back to Dashboard</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
