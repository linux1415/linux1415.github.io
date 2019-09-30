<?php
include 'verify.php';
include 'database_connect.php';


$choice = $_POST['choice'];
$question = $_POST['question'].trim();
$points = $_POST['points'].trim();
$id = $_POST['quiz_id'];

if ($choice == '1') {
	$ans_1 = $_POST['answer_1'];
	$ans_2 = $_POST['answer_2'];
	$ans_3 = $_POST['answer_3'];
	$ans_4 = $_POST['answer_4'];
	$ans_1_t = $_POST['answer_1_text'].trim();
	$ans_2_t = $_POST['answer_2_text'].trim();
	$ans_3_t = $_POST['answer_3_text'].trim();
	$ans_4_t = $_POST['answer_4_text'].trim();
	
	$query = "insert into questions (question, type, points, quiz_id) values ('$question', 'multiple', '$points', '$id')";
	if (!$conn->query($query) === TRUE) {
		echo "<script>";
		echo "alert('Error');";
		echo "</script>";
	}
	$last = "select LAST_INSERT_ID() as id;";
	$result = mysqli_query($conn, $last);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$quest_id = $row['id'];
	if (strlen($ans_1_t) > 0) {
		$query = "insert into answers (question_id, answer, quiz_id) values ('$quest_id', '$ans_1_t', '$id')";
		mysqli_query($conn, $query);
	}
	if (strlen($ans_2_t) > 0) {
		$query = "insert into answers (question_id, answer, quiz_id) values ('$quest_id', '$ans_2_t', '$id')";
		mysqli_query($conn, $query);
	}
	if (strlen($ans_3_t) > 0) {
		$query = "insert into answers (question_id, answer, quiz_id) values ('$quest_id', '$ans_3_t', '$id')";
		mysqli_query($conn, $query);
	}
	if (strlen($ans_4_t) > 0) {
		$query = "insert into answers (question_id, answer, quiz_id) values ('$quest_id', '$ans_4_t', '$id')";
		mysqli_query($conn, $query);
	}
	
	if ($ans_1 == '1') {
		$correct = $ans_1_t;
	}
	if ($ans_2 == '1') {
		$correct = $ans_2_t;
	}
	if ($ans_3 == '1') {
		$correct = $ans_3_t;
	}
	if ($ans_4 == '1') {
		$correct = $ans_4_t;
	}
	
	$correct_id = "select answer_id from answers where question_id = '$quest_id' and answer = '$correct';";
	$result = mysqli_query($conn, $correct_id);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$correct_answer = $row['answer_id'];
	
	$update = "UPDATE questions SET correct_answer = '$correct_answer' WHERE question_id = '$quest_id';";
	mysqli_query($conn, $update);
}
if ($choice == '2') {
	$true_false_answer = $_POST['true_false_answer'];
	$query = "insert into questions (question, type, points, quiz_id) values ('$question', 'true_false', '$points', '$id')";
	if (!$conn->query($query) === TRUE) {
		echo "<script>";
		echo "alert('Error');";
		echo "</script>";
	}
	$last = "select LAST_INSERT_ID() as id;";
	$result = mysqli_query($conn, $last);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$quest_id = $row['id'];
	
	$query = "insert into answers (question_id, answer, quiz_id) values ('$quest_id', 'True', '$id')";
	mysqli_query($conn, $query);
	$query = "insert into answers (question_id, answer, quiz_id) values ('$quest_id', 'False', '$id')";
	mysqli_query($conn, $query);
	
	$correct_id = "select answer_id from answers where question_id = '$quest_id' and answer = '$true_false_answer';";
	$result = mysqli_query($conn, $correct_id);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$correct_answer = $row['answer_id'];
	
	$update = "UPDATE questions SET correct_answer = '$correct_answer' WHERE question_id = '$quest_id';";
	mysqli_query($conn, $update);
}
if ($choice == '3') {
	$fill_in_answer = $_POST['fill_in'];
	$query = "insert into questions (question, type, points, quiz_id) values ('$question', 'fill_in', '$points', '$id')";
	if (!$conn->query($query) === TRUE) {
		echo "<script>";
		echo "alert('Error');";
		echo "</script>";
	}
	$last = "select LAST_INSERT_ID() as id;";
	$result = mysqli_query($conn, $last);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$quest_id = $row['id'];
	
	$query = "insert into answers (question_id, answer, quiz_id) values ('$quest_id', '$fill_in_answer', '$id')";
	mysqli_query($conn, $query);
	
	$last = "select LAST_INSERT_ID() as id;";
	$result = mysqli_query($conn, $last);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$correct_answer = $row['id'];
	
	$update = "UPDATE questions SET correct_answer = '$correct_answer' WHERE question_id = '$quest_id';";
	mysqli_query($conn, $update);
}




echo "<script>alert('Question Added');window.location.href = 'create_quiz_question.php?id=$id';</script>";

?>