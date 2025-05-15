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
  </style>
</head>
<body>
<div class="container mt-4">
  <a href="dashboard.php" class="btn btn-secondary mb-3">← Back to Dashboard</a>
  <h2 class="text-success">🥦 Vegetable Menu</h2>
  <?php
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']); // Remove message after display
}
?>


  <form method="post" action="save_selection.php">
    <div class="row">
      <?php
      // List of vegetable dishes with image paths and titles
      $vegetableDishes = [
        ["SALAD BOWL", "imgvegetables/salad_bowl.jpg.jpg"],
        ["Grilled Cabbage 'Steaks'", "imgvegetables/grilled_cabbage.jpg.avif"],
        ["Beef & Rice Stuffed Poblano Peppers", "imgvegetables/stuffed_peppers.jpg.avif"],
        ["Loaded Mediterranean Sweet Potato Fries", "imgvegetables/med_sweet_fries.jpg.avif"],
        ["Cheesy Garlic Zucchini Steaks", "imgvegetables/chessy_garlic.jpg"],
        ["Grilled Romaine Wedge", "imgvegetables/romaine_wedge.jpg.avif"],
        ["Cowboy Caviar Couscous Salad", "imgvegetables/cowboy_caviar.jpg.avif"],
        ["Fully Loaded Tornado Potatoes", "imgvegetables/tornado_potatoes.jpg"],
        ["Grilled Zucchini With Ricotta & Walnuts", "imgvegetables/zucchini_ricotta.jpg"],
     
      ];

      foreach ($vegetableDishes as $index => $dish) {
        echo '
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="' . $dish[1] . '" class="card-img-top" alt="' . $dish[0] . '">
            <div class="card-body text-center">
              <h6 class="card-title">' . $dish[0] . '</h6>
              <input type="checkbox" name="selected_dishes[]" value="' . $dish[0] . '"> Select
            </div>
          </div>
        </div>';
      }
      ?>
    </div>

    <div class="text-center mt-3">
      <button type="submit" class="btn btn-success">✔️ Save Selection</button>
    </div>
  </form>
</div>
</body>
</html>
