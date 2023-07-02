<?php
session_start();
require_once 'db_connect.php';


if ($_SESSION['is_admin'] && isset($_POST['recipe_id'])) {
    $recipe_id = $_POST['recipe_id'];
    $query = "DELETE FROM Recipe WHERE recipe_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    header("Location: view_recipe.php");
    exit();
} else {
    echo 'You do not have permission to delete this recipe.';
}
?>