<?php
// Include database connection file
require_once "db_connect.php";

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get user input from form
	$user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
	$user_pw = mysqli_real_escape_string($conn, $_POST['user_pw']);
	$user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
	$f_name = mysqli_real_escape_string($conn, $_POST['f_name']);
	$l_name = mysqli_real_escape_string($conn, $_POST['l_name']);

	// Hash password for security
	$hashed_pw = password_hash($user_pw, PASSWORD_DEFAULT);

	// Insert user information into database
	$sql = "INSERT INTO user_info (user_name, user_pw, user_email, f_name, l_name, date_joined, last_login) 
			VALUES ('$user_name', '$hashed_pw', '$user_email', '$f_name', '$l_name', NOW(), NOW())";
	if (mysqli_query($conn, $sql)) {
		header("location: register_success.html");
		echo "Registration successful!";
		exit;
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	// Close database connection
	mysqli_close($conn);	
}
?>



