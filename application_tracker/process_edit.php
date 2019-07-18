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
$id = $_POST['app_id'];


$update = "UPDATE applications SET company = '$company', title = '$title', phone_screen = '$screen', interview = '$interview', status = '$status', date = '$date', notes = '$notes' WHERE id='$id';";

if (!$conn->query($update) === TRUE) {
	echo "<script>";
	echo "alert('Error');";
	echo "</script>";
}
else {
	echo "<script>alert('Edits Completed');</script>";
}

echo "<script>window.location.href = 'applications.php';</script>";

?>