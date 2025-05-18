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
  <title>Vegetable Menu</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    .card-img-top {
      height: 150px;
      object-fit: cover;
    }
    .nutritional-info {
      font-size: 0.85em;
      text-align: left;
      white-space: pre-line;
      margin-top: 10px;
    }

    /* Make card clickable and toggle selection */
    .selectable-card {
      cursor: pointer;
      position: relative;
      border: 2px solid transparent;
      transition: border-color 0.3s ease;
      user-select: none;
    }
    .selectable-card.selected {
      border-color: #28a745; /* bootstrap green */
      box-shadow: 0 0 10px #28a745aa;
    }

    /* Overlay checkmark on selected cards */
    .selectable-card .checkmark {
      position: absolute;
      top: 8px;
      right: 8px;
      background: #28a745cc;
      color: white;
      border-radius: 50%;
      width: 28px;
      height: 28px;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      font-size: 18px;
      opacity: 0;
      transition: opacity 0.3s ease;
      pointer-events: none;
      user-select: none;
    }
    .selectable-card.selected .checkmark {
      opacity: 1;
    }

    /* Hide the actual checkbox */
    input[type="checkbox"].hidden-checkbox {
      display: none;
    }

    /* Enhanced Save Selection Button */
    .btn-save {
      font-size: 1.25rem;
      padding: 0.75rem 2rem;
      border-radius: 50px;
      box-shadow: 0 4px 8px rgba(40, 167, 69, 0.4);
      transition: all 0.3s ease;
    }
    .btn-save:hover {
      background-color: #218838;
      box-shadow: 0 6px 12px rgba(33, 136, 56, 0.6);
      transform: scale(1.05);
    }
  </style>
</head>
<body>
<div class="container mt-4">
  <div class="mb-4">
  <a href="dashboard.php" class="btn btn-primary btn-lg">
    ← Back to Dashboard
  </a>
