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

// Nutritional details for vegetables (add more as needed)
$vegetable_details = [
    "SALAD BOWL" => "Ingredients: Lettuce, spinach, cherry tomatoes, cucumber, onions
Calories: ~70 kcal
Protein: ~2–3g
Carbs: ~10–12g
Fats: ~2–3g (from dressing)
Fiber: ~3–4g",
    "Grilled Cabbage \"Steaks\"" => "Ingredients: Cabbage, olive oil, seasonings
Calories: ~90 kcal
Protein: ~2g
Carbs: ~10g
Fats: ~5g (from oil)
Fiber: ~4g",
    "Beef & Rice Stuffed Poblano Peppers" => "Ingredients: Ground beef, rice, cheese, peppers
Calories: ~300–350 kcal
Protein: ~18–22g
Carbs: ~20–25g
Fats: ~18–22g
Fiber: ~4g",
    "Loaded Mediterranean Sweet Potato Fries" => "Ingredients: Sweet potatoes, olive oil, herbs
Calories: ~220 kcal
Protein: ~3g
Carbs: ~30–35g
Fats: ~8–10g
Fiber: ~5–6g",
    "Cheesy Garlic Zucchini Steaks" => "Ingredients: Zucchini, cheese, garlic, oil
Calories: ~180 kcal
Protein: ~7–9g
Carbs: ~6–8g
Fats: ~12g
Fiber: ~2g",
    "Grilled Romaine Wedge" => "Ingredients: Romaine lettuce, Caesar dressing, cheese
Calories: ~150 kcal
Protein: ~4g
Carbs: ~6g
Fats: ~12g
Fiber: ~3g",
    "Cowboy Caviar Couscous Salad" => "Ingredients: Black beans, corn, couscous, peppers, tomatoes
Calories: ~280 kcal
Protein: ~8–10g
Carbs: ~40–45g
Fats: ~8–10g
Fiber: ~6g",
    "Fully Loaded Tornado Potatoes" => "Ingredients: Potatoes, cheese, sour cream/oil
Calories: ~300 kcal
Protein: ~6g
Carbs: ~35–40g
Fats: ~14–18g
Fiber: ~4g",
    "Grilled Zucchini With Ricotta & Walnuts" => "Ingredients: Zucchini, ricotta cheese, walnuts
Calories: ~250 kcal
Protein: ~8g
Carbs: ~7–9g
Fats: ~20g (mostly healthy fats)
Fiber: ~3g"
];

$meat_details = [
    "Florentine Butter Chicken" => "Ingredients: Chicken, butter, garlic, cream
Calories: ~350 kcal
Protein: ~30g
Carbs: ~5g
Fats: ~25g",
    "Chicken Katsu" => "Ingredients: Breaded chicken cutlet, panko, oil
Calories: ~400 kcal
Protein: ~28g
Carbs: ~30g
Fats: ~15g",
    "Steak, Potato, and Chorizo Kebabs" => "Ingredients: Beef steak, chorizo, potatoes, bell peppers, olives
Calories: ~420 kcal
Protein: ~32g
Carbs: ~18g
Fats: ~20g",
    "Lamb Chops Sizzled with Garlic" => "Ingredients: Lamb, garlic, herbs, olive oil
Calories: ~380–420 kcal
Protein: ~28g
Carbs: ~0–2g
Fats: ~26g",
    "Patty Melts with Scallion-Chipotle Mayo" => "Ingredients: Ground beef patty, cheese, rye bread, mayo, scallions
Calories: ~500 kcal
Protein: ~25g
Carbs: ~28g
Fats: ~30g",
    "Garlic-Butter Steak Bites" => "Ingredients: Steak cubes, garlic, butter, parsley
Calories: ~390 kcal
Protein: ~30g
Carbs: ~2g
Fats: ~25g"
];

