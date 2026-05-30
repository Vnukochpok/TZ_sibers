<?php
/*File for creating new users from admin panel*/
session_start();
// Check if superuser is auth
if(!isset($_SESSION['is_auth']) || $_SESSION['is_auth'] != 1) {
    header("Location: ../Views/login.php");
    exit();
}

require_once('../../config/db.php');

$login = $_POST['login'];
$password = $_POST['password'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$gender = $_POST['gender'];
$date = $_POST['date'];

// Check if fields are empty
if (empty($login) || empty($password) || empty($name) || empty($surname) || empty($gender) || empty($date) ||
    trim($login) == "" || trim($password) == "" || trim($name) == "" || trim($surname) == "" || trim($gender) == "" || trim($date) == "") {
    header("Location: ../Views/admin_panel.php?error=empty_fields");
    exit();
} else if (strlen($password) < 6) {
    header("Location: ../Views/admin_panel.php?error=short_password");
    exit();
} else if (strlen($login) < 3) {
    header("Location: ../Views/admin_panel.php?error=short_login");
    exit();
}

// Check if birthday is not in the future
$today = new DateTime('today');
if (!empty($_POST['date'])) {
    $birthday = new DateTime($_POST['date']);
    if ($birthday > $today) {
        header("Location: ../Views/admin_panel.php?error=invalid_date");
        exit();
    }
}

// Check if user is already exists
$sql_check = "SELECT * from users WHERE login='$login'";
$result = mysqli_query($conn, $sql_check);
if (mysqli_num_rows($result) > 0) {
    header("Location: ../Views/admin_panel.php?error=user_exists");
    exit();
}

// Converting data to json and hash password
$json = [
    "name" => $name,
    "surname" => $surname,
    "sex" => $gender,
    "date" => $date,
];

$data = json_encode($json);
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert new user to database
$sql = "INSERT INTO users (login, password, pers_data) VALUES ('$login', '$hashed_password', '$data')";

if (mysqli_query($conn, $sql)) {
    //echo "New record created successfully";
    header("Location: ../Views/admin_panel.php");
} else {
    //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    header("Location: ../Views/admin_panel.php");
}