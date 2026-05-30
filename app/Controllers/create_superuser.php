<?php
/*File for register new superuser*/

require_once('../../config/db.php');

$login = $_POST['login'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$email = $_POST['email'];
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Check if password match and fields not empty
if ($password != $confirm_password) {
    echo "Passwords do not match" . "<br>" . "<a href='../Views/add_superuser.php'>Try again</a>";
    exit();
} else if(empty($email) || empty($password) || empty($login) || trim($login) == "" || trim($password) == "" || trim($email) == "") {
    echo "Fill all fields" . "<br>" . "<a href='../Views/add_superuser.php'>Try again</a>";
    exit();
} else if (strlen($password) < 6) {
    echo "Password must be at least 6 characters" . "<br>" . "<a href='../Views/add_superuser.php'>Try again</a>";
    exit();
} else if (strlen($login) < 3) {
    echo "Login must be at least 3 characters" . "<br>" . "<a href='../Views/add_superuser.php'>Try again</a>";
    exit();
} 

// Check if superuser with this login already exists
$sql_check = "SELECT * from superusers WHERE login='$login'";
$result = mysqli_query($conn, $sql_check);
if (mysqli_num_rows($result) > 0) {
    echo "User with this login already exists" . "<br>" . "<a href='../Views/add_superuser.php'>Try again</a>";
    exit();
}

// Insert new superuser to database
$sql = "INSERT INTO superusers (login, password, email) VALUES ('$login', '$password_hash', '$email')";
if (mysqli_query($conn, $sql)) {
    //echo "Superuser created";
    header("Location: ../Views/login.php");
} else {
    echo "Error" . "<br>" . "<a href='../Views/add_superuser.php'>Try again</a>";
    echo "<br>" . "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);