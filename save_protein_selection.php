<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['selected_proteins'])) {
    $_SESSION['selected_proteins'] = $_POST['selected_proteins'];
    $_SESSION['message'] = "Protein selection saved successfully!";
} else {
    $_SESSION['message'] = "No protein dish selected.";
}

// Redirect back to the protein menu
header("Location: protein_menu.php"); // palitan ito ng tamang filename mo
exit();
