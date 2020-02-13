<?php
session_start();
include 'database_connect.php'; 

$user = trim($_REQUEST['email']);
$pass = trim($_REQUEST['password']);

$valid = "";

//checks to see if user exists; also verifies user input preventing sql injection
$check_user = "SELECT username, password, id FROM users;";
$check_array = mysqli_query($conn, $check_user);
while ($possible_ids = mysqli_fetch_array($check_array, MYSQLI_ASSOC)){
	if ($possible_ids['username'] == $user && $possible_ids['password'] == $pass) {
		$valid = "yes";
		$id_num = $possible_ids['id'];
	}
}
if ($valid == "yes") {
	$_SESSION['member_id'] = $id_num;
	echo '<script>window.location.href="home.php";</script>';
}
else {
	echo '<script>window.location.href="login.php";</script>';
	die();
}

?>