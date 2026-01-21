<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'] ?? '';
    $dish = $_POST['dish'] ?? '';

    if ($category && $dish) {
        switch ($category) {
            case 'vegetable':
                if (isset($_SESSION['selected_vegetables'])) {
                    if (($key = array_search($dish, $_SESSION['selected_vegetables'])) !== false) {
                        unset($_SESSION['selected_vegetables'][$key]);
                    }
                    // Re-index array after removal
                    $_SESSION['selected_vegetables'] = array_values($_SESSION['selected_vegetables']);
                }
                break;

            case 'meat':
                if (isset($_SESSION['selected_meats'])) {
                    if (($key = array_search($dish, $_SESSION['selected_meats'])) !== false) {
                        unset($_SESSION['selected_meats'][$key]);
                    }
                    $_SESSION['selected_meats'] = array_values($_SESSION['selected_meats']);
                }
                break;

            case 'protein':
                if (isset($_SESSION['selected_proteins'])) {
                    if (($key = array_search($dish, $_SESSION['selected_proteins'])) !== false) {
                        unset($_SESSION['selected_proteins'][$key]);
                    }
                    $_SESSION['selected_proteins'] = array_values($_SESSION['selected_proteins']);
                }
                break;
        }
    }
}

// Redirect back to selection page after removal
header("Location: my_selection.php");
exit();
?>
