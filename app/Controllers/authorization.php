<?php
/*File for authorization superusers*/
session_start();

require_once('../../config/db.php');
$login = $_POST['login'];
$password = $_POST['password'];

if (empty($login) || empty($password) || trim($login) == "" || trim($password) == "") {
    echo"Fill all fields" . "<br>" . "<a href='../Views/login.php'>Try again</a>";
    exit();
} else if (strlen($password) < 6) {
    echo "Password must be at least 6 characters" . "<br>" . "<a href='../Views/login.php'>Try again</a>";
    exit();
} else if (strlen($login) < 3) {
    echo "Login must be at least 3 characters" . "<br>" . "<a href='../Views/login.php'>Try again</a>";
    exit();
} 

// From superusers table ger login and check if it exists
$sql_check = "SELECT * from superusers WHERE login='$login'";
$result = mysqli_query($conn, $sql_check);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    // Verify the password
    if (password_verify($password, $row['password'])) {
        //echo "Successful";
        $_SESSION['is_auth'] = true;
        header("Location: ../Views/admin_panel.php");
    } else {
        echo "Wrong password" . "<br>" ."<a href='../Views/login.php'>Try again</a>";
        exit();
    }
} else {
    echo "User not found" . "<br>" . "<a href='../Views/login.php'>Try again</a>";
    exit();
}
