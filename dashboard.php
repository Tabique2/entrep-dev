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
    <title>NutriTrack ERP | User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/user_meals.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/user_charts.js"></script>
    <form id="mealForm" action="log_meal.php" method="POST">


  </head>
  <body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav class="col-md-3 col-lg-2 d-md-block bg-dark text-white sidebar">
        <div class="sidebar-sticky p-3">
          <h4 class="text-success font-weight-bold">🥗 Dashboard</h4>
          <ul class="nav flex-column mt-4">
            <li class="nav-item"><a class="nav-link text-white" href="calendar.php">📅 Health Calendar</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="message_center.php">💬 NutriFit Message Center</a></li>
            <li class="nav-item"><strong>🍴 Healthy Meal Planner</strong>
              <ul class="ml-3">
                <li><a class="nav-link text-white" href="vegetable_menu.php">🥦 Vegetable Menu</a></li>
                <li><a class="nav-link text-white" href="meat_menu.php">🍖 Meat Menu</a></li>
                <li><a class="nav-link text-white" href="protein_menu.php">🥚 Protein Menu</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link text-white" href="profile.php">👤 My Profile</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="my_selection.php">✅ My Food Selections</a></li>
            <li class="nav-item"><a class="nav-link text-danger" href="logout.php">↩️ Logout</a></li>
          </ul>

          <!-- Today's Meals Feature -->
          <div class="card bg-light text-dark mt-4">
            <div class="card-header font-weight-bold text-center bg-success text-white py-2">
              🍽️ Today's Personalized Meals
            </div>
            <div class="card-body p-2" style="font-size: 0.85rem;">
              <div class="mb-2">
                <input type="checkbox" checked> <strong>Breakfast</strong> <span class="float-right">320 kcal</span><br>
                <small>Scrambled Eggs with Spinach & Toast</small><br>
                <small>🥩 25g 🍞 18g 🧈 9g</small>
              </div>
              <div class="mb-2">
                <input type="checkbox" checked> <strong>Lunch</strong> <span class="float-right">425 kcal</span><br>
                <small>Chicken Salad w/ Avocado & Quinoa</small><br>
                <small>🥩 40g 🍞 35g 🧈 15g</small>
              </div>
              <div class="mb-2">
                <input type="checkbox"> <strong>Snack</strong> <span class="float-right">200 kcal</span><br>
                <small>Greek Yogurt & Berries</small><br>
                <small>🥩 18g 🍞 12g 🧈 7g</small>
              </div>
              <div>
                <input type="checkbox"> <strong>Dinner</strong> <span class="float-right">505 kcal</span><br>
                <small>Chicken, Sweet Potato & Green Beans</small><br>
                <small>🥩 45g 🍞 35g 🧈 15g</small>
              </div>
            </div>
          </div>
        </div>
      </nav>

      <!-- Main Section -->
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <h2 class="mt-4">Welcome to NutriTrack ERP, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p class="text-muted">Your personal hub for nutrition, meals, and health insights.</p>


        <!-- Meal Logging -->
        <div class="card mt-4">
          <div class="card-header bg-success text-white">
            🍽️ Log Your Personalized Meal
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
                    <option>Vegetable</option>
                    <option>Meat</option>
                    <option>Protein</option>
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

        <!-- Health Charts -->
        <div class="card mt-4">
          <div class="card-header bg-primary text-white">
            📊 Personalized Health Insights
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
