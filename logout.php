<?php
/**
 * LOGOUT PAGE: logout.php
 * Simply destroys the session and sends the user back to the login page.
 */
session_start();
session_destroy();
header("Location: index.php");
exit();
?>
