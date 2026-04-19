<?php
/**
 * DATABASE CONNECTION FILE
 * This file is the 'bridge' between your PHP code and the MySQL database.
 * Every page that needs to save or load data will 'include' this file.
 */

$host = "localhost";
$user = "root"; // Default XAMPP/WAMP user
$pass = "";     // Default XAMPP/WAMP password (usually empty)
$dbname = "student_success_db";

// Create a connection using the mysqli extension
$conn = new mysqli($host, $user, $pass, $dbname);

// Check if the connection worked. If not, stop the program and show an error.
if ($conn->connect_error) {
    die("❌ Database Connection Failed: " . $conn->connect_error);
}

// Set the character set to utf8mb4 to ensure special characters are handled correctly.
$conn->set_charset("utf8mb4");

// Note for Anas: In a real project, we would use an environment file (.env) 
// to hide these passwords, but for the professor, keeping it here is simpler to explain.
?>
