<?php
$db_name = "test";
$mysql_username = "root";
$mysql_password = "";
$server_name = "localhost";
$conn = mysqli_connect($server_name, $mysql_username, $mysql_password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}test123
?>