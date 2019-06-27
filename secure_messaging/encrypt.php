<?php
include 'authenticate.php';

if (!isset($_REQUEST['subject']) or !isset($_REQUEST['nickname'])) {
	die(include 'compose.php');
}

ini_set('display_errors', 'Off');

include 'db_connect.php';

$query = "select users.first_name as name from users where user_id='$user';";
$a = mysqli_query($conn, $query);
$row = mysqli_fetch_array($a, MYSQLI_ASSOC);
$user1 = $row['name'];

$_SESSION['subject'] = $_REQUEST['subject'];
$_SESSION['nickname'] = $_REQUEST['nickname'];
$_SESSION['from'] = $user1;
$_SESSION['to_whom'] = $_REQUEST['to_whom'];


die(include 'encrypter.php');
?>