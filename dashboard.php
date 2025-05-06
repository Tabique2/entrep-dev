<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
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
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
    }
    .sidebar {
      width: 250px;
      background-color: #222;
      color: #fff;
      padding: 20px;
      height: 100vh;
    }
    .sidebar h2, .sidebar h3 {
      margin-top: 0;
    }
    .sidebar ul {
      list-style: none;
      padding-left: 0;
    }
    .sidebar ul li {
      padding: 8px 0;
    }
    .main {
      flex: 1;
      padding: 20px;
      background-color: #eee;
    }
    .tiles {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }
    .tile {
      flex: 1 1 180px;
      background: #fff;
      padding: 15px;
      border: 1px solid #ccc;
      box-shadow: 0 0 5px #bbb;
      text-align: center;
      font-weight: bold;
    }
    .section {
      margin-top: 30px;
      background: #fff;
      padding: 15px;
      box-shadow: 0 0 5px #bbb;
    }
    .section h3 {
      margin-top: 0;
    }
    .charts {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }
    .charts img {
      max-width: 300px;
      height: auto;
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

    /* Styling for clickable items */
    a {
      color: inherit;
      text-decoration: none;
      display: block;
    }
    a:hover {
      opacity: 0.8;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>DASHBOARD</h2>
    <ul>
      <li><a href="calendar.html">📅 Calendar</a></li>
      <li><a href="nutrifit.html">💬 NutriFit Message</a></li>
      <li>🍴 Healthy Menu
        <ul>
          <li><a href="vegetable.html">🥦 Vegetable Menu</a></li>
          <li><a href="meat.html">🍖 Meat Menu</a></li>
          <li><a href="protein.html">🥚 Protein Menu</a></li>
        </ul>
      </li>        
    </ul>
    <h3><a href="#">👤 Profile</a></h3>
    <p><a href="#">↩️ Logout</a></p>
  </div>

  <div class="main">
    <div class="tiles">
      <a href="#"><div class="tile">👥 USER MANAGEMENT<br>1</div></a>
      <a href="#"><div class="tile">📰 ARTICLES & NEWS<br>1</div></a>
      <a href="#"><div class="tile">💪 FITNESS TRAINING<br>1</div></a>
      <a href="#"><div class="tile">🍽️ DIET MAINTENANCE<br>1</div></a>
     
      
     
      <a href="#"><div class="tile">🧮 BMI CALCULATOR<br>1</div></a>
    </div>

    <div class="section">
      <h3>Charts</h3>
      <div class="charts">
        <img src="https://www.researchgate.net/publication/342551702/figure/fig1/AS:908089549156354@1593516828895/Pie-chart-showing-distribution-of-BMI-category-of-study-participants.png" alt="Weight Data">
        <img src="/images/pie2.png" alt="Nutrition Pie Chart">
        <img src="/images/bmi_chart.png" alt="BMI Chart">
      </div>
    </div>

    <div class="section">
      <h3>Football Participation (Weighted)</h3>
      <table>
        <thead>
          <tr>
            <th>Sex</th><th>Age</th><th>Number of Respondents</th><th>Weight (target/current)</th><th>Weighted Number of Respondents</th>
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
  </div>
</body>
</html>
