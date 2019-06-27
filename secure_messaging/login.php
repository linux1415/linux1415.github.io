<?php
session_start();
//$user = $_REQUEST['user_id'];
//$pass = $_REQUEST['pass'];
$valid = "";

if (isset($_REQUEST['user_id']) && isset($_REQUEST['pass'])) {
	$user = $_REQUEST['user_id'];
	$hash = $_REQUEST['pass'];

}
else {
	echo "<script>window.location.replace('index.php');</script>";
	die();
}

ini_set('display_errors', 'Off');
 
include 'db_connect.php';


//checks to see if user exists; also verifies user input preventing sql injection
$check_user = "SELECT user_name, pass, user_id FROM users;";
$check_array = mysqli_query($conn, $check_user);
while ($possible_ids = mysqli_fetch_array($check_array, MYSQLI_ASSOC)){
	if ($possible_ids['user_name'] == $user and $possible_ids['pass'] == $hash) {
		$valid = "yes";
		$id_num = $possible_ids['user_id'];
	}
}
if ($valid == "yes") {
	$_SESSION['user_messenger'] = $id_num;
}
else {
	echo "<script>window.location.replace('index.php');</script>";
	die();	//goes back to login if user does not exist
}



//gets person name and account type; since user input was validated in the previous section, appending the input to an sql query should be safe
$query = "SELECT first_name as first, last_name as last, account_type as type, user_id as id
			FROM users
			WHERE user_name='$user';";
			
$array = mysqli_query($conn, $query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
$name = $row['first'] . ' ' . $row['last'];
$_SESSION['name'] = $name;
$_SESSION['id'] = $row['id'];

$account = $row['type'];

//verifies account type and directs user to appropriate home page
if ($account == "admin") {
	$_SESSION['account'] = "admin";		//defines session admin variable
	echo "<script>window.location.replace('home.php');</script>";

}
else {
	$_SESSION['account'] = "associate";		//defines session associate variable
	echo "<script>window.location.replace('home.php');</script>";
}

?>
