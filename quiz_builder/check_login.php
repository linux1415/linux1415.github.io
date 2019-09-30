<?php
session_start();
include 'database_connect.php'; 

$user = trim($_REQUEST['email']);
$pass = trim($_REQUEST['password']);

$valid = "";

//checks to see if user exists; also verifies user input preventing sql injection
$check_user = "SELECT user_name, password, user_id FROM users;";
$check_array = mysqli_query($conn, $check_user);
while ($possible_ids = mysqli_fetch_array($check_array, MYSQLI_ASSOC)){
	if ($possible_ids['user_name'] == $user && $possible_ids['password'] == $pass) {
		$valid = "yes";
		$id_num = $possible_ids['user_id'];
	}
}
if ($valid == "yes") {
	$_SESSION['quizzer_id'] = $id_num;
	echo '<script>window.location.href="home.php";</script>';
}
else {
	echo '<script>window.location.href="login.php";</script>';
	die();
}

?>