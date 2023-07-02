<?php
session_start();

// Include your database connection script here
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipe_name = $_POST['recipe_name'];
    $cuisine_type = $_POST['cuisine_type'];
    $recipe_diff = $_POST['recipe_diff'];
    $recipe_time = $_POST['recipe_time'];
    $ingredient_1 = $_POST['ingredient_1'];
    $ingredient_2 = $_POST['ingredient_2'] ?? NULL;
    $ingredient_3 = $_POST['ingredient_3'] ?? NULL;
    $recipe_description = $_POST['recipe_description'];
    
    $user_id = $_SESSION['user_id'];  // Assuming you are storing user id in session

    // Prepare an insert statement
    $sql = "INSERT INTO Recipe (user_id, recipe_name, cuisine_type, diff_level, duration, Ingredient_1, Ingredient_2, Ingredient_3, recipe_desc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if($stmt = $conn->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("isssissss", $user_id, $recipe_name, $cuisine_type, $recipe_diff, $recipe_time, $ingredient_1, $ingredient_2, $ingredient_3, $recipe_description);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            header("Location: recipe_upload_success.php");  // redirect to success page
            exit();
        } else{
            echo "Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $conn->close();
}
?>