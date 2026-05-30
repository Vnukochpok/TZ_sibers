<?php
/*File for deleting users from admin panel*/

session_start();
// Check if superuser is auth
if(!isset($_SESSION['is_auth']) || $_SESSION['is_auth'] != 1) {
    header("Location: ../Views/login.php");
    exit();
}

require_once('../../config/db.php');

$id = $_POST['id'];
// Check if id is valid
if ($id <= 0) {
    header("Location: ../Views/users.php?error=invalid_id");
    exit();
}

// Delete user from database
$sql = "DELETE FROM users WHERE id = $id";  
if (mysqli_query($conn, $sql)) {
    header("Location: ../Views/admin_panel.php");
} else {
    echo "Error deleting user: ";
}