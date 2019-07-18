<?php
include 'verify.php';
include 'database_connect.php';

$id = $_GET['num'];


$update = "Delete from applications WHERE id='$id';";

if (!$conn->query($update) === TRUE) {
	echo "<script>";
	echo "alert('Error');";
	echo "</script>";
}
else {
	echo "<script>alert('Entry Deleted');</script>";
}

echo "<script>window.location.href = 'applications.php';</script>";

?>