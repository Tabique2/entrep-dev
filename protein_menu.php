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
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 1px 1px 5px #999;
    }
    .dish-image {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 5px;
    }
  </style>
</head>
<body class="bg-light">
<div class="container mt-4">
    <!-- Back to Dashboard Button -->
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

    <form action="save_protein_selection.php" method="post">
        <input type="hidden" name="category" value="protein">
        <div class="row">
            <?php
            $protein_items = [
                ["name" => "Cottage Cheese Baked Ziti", "image" => "imageprotein/cottage_cheese_baked_ziti.jpg"],
                ["name" => "Florentine Butter Chicken", "image" => "imageprotein/florentine_butter_chicken.jpg"],
                ["name" => "White Bean & Smoked Sausage Skillet", "image" => "imageprotein/white_bean_smoked_sausage.jpg"],
                ["name" => "Sweet & Sour Tofu", "image" => "imageprotein/sweet_sour_tofu.jpg"],
                ["name" => "Lemon-Brown Butter Salmon", "image" => "imageprotein/lemon_brown_butter_salmon.jpg"],
                ["name" => "Miso Salmon & Farro Bowl", "image" => "imageprotein/miso_salmon_farro_bowl.jpg"],
                ["name" => "Indian Butter Chickpeas", "image" => "imageprotein/indian_butter_chickpeas.jpg"],
                ["name" => "Beef & Rice Stuffed Poblano Peppers", "image" => "imageprotein/beef_rice_stuffed_poblano_peppers.jpg"],
            ];

            foreach ($protein_items as $index => $item): ?>
                <div class="col-md-3">
                    <div class="dish-card bg-white">
                        <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="dish-image">
                        <h6 class="mt-2 font-weight-bold"><?php echo $item['name']; ?></h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="selected_proteins[]" value="<?php echo $item['name']; ?>" id="protein<?php echo $index; ?>">
                            <label class="form-check-label" for="protein<?php echo $index; ?>">Select</label>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="btn btn-primary mt-4">✅ Save Selection</button>
    </form>

    <a href="my_selection.php" class="btn btn-outline-dark mt-3">📋 View My Selections</a>
</div>
</body>
</html>
