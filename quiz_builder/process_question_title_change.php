<?php
include 'verify.php';
include 'database_connect.php';


$id = $_POST['id'];
$title = $_POST['title'];
$quiz = $_POST['quiz_id'];

$title = trim($title);

if ($title != "") {
	$update = "UPDATE questions SET question = '$title' WHERE question_id = '$id';";
	mysqli_query($conn, $update);
}

echo "<script>window.location.href = 'edit_quiz_questions.php?id=$quiz';</script>";

?>