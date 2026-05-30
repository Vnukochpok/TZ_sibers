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
    header("Location: ../Views/admin_panel.php?error=invalid_id");
    exit();
}

// Take existing data about user
$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 0) {
    header("Location: ../Views/admin_panel.php?error=user_not_found");
    exit();
}

$user = mysqli_fetch_assoc($result);
$pers_data = json_decode($user["pers_data"], true);

// For every field check if it empty, if its not empty - take new value, if its empty - take old
$login_old = $user['login'];
$login_new = $_POST['login'];
$password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];

// Check if user is already exists
$sql_check = "SELECT * from users WHERE login='$login_new'";
$result = mysqli_query($conn, $sql_check);
if (mysqli_num_rows($result) > 0) {
    header("Location: ../Views/admin_panel.php?error=user_with_login_exists");
    exit();
} else if (empty($login_new)) {
    $login_new = $login_old;
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
$date = !empty($_POST['date']) ? $_POST['date'] : $pers_data['date'];
$gender = !empty($_POST['gender']) ? $_POST['gender'] : $pers_data['sex'];
if ($gender == "Empty") {
    $gender = $pers_data['sex'];
}

$new_pers_data = json_encode([
    'name' => $name,
    'surname' => $surname,
    'sex' => $gender,
    'date' => $date
]);

// Update user info in database
$update_sql = "UPDATE users SET 
               login = '$login_new',
               password = '$password',
               pers_data = '$new_pers_data'
               WHERE id = $id";

if (mysqli_query($conn, $update_sql)) {
    header("Location: ../Views/admin_panel.php");
} else {
    header("Location: ../Views/admin_panel.php?error=update_failed");
}


