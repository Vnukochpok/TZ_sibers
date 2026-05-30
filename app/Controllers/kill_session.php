<?php
session_start();
$_SESSION['is_auth'] = false;
session_destroy();
header("Location: ../Views/login.php");
exit();
?>