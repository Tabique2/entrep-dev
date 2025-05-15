<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Save vegetable dishes if posted
if (isset($_POST['selected_dishes'])) {
    $_SESSION['selected_vegetables'] = $_POST['selected_dishes'];
    $_SESSION['message'] = "Vegetable selection saved successfully!";
}

// Save meat dishes if posted
if (isset($_POST['selected_meats'])) {
    $_SESSION['selected_meats'] = $_POST['selected_meats'];
    $_SESSION['message'] = "Meat selection saved successfully!";
}

// Save protein dishes if posted
if (isset($_POST['selected_proteins'])) {
    $_SESSION['selected_proteins'] = $_POST['selected_proteins'];
    $_SESSION['message'] = "Protein selection saved successfully!";
}

// Redirect back to the previous page (form page)
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
