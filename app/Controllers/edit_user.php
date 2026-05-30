<?php
/*File for editing users from admin panel*/

session_start();
// Check if superuser is auth
if(!isset($_SESSION['is_auth']) || $_SESSION['is_auth'] != 1) {
    header("Location: ../Views/login.php");
    exit();
}

require_once('../../config/db.php');

// Get user ID and check if it valid
$id = $_POST['id'];

if ($id <= 0) {
    header("Location: ../Views/users.php?error=invalid_id");
    exit();
}

// Take existing data about user
$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 0) {
    header("Location: ../Views/users.php?error=user_not_found");
    exit();
}

$user = mysqli_fetch_assoc($result);
$pers_data = json_decode($user["pers_data"], true);

// For every field check if it empty, if its not empty - take new value, if its empty - take old
$login = !empty($_POST['login']) ? $_POST['login'] : $user['login'];
$password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];

// Check if user is already exists
$sql_check = "SELECT * from users WHERE login='$login'";
$result = mysqli_query($conn, $sql_check);
if (mysqli_num_rows($result) > 0) {
    header("Location: ../Views/admin_panel.php?error=user_with_login_exists");
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

$name = !empty($_POST['name']) ? $_POST['name'] : $pers_data['name'];
$surname = !empty($_POST['surname']) ? $_POST['surname'] : $pers_data['surname'];
$gender = !empty($_POST['gender']) ? $_POST['gender'] : $pers_data['gender'];
$date = !empty($_POST['date']) ? $_POST['date'] : $pers_data['date'];

$new_pers_data = json_encode([
    'name' => $name,
    'surname' => $surname,
    'sex' => $gender,
    'date' => $date
]);

// Update user info in database
$update_sql = "UPDATE users SET 
               login = '$login',
               password = '$password',
               pers_data = '$new_pers_data'
               WHERE id = $id";

if (mysqli_query($conn, $update_sql)) {
    header("Location: ../Views/admin_panel.php");
} else {
    header("Location: ../Views/users.php?error=update_failed");
}


