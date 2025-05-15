<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Dishes with image paths
$vegetable_dishes = [
    "SALAD BOWL" => "imgvegetables/salad_bowl.jpg.jpg",
    "Grilled Cabbage \"Steaks\"" => "imgvegetables/grilled_cabbage.jpg.avif",
    "Beef & Rice Stuffed Poblano Peppers" => "imgvegetables/stuffed_peppers.jpg.avif",
    "Loaded Mediterranean Sweet Potato Fries" => "imgvegetables/med_sweet_fries.jpg.avif",
    "Cheesy Garlic Zucchini Steaks" => "imgvegetables/chessy_garlic.jpg",
    "Grilled Romaine Wedge" => "imgvegetables/romaine_wedge.jpg.avif",
    "Cowboy Caviar Couscous Salad" => "imgvegetables/cowboy_caviar.jpg.avif",
    "Fully Loaded Tornado Potatoes" => "imgvegetables/tornado_potatoes.jpg",
    "Grilled Zucchini With Ricotta & Walnuts" => "imgvegetables/zucchini_ricotta.jpg",
    "Cacio E Pepe Brussels Sprouts" => "",
    "Summer Squash Sheet-Pan Tacos" => "",
    "Caprese Asparagus" => ""
];

$meat_dishes = [
    "Florentine Butter Chicken" => "imagesmeat/florentine_butter_chicken.jpg.webp",
    "Chicken Katsu" => "imagesmeat/chicken_katsu.jpg",
    "Steak, Potato, and Chorizo Kebabs" => "imagesmeat/steak_kebabs.jpg",
    "Lamb Chops Sizzled with Garlic" => "imagesmeat/lamb_chops.jpg",
    "Patty Melts with Scallion-Chipotle Mayo" => "imagesmeat/patty_melts.jpg",
    "Garlic-Butter Steak Bites" => "imagesmeat/steak_bites.jpg"
];

$protein_dishes = [
    "Cottage Cheese Baked Ziti" => "imageprotein/cottage_cheese_baked_ziti.jpg",
    "Florentine Butter Chicken" => "imageprotein/florentine_butter_chicken.jpg",
    "White Bean & Smoked Sausage Skillet" => "imageprotein/white_bean_smoked_sausage.jpg",
    "Sweet & Sour Tofu" => "imageprotein/sweet_sour_tofu.jpg",
    "Lemon-Brown Butter Salmon" => "imageprotein/lemon_brown_butter_salmon.jpg",
    "Miso Salmon & Farro Bowl" => "imageprotein/miso_salmon_farro_bowl.jpg",
    "Indian Butter Chickpeas" => "imageprotein/indian_butter_chickpeas.jpg",
    "Beef & Rice Stuffed Poblano Peppers" => "imageprotein/beef_rice_stuffed_poblano_peppers.jpg"
];

// Get user selections
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
      padding: 10px;
      margin-bottom: 15px;
      box-shadow: 1px 1px 5px #999;
      text-align: center;
    }
    .dish-img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 5px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body class="bg-light">
<div class="container mt-5">

  <!-- Vegetable Dishes -->
  <h2 class="mb-4 text-success">🥗 My Selected Vegetable Dishes</h2>
  <div class="row">
    <?php foreach ($selected_vegetables as $dish): ?>
      <?php if (isset($vegetable_dishes[$dish])): ?>
        <div class="col-md-4">
          <div class="dish-card bg-white">
            <?php if ($vegetable_dishes[$dish]): ?>
              <img src="<?= $vegetable_dishes[$dish] ?>" class="dish-img" alt="<?= htmlspecialchars($dish) ?>">
            <?php endif; ?>
            <h5 class="text-primary"><?= htmlspecialchars($dish) ?></h5>
            <p>✅ You selected this healthy dish.</p>
            <form method="post" action="remove_selection.php" class="mt-2">
              <input type="hidden" name="category" value="vegetable">
              <input type="hidden" name="dish" value="<?= htmlspecialchars($dish) ?>">
              <button type="submit" class="btn btn-sm btn-outline-danger">🗑 Remove</button>
            </form>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
  <?php if (count($selected_vegetables) === 0): ?>
    <div class="alert alert-warning">No vegetable dishes selected.</div>
  <?php endif; ?>

  <!-- Meat Dishes -->
  <h2 class="mb-4 mt-5 text-danger">🍖 My Selected Meat Dishes</h2>
  <div class="row">
    <?php foreach ($selected_meats as $dish): ?>
      <?php if (isset($meat_dishes[$dish])): ?>
        <div class="col-md-4">
          <div class="dish-card bg-white">
            <?php if ($meat_dishes[$dish]): ?>
              <img src="<?= $meat_dishes[$dish] ?>" class="dish-img" alt="<?= htmlspecialchars($dish) ?>">
            <?php endif; ?>
            <h5 class="text-danger"><?= htmlspecialchars($dish) ?></h5>
            <p>🍴 You selected this meat dish.</p>
            <form method="post" action="remove_selection.php" class="mt-2">
              <input type="hidden" name="category" value="meat">
              <input type="hidden" name="dish" value="<?= htmlspecialchars($dish) ?>">
              <button type="submit" class="btn btn-sm btn-outline-danger">🗑 Remove</button>
            </form>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
  <?php if (count($selected_meats) === 0): ?>
    <div class="alert alert-warning">No meat dishes selected.</div>
  <?php endif; ?>

  <!-- Protein Dishes -->
  <h2 class="mb-4 mt-5 text-primary">🍗 My Selected Protein Dishes</h2>
  <div class="row">
    <?php foreach ($selected_proteins as $dish): ?>
      <?php if (isset($protein_dishes[$dish])): ?>
        <div class="col-md-4">
          <div class="dish-card bg-white">
            <?php if ($protein_dishes[$dish]): ?>
              <img src="<?= $protein_dishes[$dish] ?>" class="dish-img" alt="<?= htmlspecialchars($dish) ?>">
            <?php endif; ?>
            <h5 class="text-primary"><?= htmlspecialchars($dish) ?></h5>
            <p>🍗 You selected this protein dish.</p>
            <form method="post" action="remove_selection.php" class="mt-2">
              <input type="hidden" name="category" value="protein">
              <input type="hidden" name="dish" value="<?= htmlspecialchars($dish) ?>">
              <button type="submit" class="btn btn-sm btn-outline-danger">🗑 Remove</button>
            </form>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
  <?php if (count($selected_proteins) === 0): ?>
    <div class="alert alert-warning">No protein dishes selected.</div>
  <?php endif; ?>

  <!-- Back to Dashboard -->
  <a href="dashboard.php" class="btn btn-outline-dark mt-4">← Back to Dashboard</a>
</div>
</body>
</html>
