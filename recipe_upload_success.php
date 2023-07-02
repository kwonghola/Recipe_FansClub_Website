<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recipe Upload Success</title>
    <style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f7f7f7;
			margin: 0;
		}
		header {
			background-color: #333;
			color: #fff;
			padding: 20px;
			text-align: center;
		}
		h1 {
			margin: 0;
		}
		main {
			max-width: 800px;
			margin: 0 auto;
			padding: 20px;
			background-color: #fff;
			box-shadow: 0 0 10px rgba(0,0,0,0.2);
			border-radius: 5px;
			margin-top: 30px;
			margin-bottom: 30px;
		}
		form {
			display: flex;
			flex-direction: column;
			align-items: center;
			margin-bottom: 20px;
		}
		input, select, textarea {
			margin-bottom: 10px;
			padding: 10px;
			border-radius: 5px;
			border: 1px solid #ccc;
			font-size: 16px;
			width: 100%;
			box-sizing: border-box;
		}
		select {
			width: auto;
		}
		label {
			font-size: 18px;
			font-weight: bold;
			display: block;
			margin-bottom: 10px;
		}
		button {
			padding: 10px 20px;
			background-color: #333;
			color: #fff;
			border: none;
			border-radius: 5px;
			font-size: 16px;
			cursor: pointer;
			transition: all 0.2s;
		}
		button:hover {
			background-color: #444;
		}
	</style>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION["user_name"]; ?>!</h1>
    </header>

    <main>

        <h2>Recipe Uploaded Successfully!</h2>
        <p>Your recipe has been uploaded successfully. You can now view it in your recipes list.</p>
        <a href="welcome.php">Go Back to Home</a>
    </main>
</body>
</html>