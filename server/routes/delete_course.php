<?php
/**
 * DELETE COURSE: delete_course.php
 */
include 'db_connect.php';
session_//opt/data/home/projects/student_success_hub/server/routes/delete_course.php_start();

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE c FROM courses c JOIN semesters s ON c.semester_id = s.semester_id WHERE c.course_id = $id AND s.user_id = $_SESSION['user_id']");
}

$redirect = $_GET['redirect'] ?? 'courses.php';
header("Location: ../../app/src/pages/" . $redirect);
exit();
?>
