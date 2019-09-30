<?php
include 'verify.php';
include 'database_connect.php';

$id = $_POST['id'];
$quiz_id = $_POST['quiz_id'];

$del = "Delete from taken_quizzes WHERE taken_quiz_id='$id';";
mysqli_query($conn, $del);

echo "<script>alert('Score Deleted!');</script>";

echo "<script>window.location.href = 'statistics.php?id=$quiz_id';</script>";

?>