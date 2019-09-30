<?php
include 'verify.php';
include 'database_connect.php';


$quiz_id = $_GET['quiz_id'];
$percent = $_GET['percent'];
$user = $_SESSION['quizzer_id'];

$now = new DateTime();
$now->setTimezone(new DateTimeZone('America/Chicago'));  
$date_time = $now->format('Y-m-d H:i:s');
$date = $now->format('Y-m-d');


$query = "insert into taken_quizzes (date, quiz_id, user_id, score) values ('$date', '$quiz_id', '$user', '$percent')";

if (!$conn->query($query) === TRUE) {
	echo "<script>";
	echo "alert('Error');";
	echo "</script>";
}

echo "<script>alert('Quiz Score Saved!');window.location.href = 'home.php';</script>";

?>