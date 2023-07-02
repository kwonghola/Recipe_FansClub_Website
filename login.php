<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
require_once "db_connect.php";

$login_err = "";
$user_email = $user_pw = "";
$user_email_err = $user_pw_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["user_email"]))){
        $user_email_err = "Please enter email.";
    } else{
        $user_email = trim($_POST["user_email"]);
    }
    
    if(empty(trim($_POST["user_pw"]))){
        $user_pw_err = "Please enter your password.";
    } else{
        $user_pw = trim($_POST["user_pw"]);
    }
    
    if(empty($user_email_err) && empty($user_pw_err)){
// Prepare a SELECT statement
$sql = "SELECT user_id, user_name, user_email, user_pw, is_admin FROM user_info WHERE user_email = ?";

if($stmt = mysqli_prepare($conn, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_email);
    
    // Set parameters
    $param_email = $user_email;
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
		
        // Store result
        mysqli_stmt_store_result($stmt);
               
        // Check if email exists, if yes then verify password
        if(mysqli_stmt_num_rows($stmt) >= 1){                    
            // Bind result variables
            mysqli_stmt_bind_result($stmt,$user_id, $user_name, $user_email, $hashed_password,$is_admin);
            if(mysqli_stmt_fetch($stmt)){
		
                if(password_verify($user_pw, $hashed_password)){
                    // Password is correct, so start a new session
                    session_start();
                                    
                    // Store data in session variables
					$_SESSION["user_id"] = $user_id;
                    $_SESSION["loggedin"] = true;
                    $_SESSION["user_name"] = $user_name;
                    $_SESSION["user_email"] = $user_email;
					if($is_admin!=0)
					$_SESSION["is_admin"] = true;
					else
					$_SESSION["is_admin"] = false;

                    // Redirect user to welcome page
                    header("location: welcome.php");
                } else{
                    // Password is not valid, display a generic error message
                    $login_err = "password not match";
                }
            }
        } else{
            // Email doesn't exist, display a generic error message
            $login_err = "Invalid email or password.";
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Form</title>
	<style>
		body {
			background-color: #f1f1f1;
		}
		form {
			display: flex;
			flex-direction: column;
			align-items: center;
			margin: 50px auto;
			padding: 20px;
			background-color: #fff;
			box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);
			border-radius: 8px;
			width: 400px;
		}
		h2 {
			text-align: center;
			margin-top: 50px;
			font-size: 36px;
			color: #333;
		}
		label {
			font-size: 18px;
			color: #333;
			margin-bottom: 5px;
		}
		input {
			margin-bottom: 15px;
			padding: 10px;
			border-radius: 5px;
			border: 1px solid #ccc;
			font-size: 16px;
			width: 100%;
			box-sizing: border-box;
		}
		button[type="submit"] {
			background-color: #4CAF50;
			color: #fff;
			padding: 10px 20px;
			border: none;
			border-radius: 5px;
			font-size: 18px;
			cursor: pointer;
			margin-top: 20px;
		}
		button[type="submit"]:hover {
			background-color: #3e8e41;
		}
		a {
			display: block;
			text-align: center;
			margin-top: 20px;
			font-size: 16px;
			color: #333;
			text-decoration: none;
		}
		a:hover {
			color: #000;
		}
		.error {
            color: red;
            margin: 10px 0;
        }
	</style>
</head>
<body>
	<h2>Login Form</h2>
	<form action="login.php" method="post">
		<label for="user_email">Email:</label>
		<input type="email" name="user_email" required>
		<label for="user_pw">Password:</label>
		<input type="password" name="user_pw" required>
		<button type="submit">Login</button>
		<a href="register.html">Don't have an account? Sign up now</a>
	</form>
	<?php if(!empty($login_err)): ?>
            <div class="error">
                <?php echo $login_err; ?>
            </div>
    <?php endif; ?>
</body>
</html>

