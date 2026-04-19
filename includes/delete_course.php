<?php
/**
 * DELETE COURSE: delete_course.php
 * Utility to remove a course and redirect back.
 */
include 'db_connect.php';
session_start();

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $id = $_GET['id'];
    
    // We check that the course belongs to a semester that belongs to the user.
    $conn->query("DELETE c FROM courses c JOIN semesters s ON c.semester_id = s.semester_id WHERE c.course_id = $id AND s.user_id = $_SESSION['user_id']");
}

$redirect = $_GET['redirect'] ?? 'courses.php';
header("Location: ../$redirect");
exit();
?>
