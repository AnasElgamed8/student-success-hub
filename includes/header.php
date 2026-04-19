<?php
/**
 * HEADER FILE: sidebar.php
 * This file contains the sidebar navigation. 
 * We 'include' this on every page so we don't have to rewrite the menu 12 times.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Success Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Google Font for a modern professional look -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

    <!-- THE SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-header">
            🎓 Success Hub
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php" class="active">📊 Dashboard</a></li>
            <li><a href="semesters.php">📅 Semesters</a></li>
            <li><a href="courses.php">📚 Courses</a></li>
            <li><a href="calculator.php">🧮 GPA Calculator</a></li>
            <li><a href="simulator.php">🎯 Goal Simulator</a></li>
            <li><a href="transcript.php">📜 Transcript</a></li>
            <li><a href="profile.php">👤 Profile Settings</a></li>
            <li class="mt-auto"><a href="logout.php" style="color: #f87171;">🚪 Logout</a></li>
        </ul>
    </div>

    <!-- THE MAIN CONTENT WRAPPER -->
    <div class="main-content">
