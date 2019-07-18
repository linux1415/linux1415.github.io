<?php
include 'verify.php';
include 'database_connect.php';

$company = $_POST['company'];
$title = $_POST['title'];
$screen = $_POST['screen'];
$interview = $_POST['interview'];
$status = $_POST['status'];
$notes = $_POST['notes'];
$date = $_POST['date'];
$user = $_SESSION['id_app_tracker'];

$update_query = "insert into applications (company, title, phone_screen, interview, status, date, notes, user) values ('$company', '$title', '$screen', '$interview', '$status', '$date', '$notes', '$user')";
if (!$conn->query($update_query) === TRUE) {
	echo "<script>";
	echo "alert('Error');";
	echo "</script>";
}

echo "<script>alert('Submission Complete');window.location.href = 'new.php';</script>";

?>