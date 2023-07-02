<?php

// Change these variables to match your MySQL server settings
$host = "localhost";
$username = "root";
$password = "";		
$database = "recipe_db";

// Create a new mysqli object and connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to utf8mb4 for full Unicode support
$conn->set_charset("utf8mb4");

?>
