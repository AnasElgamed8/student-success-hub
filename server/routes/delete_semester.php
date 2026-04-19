<?php
/**
 * DELETE SEMESTER: delete_semester.php
 * A simple utility file to handle deletion.
 */
include 'db_connect.php';
session_start();

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    // We use a WHERE clause to ensure users can only delete their own semesters.
    $conn->query("DELETE FROM semesters WHERE semester_id = $id AND user_id = $user_id");
}

header("Location: ../semesters.php?deleted=1");
exit();
?>
