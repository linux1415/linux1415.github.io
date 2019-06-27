<?php
include 'authenticate.php';

$text = $_REQUEST['text']; //get variable from form
$subject = $_SESSION['subject'];
$nickname = $_SESSION['nickname'];
$from = $_SESSION['from'];
$type = $_REQUEST['type'];
$to_whom = $_SESSION['to_whom'];



$now = new DateTime();
$now->setTimezone(new DateTimeZone('America/Chicago'));    // Another way
$date = $now->format('Y-m-d H:i:s');





ini_set('display_errors', 'Off');

include 'db_connect.php';

$sender = $user;

//checks to see if user exists; also verifies user input preventing sql injection
$query = "INSERT INTO messages (sender, message, reciever, subject, encryption_type, sender_name, key_nickname, date)
VALUES ('$sender', '$text', '$to_whom', '$subject', '$type', '$from', '$nickname', '$date');";

mysqli_query($conn, $query);
echo "<script>alert('Message Sent!!');</script>";
die(include 'home.php');
?>