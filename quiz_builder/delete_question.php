<?php
include 'verify.php';
include 'database_connect.php';

$id = $_POST['id'];
$quiz_id = $_POST['quiz_id'];

$del_3 = "Delete from questions WHERE question_id='$id';";
$del_4 = "Delete from answers WHERE question_id='$id';";

mysqli_query($conn, $del_3);
mysqli_query($conn, $del_4);

echo "<script>alert('Question Deleted!');</script>";

echo "<script>window.location.href = 'edit_quiz_questions.php?id=$quiz_id';</script>";

?>