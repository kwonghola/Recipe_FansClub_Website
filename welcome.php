<!DOCTYPE html>
<html>
    <head>
        <title>Welcome Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
		<?php
            session_start();
            $username = isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : "Guest";
        ?>    
        <header>
            <h1>Welcome to My Recipe Website</h1>
        </header>
		<nav>
        <ul>
            <li><a href="welcome.php">Home</a></li>
            <li><a href="upload_recipe.html">Upload Recipe</a></li>
            <li><a href="view_recipe.php">View Recipes</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
  		  </nav>
        <main>     
            <h2>Welcome, <?php echo $username; ?>!</h2>
            <p>Start sharing and exploring delicious recipes today!</p>
        </main>
    </body>
</html>
