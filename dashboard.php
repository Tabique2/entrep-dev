<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <script src="js/user_meals.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="js/user_charts.js"></script>



</head>
<body>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <nav class="col-md-3 col-lg-2 d-md-block bg-dark text-white sidebar">
      <div class="sidebar-sticky p-3">
        <h4>📊 Dashboard</h4>
        <ul class="nav flex-column">
          <li class="nav-item"><a class="nav-link text-white" href="#">📅 Calendar</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">💬 NutriFit Message</a></li>
          <li class="nav-item"><strong>🍴 Healthy Menu</strong>
            <ul class="ml-3">
              <li><a class="nav-link text-white" href="#">🥦 Vegetable</a></li>
              <li><a class="nav-link text-white" href="#">🍖 Meat</a></li>
              <li><a class="nav-link text-white" href="#">🥚 Protein</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link text-white" href="profile.php">👤 Profile</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="logout.php">↩️ Logout</a></li>
        </ul>
      </div>
    </nav>

    
    <!-- Main Section -->
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <h2 class="mt-4">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

      <!-- Feature Tiles -->
      <div class="row mt-4">
        <?php
        $tiles = [
          ["👥 USER MANAGEMENT", "#"],
          ["📰 ARTICLES & NEWS", "#"],
          ["💪 FITNESS TRAINING", "#"],
          ["🍽️ DIET MAINTENANCE", "#"],
          ["🧮 BMI CALCULATOR", "#"]
        ];
        foreach ($tiles as $tile) {
          echo '<div class="col-md-4 mb-3">
                  <a href="' . $tile[1] . '" class="btn btn-outline-primary w-100 py-3 font-weight-bold">' . $tile[0] . '</a>
                </div>';
        }
        ?>
      </div>

      <!-- Placeholder: Meal Form, Charts, etc. -->
      <div class="mt-5">
        <!-- Other components like meal logging and charts will go here -->
      </div>

      <div class="card mt-4">
  <div class="card-header bg-success text-white">
    🍽️ Log Your Meal
  </div>
  <div class="card-body">
    <form id="mealForm">
      <div class="form-row">
        <div class="form-group col-md-4">
          <label>Food Name</label>
          <input type="text" name="food_name" class="form-control" required>
        </div>
        <div class="form-group col-md-2">
          <label>Quantity</label>
          <input type="number" step="0.1" name="quantity" class="form-control" required>
        </div>
        <div class="form-group col-md-3">
          <label>Food Group</label>
          <select name="food_group" class="form-control">
            <option>Protein</option>
            <option>Grains</option>
            <option>Vegetable</option>
            <option>Fruit</option>
            <option>Dairy</option>
            <option>Fat</option>
            <option>Other</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-2">
          <label>Protein (g)</label>
          <input type="number" step="0.1" name="protein" class="form-control">
        </div>
        <div class="form-group col-md-2">
          <label>Carbs (g)</label>
          <input type="number" step="0.1" name="carbs" class="form-control">
        </div>
        <div class="form-group col-md-2">
          <label>Fat (g)</label>
          <input type="number" step="0.1" name="fat" class="form-control">
        </div>
      </div>

      <button type="submit" class="btn btn-success">💾 Save Meal</button>
    </form>
    <p id="mealMsg" class="mt-3"></p>
  </div>
</div>

<div class="card mt-4">
  <div class="card-header bg-primary text-white">
    📊 Health Charts
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6 mb-3">
        <canvas id="bmiChart"></canvas>
      </div>
      <div class="col-md-6 mb-3">
        <canvas id="nutritionChart"></canvas>
      </div>
      <div class="col-md-6 mb-3">
        <canvas id="macroChart"></canvas>
      </div>
      <div class="col-md-6 mb-3">
        <canvas id="progressChart"></canvas>
      </div>
    </div>
  </div>
</div>

    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