</div>
  <h2 class="text-success">🥦 Vegetable Menu</h2>

  <?php
  if (isset($_SESSION['message'])) {
      echo '<div class="alert alert-info">' . htmlspecialchars($_SESSION['message']) . '</div>';
      unset($_SESSION['message']);
  }

  $vegetableDishes = [
      [
          "name" => "SALAD BOWL",
          "image" => "imgvegetables/salad_bowl.jpg.jpg",
          "short_desc" => "A refreshing mix of greens, veggies, and light dressing.",
          "details" => "Ingredients: Lettuce, spinach, cherry tomatoes, cucumber, onions<br>
                        Calories: ~70 kcal<br>
                        Protein: ~2–3g<br>
                        Carbs: ~10–12g<br>
                        Fats: ~2–3g (from dressing)<br>
                        Fiber: ~3–4g"
      ],
      [
          "name" => "Grilled Cabbage 'Steaks'",
          "image" => "imgvegetables/grilled_cabbage.jpg.avif",
          "short_desc" => "Charred cabbage with herbs and olive oil.",
          "details" => "Ingredients: Cabbage, olive oil, seasonings<br>
                        Calories: ~90 kcal<br>
                        Protein: ~2g<br>
                        Carbs: ~10g<br>
                        Fats: ~5g (from oil)<br>
                        Fiber: ~4g"
      ],
      [
          "name" => "Beef & Rice Stuffed Poblano Peppers",
          "image" => "imgvegetables/stuffed_peppers.jpg.avif",
          "short_desc" => "Spicy poblano peppers filled with beef and rice.",
          "details" => "Ingredients: Ground beef, rice, cheese, peppers<br>
                        Calories: ~300–350 kcal<br>
                        Protein: ~18–22g<br>
                        Carbs: ~20–25g<br>
                        Fats: ~18–22g<br>
                        Fiber: ~4g"
      ],
      [
          "name" => "Loaded Mediterranean Sweet Potato Fries",
          "image" => "imgvegetables/med_sweet_fries.jpg.avif",
          "short_desc" => "Crispy sweet potatoes topped with feta, olives, and herbs.",
          "details" => "Ingredients: Sweet potatoes, olive oil, herbs<br>
                        Calories: ~220 kcal<br>
                        Protein: ~3g<br>
                        Carbs: ~30–35g<br>
                        Fats: ~8–10g<br>
                        Fiber: ~5–6g"
      ],
      [
          "name" => "Cheesy Garlic Zucchini Steaks",
          "image" => "imgvegetables/chessy_garlic.jpg",
          "short_desc" => "Zucchini slices smothered in garlic and melted cheese.",
          "details" => "Ingredients: Zucchini, cheese, garlic, oil<br>
                        Calories: ~180 kcal<br>
                        Protein: ~7–9g<br>
                        Carbs: ~6–8g<br>
                        Fats: ~12g<br>
                        Fiber: ~2g"
      ],
      [
          "name" => "Grilled Romaine Wedge",
          "image" => "imgvegetables/romaine_wedge.jpg.avif",
          "short_desc" => "Grilled romaine hearts with a smoky finish.",
          "details" => "Ingredients: Romaine lettuce, Caesar dressing, cheese<br>
                        Calories: ~150 kcal<br>
                        Protein: ~4g<br>
                        Carbs: ~6g<br>
                        Fats: ~12g<br>
                        Fiber: ~3g"
      ],
      [
          "name" => "Cowboy Caviar Couscous Salad",
          "image" => "imgvegetables/cowboy_caviar.jpg.avif",
          "short_desc" => "A mix of couscous, beans, corn, and peppers.",
          "details" => "Ingredients: Black beans, corn, couscous, peppers, tomatoes<br>
                        Calories: ~280 kcal<br>
                        Protein: ~8–10g<br>
                        Carbs: ~40–45g<br>
                        Fats: ~8–10g<br>
                        Fiber: ~6g"
      ],
      [
          "name" => "Fully Loaded Tornado Potatoes",
          "image" => "imgvegetables/tornado_potatoes.jpg",
          "short_desc" => "Crispy spiral potatoes with toppings.",
          "details" => "Ingredients: Potatoes, cheese, sour cream/oil<br>
                        Calories: ~300 kcal<br>
                        Protein: ~6g<br>
                        Carbs: ~35–40g<br>
                        Fats: ~14–18g<br>
                        Fiber: ~4g"
      ],
      [
          "name" => "Grilled Zucchini With Ricotta & Walnuts",
          "image" => "imgvegetables/zucchini_ricotta.jpg",
          "short_desc" => "Grilled zucchini served with creamy ricotta and crunchy walnuts.",
          "details" => "Ingredients: Zucchini, ricotta cheese, walnuts<br>
                        Calories: ~250 kcal<br>
                        Protein: ~8g<br>
                        Carbs: ~7–9g<br>
                        Fats: ~20g (mostly healthy fats)<br>
                        Fiber: ~3g"
      ]
  ];
  ?>

  <form method="post" action="save_selection.php" id="vegetableForm">
    <div class="row">
      <?php foreach ($vegetableDishes as $index => $dish): ?>
        <div class="col-md-4 mb-4">
          <label class="card selectable-card" for="dish-<?= $index ?>">
            <img src="<?= htmlspecialchars($dish['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($dish['name']) ?>">
            <div class="card-body text-center">
              <h6 class="card-title"><?= htmlspecialchars($dish['name']) ?></h6>
              <p class="text-muted small"><?= htmlspecialchars($dish['short_desc']) ?></p>
              <p class="nutritional-info"><?= $dish['details'] ?></p>
            </div>
            <input type="checkbox" class="hidden-checkbox" id="dish-<?= $index ?>" name="selected_dishes[]" value="<?= htmlspecialchars($dish['name']) ?>">
            <div class="checkmark">✔</div>
          </label>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-3">
      <button type="submit" class="btn btn-success btn-save">
        ✔️ Save Selection
      </button>
    </div>
  </form>
</div>

<script>
  // Sync card 'selected' class with checkbox checked state
  document.querySelectorAll('.selectable-card').forEach(card => {
    const checkbox = card.querySelector('input[type="checkbox"]');
    if (checkbox.checked) {
      card.classList.add('selected');
    }
    checkbox.addEventListener('change', () => {
      card.classList.toggle('selected', checkbox.checked);
    });
  });
</script>

</body>
</html>
