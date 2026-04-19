<?php
/**
 * AUTH PROCESS: auth_process.php
 * This file handles the backend logic for logging in and registering.
 * It's a "headless" file—it does the work and then redirects the user.
 */

include 'db_connect.php';
session_start();

// --- REGISTER LOGIC ---
if (isset($_POST['register'])) {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // In a real app, we would use password_hash()

    // Check if email already exists
    $check = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($check->num_rows > 0) {
        header("Location: ../register.php?error=Email already exists");
        exit();
    }

    // Insert new user into database
    $sql = "INSERT INTO users (full_name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql)) {
        header("Location: ../index.php?success=Account created");
    } else {
        header("Location: ../register.php?error=Registration failed");
    }
}

// --- LOGIN LOGIC ---
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Find user with this email and password
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Store user info in a SESSION (a temporary memory on the server)
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['full_name'];
        
        header("Location: ../dashboard.php");
    } else {
        header("Location: ../index.php?error=Invalid email or password");
    }
}

// --- LOGOUT LOGIC ---
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: ../index.php");
}
?>