$protein_details = [
    "Cottage Cheese Baked Ziti" => "Ingredients: Cottage cheese, pasta, tomato sauce, cheese
Calories: ~400 kcal
Protein: ~25g
Carbs: ~40g
Fats: ~12g",
    "Florentine Butter Chicken" => $meat_details["Florentine Butter Chicken"], // reuse meat detail here
    "White Bean & Smoked Sausage Skillet" => "Ingredients: White beans, smoked sausage, spices
Calories: ~350 kcal
Protein: ~28g
Carbs: ~30g
Fats: ~15g",
    "Sweet & Sour Tofu" => "Ingredients: Tofu, bell peppers, pineapple, sauce
Calories: ~250 kcal
Protein: ~20g
Carbs: ~20g
Fats: ~10g",
    "Lemon-Brown Butter Salmon" => "Ingredients: Salmon, lemon, butter
Calories: ~400 kcal
Protein: ~35g
Carbs: ~0g
Fats: ~28g",
    "Miso Salmon & Farro Bowl" => "Ingredients: Salmon, farro, miso sauce
Calories: ~450 kcal
Protein: ~38g
Carbs: ~35g
Fats: ~15g",
    "Indian Butter Chickpeas" => "Ingredients: Chickpeas, butter, spices
Calories: ~300 kcal
Protein: ~15g
Carbs: ~30g
Fats: ~12g",
    "Beef & Rice Stuffed Poblano Peppers" => $vegetable_details["Beef & Rice Stuffed Poblano Peppers"]
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
    pre {
      text-align: left;
      white-space: pre-wrap;
      font-family: inherit;
      background-color: #f8f9fa;
      padding: 10px;
      border-radius: 5px;
      font-size: 0.9rem;
    }
  </style>
</head>
<body class="bg-light">
<div class="container mt-5">

<div class="mb-4">
  <a href="dashboard.php" class="btn btn-primary btn-lg">
    ← Back to Dashboard
  </a>
</div>

  <!-- Vegetable Dishes -->
  <h2 class="mb-4 text-success">🥗 My Selected Vegetable Dishes</h2>
  <div class="row">
    <?php foreach ($selected_vegetables as $dish): ?>
      <?php if (isset($vegetable_dishes[$dish])): ?>
        <div class="col-md-4">
          <div class="dish-card bg-white">
            <?php if ($vegetable_dishes[$dish]): ?>
              <img src="<?= htmlspecialchars($vegetable_dishes[$dish]) ?>" class="dish-img" alt="<?= htmlspecialchars($dish) ?>">
            <?php endif; ?>
            <h5 class="text-primary"><?= htmlspecialchars($dish) ?></h5>
            <pre><?= htmlspecialchars($vegetable_details[$dish] ?? "No nutritional info available.") ?></pre>
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
              <img src="<?= htmlspecialchars($meat_dishes[$dish]) ?>" class="dish-img" alt="<?= htmlspecialchars($dish) ?>">
            <?php endif; ?>
            <h5 class="text-danger"><?= htmlspecialchars($dish) ?></h5>
            <pre><?= htmlspecialchars($meat_details[$dish] ?? "No nutritional info available.") ?></pre>
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
              <img src="<?= htmlspecialchars($protein_dishes[$dish]) ?>" class="dish-img" alt="<?= htmlspecialchars($dish) ?>">
            <?php endif; ?>
            <h5 class="text-primary"><?= htmlspecialchars($dish) ?></h5>
            <pre><?= htmlspecialchars($protein_details[$dish] ?? "No nutritional info available
.") ?></pre>
<form method="post" action="remove_selection.php" class="mt-2">
<input type="hidden" name="category" value="protein">
<input type="hidden" name="dish" value="<?= htmlspecialchars($dish) ?>">
<button type="submit" class="btn btn-sm btn-outline-danger">🗑 Remove</button>
</form>
</div>
</div>
<?php endif; ?>
<?php endforeach; ?>

</div> <?php if (count($selected_proteins) === 0): ?> <div class="alert alert-warning">No protein dishes selected.</div> <?php endif; ?> </div> </body> </html>