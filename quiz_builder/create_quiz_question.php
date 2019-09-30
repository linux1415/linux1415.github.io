<?php
include 'verify.php';
if(isset($_GET['id'])){ 
	$id = $_GET['id'];
	}
	
include 'database_connect.php';
$user = $_SESSION['quizzer_id'];
$user = '1';
		
$query = "select quiz_name from quiz where quiz_id = '$id';";
		
$array = mysqli_query($conn, $query);

$row = mysqli_fetch_array($array, MYSQLI_ASSOC);

$name = $row['quiz_name'];

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Create Quiz Question</title>
	<style>
	</style>
  </head>
  <script>
 function display_change() {
	var var1 = document.getElementById("choice");
	var var2 = var1.options[var1.selectedIndex].value;
	if (var2 == 1) {
		document.getElementById("multiple_choice").style.display="block";
		document.getElementById("true_false").style.display="none";
		document.getElementById("fill_in").style.display="none";
	    }
	if (var2 == 2) {
		document.getElementById("true_false").style.display="block";
		document.getElementById("fill_in").style.display="none";
		document.getElementById("multiple_choice").style.display="none";
	    }
	if (var2 == 3) {
		document.getElementById("fill_in").style.display="block";
		document.getElementById("true_false").style.display="none";
		document.getElementById("multiple_choice").style.display="none";
		}
}
  </script>

  <body>
	<div class="container">
		<div class="jumbotron">
			<h1 class="display-4">Add Quiz Question</h1>
			<p class="lead">Quiz: <?echo $name; ?></p>
			<hr class="my-4">
			<a class="btn btn-primary btn-lg mb-3" href="quiz_manager.php" style="width:10em;" role="button">Quiz Manager</a>&nbsp;&nbsp;<a class="btn btn-primary btn-lg mb-3" href="home.php" style="width:10em;" role="button">Home</a>&nbsp;&nbsp;<a class="btn btn-primary btn-lg mb-3" href="applications.php" style="width:10em;" role="button">Questions</a>
		</div>
		<div style="height:24em;" >
		<form action="process_quiz_question.php" method="post" name="input">
		<input type="text" value = "<?echo $id;?>" name="quiz_id" style="display:none;">
		<div class="input-group mb-3">
			<select class="form-control" name="choice" id="choice" onchange="display_change()">
			<option value="1">Multiple Choice</option>
			<option value="2">True or False</option>
			<option value="3">Fill In</option>
			</select>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" style="width:8em;">Question</span>
			</div>
			<input type="text" id="company" name="question" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" autocomplete="off" required>
		</div>
	<div id = "multiple_choice">
	<div class="input-group mb-3">
	<div class="input-group-prepend">
		<span class="input-group-text">1</span>
		<select class="custom-select" name="answer_1" id="inputGroupSelect01">
		<option value="0" selected>Incorrect</option>
		<option value="1">Correct</option>
		</select>
	</div>
	<input type="text" class="form-control" name="answer_1_text" autocomplete="off" aria-label="Text input with dropdown button">
	</div>
	<div class="input-group mb-3">
	<div class="input-group-prepend">
		<span class="input-group-text">2</span>
		<select class="custom-select" name="answer_2" id="inputGroupSelect01">
		<option value="0" selected>Incorrect</option>
		<option value="1">Correct</option>
		</select>
	</div>
	<input type="text" class="form-control" name="answer_2_text" autocomplete="off" aria-label="Text input with dropdown button">
	</div>
	<div class="input-group mb-3">
	<div class="input-group-prepend">
		<span class="input-group-text">3</span>
		<select class="custom-select" name="answer_3" id="inputGroupSelect01">
		<option value="0" selected>Incorrect</option>
		<option value="1">Correct</option>
		</select>
	</div>
	<input type="text" class="form-control" name="answer_3_text" autocomplete="off" aria-label="Text input with dropdown button">
	</div>
	<div class="input-group mb-3">
	<div class="input-group-prepend">
		<span class="input-group-text">4</span>
		<select class="custom-select" name="answer_4" id="inputGroupSelect01">
		<option value="0" selected>Incorrect</option>
		<option value="1">Correct</option>
		</select>
	</div>
	<input type="text" class="form-control" name="answer_4_text" autocomplete="off" aria-label="Text input with dropdown button">
	</div>
	</div>
	<div id="true_false"  style="display:none;">
	<div class="input-group mb-3">
			<div class="input-group-prepend">
				<label class="input-group-text" for="inputGroupSelect01" style="width:8em;">Answer</label>
			</div>
			<select class="custom-select" name="true_false_answer" id="interview">
				<option value="0"></option>
				<option value="True">True</option>
				<option value="False">False</option>
			</select>
		</div>
	</div>
	<div id="fill_in"  style="display:none;">
	<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" style="width:8em;">Answer</span>
			</div>
			<input type="text" name="fill_in" class="form-control" autocomplete="off" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
		</div>
	</div>
	<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" style="width:8em;">Points</span>
			</div>
			<input type="text" name="points" class="form-control" autocomplete="off" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
	</div>
	</div>
		<input type='Submit' class="btn btn-primary btn-lg" value='Submit'></input>
	</form>
	</div>
	<br><br>
  </body>
</html>