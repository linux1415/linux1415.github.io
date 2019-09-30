<?php
include 'verify.php';
include 'database_connect.php';


$id = $_POST['id'];
$title = $_POST['title'];

$title = trim($title);

if ($title != "") {
	$update = "UPDATE quiz SET quiz_name = '$title' WHERE quiz_id = '$id';";
	mysqli_query($conn, $update);
}

echo "<script>window.location.href = 'quiz_manager.php';</script>";

?>