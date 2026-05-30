<?php   

$servername = "mysql";
$username = "root";
$password = "example";
$dbname = "db_tz_sibers";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
