<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}


$meat_dishes = [
    "Florentine Butter Chicken" => [
        "image" => "imagesmeat/florentine_butter_chicken.jpg.webp",
        "protein" => "~30g",
        "fats" => "~22g",
        "carbs" => "~4g",
        "calories" => "~350 kcal",
        "ingredients" => "Chicken breast, butter, garlic, spinach, cream"
    ],
    "Chicken Katsu" => [
        "image" => "imagesmeat/chicken_katsu.jpg",
        "protein" => "~28g",
        "fats" => "~15g",
        "carbs" => "~20g",
        "calories" => "~350–400 kcal",
        "ingredients" => "Breaded chicken cutlet, cabbage, tonkatsu sauce"
    ],
    "Steak, Potato, and Chorizo Kebabs" => [
        "image" => "imagesmeat/steak_kebabs.jpg",
        "protein" => "~32g",
        "fats" => "~20g",
        "carbs" => "~18g",
        "calories" => "~420 kcal",
        "ingredients" => "Beef steak, chorizo, potatoes, bell peppers, olives"
    ],
    "Lamb Chops Sizzled with Garlic" => [
        "image" => "imagesmeat/lamb_chops.jpg",
        "protein" => "~28g",
        "fats" => "~26g",
        "carbs" => "~0–2g",
        "calories" => "~380–420 kcal",
        "ingredients" => "Lamb, garlic, herbs, olive oil"
    ],
    "Patty Melts with Scallion-Chipotle Mayo" => [
        "image" => "imagesmeat/patty_melts.jpg",
        "protein" => "~25g",
        "fats" => "~30g",
        "carbs" => "~28g",
        "calories" => "~500 kcal",
        "ingredients" => "Ground beef patty, cheese, rye bread, mayo, scallions"
    ],
    "Garlic-Butter Steak Bites" => [
        "image" => "imagesmeat/steak_bites.jpg",
        "protein" => "~30g",
        "fats" => "~25g",
        "carbs" => "~2g",
        "calories" => "~390 kcal",
        "ingredients" => "Steak cubes, garlic, butter, parsley"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Meat Menu</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
  <style>
    .dish-card {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 10px;
      margin-bottom: 20px;
      box-shadow: 1px 1px 6px #aaa;
      text-align: center;
      background-color: #fff;
      cursor: pointer;
      position: relative;
      user-select: none;
      transition: box-shadow 0.3s ease;
    }
    .dish-card:hover {
      box-shadow: 0 0 12px #28a745;
    }
    .dish-img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 5px;
      margin-bottom: 10px;
      pointer-events: none;
    }
    .nutrient-info {
      font-size: 0.9rem;
      color: #555;
      margin: 0 0 8px 0;
      text-align: left;
      pointer-events: none;
    }
    input[type="checkbox"] {
      display: none;
    }
    input[type="checkbox"]:checked + label.dish-card {
      border-color: #28a745;
      box-shadow: 0 0 15px #28a745;
      background-color: #e6f7e6;
    }
    label.dish-card {
      display: block;
    }
    input[type="checkbox"]:checked + label.dish-card::after {
      content: "✔";
      position: absolute;
      top: 8px;
      right: 12px;
      font-size: 24px;
      color: #28a745;
      font-weight: bold;
      text-shadow: 0 0 3px #fff;
      pointer-events: none;
    }
  </style>
  <script>
    function validateSelection() {
      const checkboxes = document.querySelectorAll('input[name="selected_meats[]"]:checked');
      if (checkboxes.length === 0) {
        alert('Please select at least one meat dish before saving.');
        return false; // Prevent form submission
      }
      return true;
    }
  </script>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="mb-4">
  <a href="dashboard.php" class="btn btn-primary btn-lg">
    ← Back to Dashboard
  </a>
</div>
    <h1 class="mb-4 text-danger">🍖 Meat Menu</h1>

    <form method="post" action="save_selection.php" onsubmit="return validateSelection()">
      <div class="row">
        <?php foreach ($meat_dishes as $dish => $info): ?>
          <?php $id = "dish_" . md5($dish); ?>
          <div class="col-md-4">
            <input type="checkbox" id="<?= $id ?>" name="selected_meats[]" value="<?= htmlspecialchars($dish) ?>" />
            <label for="<?= $id ?>" class="dish-card">
              <?php if (!empty($info['image'])): ?>
                <img src="<?= htmlspecialchars($info['image']) ?>" alt="<?= htmlspecialchars($dish) ?>" class="dish-img" />
              <?php endif; ?>
              <h4 class="text-danger"><?= htmlspecialchars($dish) ?></h4>
              <p class="nutrient-info">
                <strong>Protein:</strong> <?= htmlspecialchars($info['protein']) ?><br />
                <strong>Fats:</strong> <?= htmlspecialchars($info['fats']) ?><br />
                <strong>Carbs:</strong> <?= htmlspecialchars($info['carbs']) ?><br />
                <strong>Calories:</strong> <?= htmlspecialchars($info['calories']) ?><br />
                <strong>Ingredients:</strong> <?= htmlspecialchars($info['ingredients']) ?>
              </p>
            </label>
          </div>
        <?php endforeach; ?>
      </div>

      <button type="submit" class="btn btn-success btn-lg mt-3">Save Selection</button>
    </form>

    
</body>
</html>
