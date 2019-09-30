<?php
include 'verify.php';
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
    <title>Create Quiz</title>
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
			<h1 class="display-4">Create Quiz</h1>
			<hr class="my-4">
			<a class="btn btn-primary btn-lg mb-3"" href="quiz_manager.php" style="width:10em;" role="button">Quiz Manager</a>&nbsp;&nbsp;<a class="btn btn-primary btn-lg mb-3" href="home.php" style="width:10em;" role="button">Home</a>
		</div>
		<form action="process_create_quiz.php" method="post" name="input">
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" style="width:8em;">Quiz Name</span>
			</div>
			<input type="text" id="company" name="quiz_name" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" autocomplete="off" required>
		</div>

	<div class="input-group mb-3">
			<div class="input-group-prepend">
				<label class="input-group-text" for="inputGroupSelect01" style="width:8em;">Difficulty</label>
			</div>
			<select class="custom-select" name="difficulty" id="interview">
				<option value="0"></option>
				<option value="Easy">Easy</option>
				<option value="Medium">Medium</option>
				<option value="Hard">Hard</option>
			</select>
		</div>
		<input type='Submit' class="btn btn-primary btn-lg" value='Submit'></input>
	</form>
	</div>
	<br><br>
  </body>
</html>