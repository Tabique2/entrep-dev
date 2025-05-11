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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Unified Health Dashboard</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      width: 250px;
      background-color: #222;
      color: #fff;
      padding: 20px;
      height: 100vh;
      position: fixed;
      overflow-y: auto;
    }

    .sidebar h2 {
      margin-top: 0;
      font-size: 22px;
      margin-bottom: 20px;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar ul li {
      margin-bottom: 10px;
    }

    .sidebar ul li ul {
      margin-top: 5px;
      margin-left: 15px;
    }

    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 8px;
      border-radius: 4px;
      transition: background 0.3s;
    }

    .sidebar a:hover {
      background-color: #444;
    }

    .main {
      margin-left: 250px;
      padding: 20px;
      flex-grow: 1;
      background-color: #eee;
    }

    .tiles {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-bottom: 30px;
    }

    .tile {
      flex: 1 1 180px;
      background: #fff;
      padding: 20px;
      border: 1px solid #ccc;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
      font-weight: bold;
      border-radius: 8px;
      transition: transform 0.2s;
    }

    .tile:hover {
      transform: scale(1.03);
    }

    .section {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 30px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .section h3 {
      margin-top: 0;
    }

    .charts {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      justify-content: space-around;
    }

    .charts img {
      max-width: 300px;
      height: auto;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
    }

    th {
      background-color: #f0f0f0;
    }

    .logout-link {
      color: #ff5252;
      font-weight: bold;
    }

    /* Responsive for smaller screens */
    @media (max-width: 768px) {
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
      }

      .main {
        margin-left: 0;
      }

      .charts {
        flex-direction: column;
        align-items: center;
      }

      .tile {
        flex: 1 1 100%;
      }
    }
  </style>
</head>
<body>
  <aside class="sidebar">
    <h2>📊 DASHBOARD</h2>
    <ul>
      <li><a href="calendar.html">📅 Calendar</a></li>
      <li><a href="nutrifit.html">💬 NutriFit Message</a></li>
      <li>🍴 Healthy Menu
        <ul>
          <li><a href="vegetable.html">🥦 Vegetable</a></li>
          <li><a href="meat.html">🍖 Meat</a></li>
          <li><a href="protein.html">🥚 Protein</a></li>
        </ul>
      </li>
    </ul>
    <h3><a href="#">👤 Profile</a></h3>
    <p><a href="logout.php" class="logout-link">↩️ Logout</a></p>
  </aside>

  <main class="main">
    <div class="tiles">
      <a href="#"><div class="tile">👥 USER MANAGEMENT<br>1</div></a>
      <a href="#"><div class="tile">📰 ARTICLES & NEWS<br>1</div></a>
      <a href="#"><div class="tile">💪 FITNESS TRAINING<br>1</div></a>
      <a href="#"><div class="tile">🍽️ DIET MAINTENANCE<br>1</div></a>
      <a href="#"><div class="tile">🧮 BMI CALCULATOR<br>1</div></a>
    </div>

    <div class="section">
      <h3>📈 Health Charts</h3>
      <div class="charts">
        <img src="https://www.researchgate.net/publication/342551702/figure/fig1/AS:908089549156354@1593516828895/Pie-chart-showing-distribution-of-BMI-category-of-study-participants.png" alt="Weight Data">
        <img src="/images/pie2.png" alt="Nutrition Pie Chart">
        <img src="/images/bmi_chart.png" alt="BMI Chart">
      </div>
    </div>

    <div class="section">
      <h3>🏈 Football Participation (Weighted)</h3>
      <table>
        <thead>
          <tr>
            <th>Sex</th>
            <th>Age</th>
            <th>Respondents</th>
            <th>Weight (target/current)</th>
            <th>Weighted Respondents</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>Male</td><td>Under 16</td><td>150</td><td>0.27</td><td>40</td></tr>
          <tr><td>Male</td><td>16-30</td><td>175</td><td>0.60</td><td>105</td></tr>
          <tr><td>Male</td><td>30+</td><td>25</td><td>4.20</td><td>105</td></tr>
          <tr><td>Female</td><td>Under 16</td><td>25</td><td>4.40</td><td>110</td></tr>
          <tr><td>Female</td><td>16-30</td><td>25</td><td>4.40</td><td>110</td></tr>
          <tr><td>Female</td><td>30+</td><td>25</td><td>4.00</td><td>100</td></tr>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
