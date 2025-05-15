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
  <title>Meat Menu</title>
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
  <h2 class="text-danger">🍖 Meat Menu</h2>

  <?php
  if (isset($_SESSION['message'])) {
      echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
      unset($_SESSION['message']);
  }
  ?>

  <form method="post" action="save_selection.php">
    <input type="hidden" name="category" value="meat">
    <div class="row">
      <?php
      $meatDishes = [
        ["Florentine Butter Chicken", "imagesmeat/florentine_butter_chicken.jpg.webp"],
        ["Chicken Katsu", "imagesmeat/chicken_katsu.jpg"],
        ["Steak, Potato, and Chorizo Kebabs", "imagesmeat/steak_kebabs.jpg"],
        ["Lamb Chops Sizzled with Garlic", "imagesmeat/lamb_chops.jpg"],
        ["Patty Melts with Scallion-Chipotle Mayo", "imagesmeat/patty_melts.jpg"],
        ["Garlic-Butter Steak Bites", "imagesmeat/steak_bites.jpg"],
      ];

      foreach ($meatDishes as $index => $dish) {
        echo '
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="' . $dish[1] . '" class="card-img-top" alt="' . $dish[0] . '">
            <div class="card-body text-center">
              <h6 class="card-title">' . $dish[0] . '</h6>
              <input type="checkbox" name="selected_meats[]" value="' . $dish[0] . '"> Select
            </div>
          </div>
        </div>';
      }
      ?>
    </div>

    <div class="text-center mt-3">
      <button type="submit" class="btn btn-danger">✔️ Save Selection</button>
    </div>
  </form>
</div>
</body>
</html>
