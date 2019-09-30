<?php
include 'verify.php';
include 'database_connect.php';


$name = $_POST['quiz_name'];
$diff = $_POST['difficulty'];
$user = $_SESSION['quizzer_id'];

$query = "insert into quiz (quiz_name, difficulty, user_id) values ('$name', '$diff', '$user')";

if (!$conn->query($query) === TRUE) {
	echo "<script>";
	echo "alert('Error');";
	echo "</script>";
}

$last = "select LAST_INSERT_ID() as id;";
$result = mysqli_query($conn, $last);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$id_num = $row['id'];


echo "<script>alert('Quiz Created');window.location.href = 'create_quiz_question.php?id=$id_num';</script>";

?>