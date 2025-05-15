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
                if (($key = array_search($dish, $_SESSION['selected_vegetables'] ?? [])) !== false) {
                    unset($_SESSION['selected_vegetables'][$key]);
                }
                break;
            case 'meat':
                if (($key = array_search($dish, $_SESSION['selected_meats'] ?? [])) !== false) {
                    unset($_SESSION['selected_meats'][$key]);
                }
                break;
            case 'protein':
                if (($key = array_search($dish, $_SESSION['selected_proteins'] ?? [])) !== false) {
                    unset($_SESSION['selected_proteins'][$key]);
                }
                break;
        }

        // Re-index arrays after unset
        $_SESSION['selected_vegetables'] = array_values($_SESSION['selected_vegetables'] ?? []);
        $_SESSION['selected_meats'] = array_values($_SESSION['selected_meats'] ?? []);
        $_SESSION['selected_proteins'] = array_values($_SESSION['selected_proteins'] ?? []);
    }
}

header("Location: my_selection.php");
exit();
