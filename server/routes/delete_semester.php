<?php
/**
 * DELETE SEMESTER: delete_semester.php
 */
include 'db_connect.php';
session_start();

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $conn->query("DELETE FROM semesters WHERE semester_id = $id AND user_id = $user_id");
}

header("Location: ../../app/src/pages/semesters.php?deleted=1");
exit();
?>
