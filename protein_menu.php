<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Protein Menu</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
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

    .dish-image {
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
      const checkboxes = document.querySelectorAll('input[name="selected_proteins[]"]:checked');
      if (checkboxes.length === 0) {
        alert('Please select at least one protein dish before saving.');
        return false;
      }
      return true;
    }
  </script>
</head>
<body class="bg-light">
<div class="container mt-4">
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Back to Dashboard</a>

    <?php if (isset($_SESSION['message'])): ?>
      <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?php 
            echo $_SESSION['message']; 
            unset($_SESSION['message']);
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>

    <h2 class="mb-4 text-primary">🍗 Select Your Favorite Protein Dishes</h2>

    <form action="save_protein_selection.php" method="post" onsubmit="return validateSelection()">
        <input type="hidden" name="category" value="protein">
        <div class="row">
            <?php
            $protein_items = [
                ["name" => "Cottage Cheese Baked Ziti", "image" => "imageprotein/cottage_cheese_baked_ziti.jpg", "nutrition" => "Calories: 375 kcal | Protein: 23 g | Fat: 15.85 g | Carbs: 34.16 g"],
                ["name" => "Florentine Butter Chicken", "image" => "imageprotein/florentine_butter_chicken.jpg", "nutrition" => "Calories: 400–500 kcal | Protein: 30–35 g | Fat: 25–30 g | Carbs: 5–10 g"],
                ["name" => "White Bean & Smoked Sausage Skillet", "image" => "imageprotein/white_bean_smoked_sausage.jpg", "nutrition" => "Calories: 400–500 kcal | Protein: 20–25 g | Fat: 20–25 g | Carbs: 30–35 g"],
                ["name" => "Sweet & Sour Tofu", "image" => "imageprotein/sweet_sour_tofu.jpg", "nutrition" => "Calories: 366 kcal | Protein: 17 g | Fat: 23 g | Carbs: 23 g"],
                ["name" => "Lemon-Brown Butter Salmon", "image" => "imageprotein/lemon_brown_butter_salmon.jpg", "nutrition" => "Calories: 821 kcal | Protein: 41 g | Fat: 61 g | Carbs: 28 g"],
                ["name" => "Miso Salmon & Farro Bowl", "image" => "imageprotein/miso_salmon_farro_bowl.jpg", "nutrition" => "Calories: 763 kcal | Protein: 44 g | Fat: 44 g | Carbs: 43 g"],
                ["name" => "Indian Butter Chickpeas", "image" => "imageprotein/indian_butter_chickpeas.jpg", "nutrition" => "Calories: 579 kcal | Protein: 14.3 g | Fat: 23 g | Carbs: 81.4 g"],
                ["name" => "Beef & Rice Stuffed Poblano Peppers", "image" => "imageprotein/beef_rice_stuffed_poblano_peppers.jpg", "nutrition" => "Calories: 400–500 kcal | Protein: 25–30 g | Fat: 20–25 g | Carbs: 30–35 g"]
            ];

            foreach ($protein_items as $index => $item):
                $id = "protein_" . md5($item['name']);
            ?>
                <div class="col-md-4">
                    <input type="checkbox" id="<?= $id ?>" name="selected_proteins[]" value="<?= htmlspecialchars($item['name']) ?>" />
                    <label for="<?= $id ?>" class="dish-card">
                        <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="dish-image" />
                        <h6 class="mt-2 font-weight-bold"><?= htmlspecialchars($item['name']) ?></h6>
                        <p class="nutrient-info"><?= htmlspecialchars($item['nutrition']) ?></p>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="btn btn-success mt-4">✅ Save Selection</button>
    </form>

    <a href="my_selection.php" class="btn btn-outline-dark mt-3">📋 View My Selections</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
