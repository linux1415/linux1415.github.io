<?php
include 'verify.php';
include 'database_connect.php';


$id = $_POST['id'];
$title = $_POST['title'];
$quest = $_POST['quest_id'];
$quiz = $_POST['quiz_id'];

$title = trim($title);

if ($title != "") {
	$update = "UPDATE answers SET answer = '$title' WHERE answer_id = '$id';";
	mysqli_query($conn, $update);
}

echo "<script>window.location.href = 'edit_question_answers.php?id=$quest&quiz=$quiz';</script>";

?>