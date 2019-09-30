<?php
include 'verify.php';
include 'database_connect.php';

$id = $_POST['id'];


$del_1 = "Delete from quiz WHERE quiz_id='$id';";
$del_2 = "Delete from taken_quizzes WHERE quiz_id='$id';";
$del_3 = "Delete from questions WHERE quiz_id='$id';";
$del_4 = "Delete from answers WHERE quiz_id='$id';";

mysqli_query($conn, $del_1);
mysqli_query($conn, $del_2);
mysqli_query($conn, $del_3);
mysqli_query($conn, $del_4);

echo "<script>alert('Quiz Deleted!');</script>";

echo "<script>window.location.href = 'quiz_manager.php';</script>";

?>