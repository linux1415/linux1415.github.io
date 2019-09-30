<?php
session_start();

include 'database_connect.php';

$pass = mysqli_real_escape_string($conn, $_REQUEST['pass']);
$pass2 = mysqli_real_escape_string($conn, $_REQUEST['pass2']);
$user = mysqli_real_escape_string($conn, $_REQUEST['username']);

$pass = trim($pass);
$pass2 = trim($pass2);
$user = trim($user);

$query = "select * from users where user_name='$user';";
$array = mysqli_query($conn, $query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
if (count($row) > 0) {
	echo "<script>";
	echo "alert('Chosen Username Is Already In Use.');";
	echo "</script>";
	echo '<script>window.location.href="create_account.php";</script>';
	die();
}

if ($pass != $pass2) {
	echo "<script>";
	echo "alert('Passwords Do Not Match.');";
	echo "</script>";
	echo '<script>window.location.href="create_account.php";</script>';
	die();
}

$sql = "INSERT INTO users (user_name, password) VALUES ('$user', '$pass');";

if ($conn->query($sql) === TRUE) {
    echo "<script>";
	echo "alert('Account Created.');";
	echo "</script>";
} else {
    echo "<script>";
	echo "alert('Error.');";
	echo "</script>";
}

echo '<script>window.location.href="login.php";</script>';

?>