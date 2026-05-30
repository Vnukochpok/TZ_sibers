<?php 
/*File for admin panel with user management*/

session_start();
// Check if superuser is auth
if(!isset($_SESSION['is_auth']) || $_SESSION['is_auth'] != 1) {
    header("Location: ../Views/login.php");
    exit();
}

include 'header.html';

require_once('../../config/db.php');

// Add logic of sorting and pagination
require_once('../Controllers/sort_by.php');
require_once('../Controllers/page_view.php');

$users_per_page = 5;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$sort_by_param = isset($_GET['sort']) ? $_GET['sort'] : 'id';

//
$sort_data = getSortOrder($sort_by_param);
$sort_by = $sort_data['sort_by'];
$order_by = $sort_data['order_by'];

$count_sql = "SELECT COUNT(*) as total FROM users";
$count_result = mysqli_query($conn, $count_sql);
$total_users = mysqli_fetch_assoc($count_result)['total'];

$pagination = calculatePagination($total_users, $users_per_page, $current_page);
$offset = $pagination['offset'];

$sql = "SELECT * FROM users $order_by LIMIT $offset, $users_per_page";
$result = mysqli_query($conn, $sql);

//render of sort buttons
renderSortButtons($sort_by);

//render users
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $pers_data = json_decode($row["pers_data"], true);
        echo "<p>ID: " . $row["id"]. 
             " | Login: " . $row["login"]. 
             " | Name and surname: " . $pers_data['name'] . " " . $pers_data['surname'] . 
             " | Gender: " . $pers_data['sex'] . 
             " | Birthday: " . $pers_data['date'] . 
             "</p>";
    }
} else {
    echo "<br>There is no users";
}

renderPagination($pagination['total_pages'], $pagination['current_page'], $sort_by);
?>

<h2>User management</h2>
<h4>Create user</h4>
<form action="../Controllers/create_user.php" method="post">
    <input type="text" name="login" placeholder="Login" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="text" name="surname" placeholder="Surname" required><br>
    <select name="gender" id="gender-select">
    <option value="Other">Choose your gender</option>
    <option value="Male">Male</option>
    <option value="Female">Female</option>
    <option value="Other">Other</option>
    </select><br>
    <input type="date" name="date" placeholder="Birthday" required><br>
    <button type="submit">Create user</button>
</form>
<h4>Delete user</h4>
<form action="../Controllers/delete_user.php" method="post">
    <input type="number" name="id" placeholder="ID" required><br>
    <button type="submit">Delete user</button>
</form>
<h4>Edit user information</h4>
<form action="../Controllers/edit_user.php" method="post">
    <input type="number" name="id" placeholder="ID" required><br>
    <input type="text" name="login" placeholder="Login"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <input type="text" name="name" placeholder="Name"><br>
    <input type="text" name="surname" placeholder="Surname"><br>
    <select name="gender" id="gender-select">
        <option value="Empty">Choose your gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select><br>
    <input type="date" name="date" placeholder="Birthday"><br>
    <button type="submit">Edit</button>
</form>
<br>
<form action="../Controllers/kill_session.php" method="post">
    <button type="submit">Logout</button>
</form>

<?php
include 'footer.html';