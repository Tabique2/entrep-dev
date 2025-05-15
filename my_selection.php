<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// All possible dishes
$all_vegetable_dishes = [
    "SALAD BOWL",
    "Grilled Cabbage \"Steaks\"",
    "Beef & Rice Stuffed Poblano Peppers",
    "Loaded Mediterranean Sweet Potato Fries",
    "Cheesy Garlic Zucchini Steaks",
    "Grilled Romaine Wedge",
    "Cowboy Caviar Couscous Salad",
    "Fully Loaded Tornado Potatoes",
    "Grilled Zucchini With Ricotta & Walnuts",
    "Cacio E Pepe Brussels Sprouts",
    "Summer Squash Sheet-Pan Tacos",
    "Caprese Asparagus"
];

$all_meat_dishes = [
    "Florentine Butter Chicken",
    "Chicken Katsu",
    "Steak, Potato, and Chorizo Kebabs",
    "Lamb Chops Sizzled with Garlic",
    "Patty Melts with Scallion-Chipotle Mayo",
    "Garlic-Butter Steak Bites"
];

$all_protein_dishes = [
    "Cottage Cheese Baked Ziti",
    "Florentine Butter Chicken",
    "White Bean & Smoked Sausage Skillet",
    "Sweet & Sour Tofu",
    "Lemon-Brown Butter Salmon",
    "Miso Salmon & Farro Bowl",
    "Indian Butter Chickpeas",
    "Beef & Rice Stuffed Poblano Peppers"
];

// Selected dishes from session
$selected_vegetables = $_SESSION['selected_vegetables'] ?? [];
$selected_meats = $_SESSION['selected_meats'] ?? [];
$selected_proteins = $_SESSION['selected_proteins'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Selection</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    .dish-card {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
      box-shadow: 1px 1px 5px #999;
    }
  </style>
</head>
<body class="bg-light">
<div class="container mt-5">

  <h2 class="mb-4 text-success">🥗 My Selected Vegetable Dishes</h2>
  <?php if (count($selected_vegetables) > 0): ?>
    <div class="row">
      <?php foreach ($selected_vegetables as $dish): ?>
        <?php if (in_array($dish, $all_vegetable_dishes)): ?>
        <div class="col-md-4">
          <div class="dish-card bg-white">
            <h5 class="text-primary"><?php echo htmlspecialchars($dish); ?></h5>
            <p>✅ You selected this healthy dish.</p>
          </div>
        </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">No vegetable dishes selected.</div>
  <?php endif; ?>

  <h2 class="mb-4 mt-5 text-danger">🍖 My Selected Meat Dishes</h2>
  <?php if (count($selected_meats) > 0): ?>
    <div class="row">
      <?php foreach ($selected_meats as $dish): ?>
        <?php if (in_array($dish, $all_meat_dishes)): ?>
        <div class="col-md-4">
          <div class="dish-card bg-white">
            <h5 class="text-danger"><?php echo htmlspecialchars($dish); ?></h5>
            <p>🍴 You selected this meat dish.</p>
          </div>
        </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">No meat dishes selected.</div>
  <?php endif; ?>

  <h2 class="mb-4 mt-5 text-primary">🍗 My Selected Protein Dishes</h2>
  <?php if (count($selected_proteins) > 0): ?>
    <div class="row">
      <?php foreach ($selected_proteins as $dish): ?>
        <?php if (in_array($dish, $all_protein_dishes)): ?>
        <div class="col-md-4">
          <div class="dish-card bg-white">
            <h5 class="text-primary"><?php echo htmlspecialchars($dish); ?></h5>
            <p>🍗 You selected this protein dish.</p>
          </div>
        </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">No protein dishes selected.</div>
  <?php endif; ?>

  <a href="dashboard.php" class="btn btn-outline-dark mt-4">← Back to Dashboard</a>
</div>
</body>
</html>
