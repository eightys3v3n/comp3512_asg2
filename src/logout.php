<?php
// start or resume a session
session_start();
unset($_SESSION['u_id']);
// tell the browser we are sending html
header('Content-Type: text/html; charset=utf-8');
header('location: index.php');
?>
