<?php
include 'verify.php';
if(isset($_GET['id'])){ 
	$quiz_id = $_GET['id'];
	}
	
include 'database_connect.php';
$user = $_SESSION['id_app_tracker'];
$user = '1';
		
$query = "select quiz_name from quiz where quiz_id = '$quiz_id';";
		
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
    <script>
	var results = {};
	var answers =[];
	var results2 = {};
	var correct = {};
	var overall = 0;
	var num_correct = 0;
	var points = 0; 
	var overall_points = 0;
	
	function add(a, b, c) {
		var answer = a;
		var question = b;
		if (c == 'fill_in') {
			var result = document.getElementById('id_' + answer).value;
			result = result.toLowerCase();
			results[question] = [result, answer];
		}
		else {
			results[question] = [answer, answer];		
			results2[question] = answer;						
			answers.push(answer);
			for (var item of answers) {
				document.getElementById('id_' + item).style.background='white';
			}
			for (var key in results2) {
				document.getElementById('id_' + results2[key]).style.background='#007bff';
			}
		}
	}
	
	function score() {
		overall = 0; num_correct = 0; points = 0; overall_points = 0; var input_len = 0;
		for (var key in correct) {
			overall += 1;
			overall_points += parseInt(correct[key][2]);
		}
		for (var key in results) {
			input_len += 1;
		}
		if (Number(overall) != Number(input_len)) {
			alert("Quiz must be completed before scoring.");
			return;
		}
		for (var key in results) {
			if (results[key][0] != correct[key][0]) {
				document.getElementById('id_' + results[key][1]).style.background='#dc3545';
			}
			else {
				document.getElementById('id_' + results[key][1]).style.background='#007bff';
				num_correct += 1;
				points += parseInt(correct[key][2]);
			}
		}
		document.getElementById("bottom").style.display="block";
		document.getElementById("score_button").style.display="none";
		var to_print = "Number Correct:&nbsp;" + num_correct + "/" + overall + "<br><br>Total Points:&nbsp;" + points + "/" + overall_points;
		document.getElementById("scores").innerHTML = to_print;
		document.getElementById("main_button").innerHTML = "Done";
		if (Number(overall) != Number(num_correct)) {
			document.getElementById("sh_ans").style.display="block";
		}
		else {
			document.getElementById("sh_no_ans").style.display="block";
		}
		document.body.scrollTop = document.documentElement.scrollTop = 0;
	}
	
	function correct_answers(a, b, c, d, e) {
		var question = a;
		var answer = b;
		answer = answer.toLowerCase();
		var id = c;
		var points = d;
		var type = e;
		correct[question] = [answer, id, points, type];	
	}

	function show_answers() {
		for (var key in results) {
			if (results[key][0] != correct[key][0]) {
				document.getElementById('id_' + results[key][1]).style.background='#dc3545';
				if (correct[key][3] == 'multiple') {
					document.getElementById('id_' + correct[key][1]).style.background='#007bff';
				}
				else {
					var wrong_ans = document.getElementById('id_' + results[key][1]).value;	
					var to_print = wrong_ans + "	Correct Answer: " + correct[key][0];
					document.getElementById('id_' + results[key][1]).value = to_print;
				}
			}
		}
		document.body.scrollTop = document.documentElement.scrollTop = 0;	
	}
	
	function redo() {
		location.reload();
		document.body.scrollTop = document.documentElement.scrollTop = 0;	
	}
	
	function save(a) {
		var quiz_id = a;
		var percent = (points / overall_points) * 100;
		percent = Math.round(percent);
		window.location.href = "save_score.php?quiz_id=" + quiz_id + "&percent=" + percent;	
	}
	
	function home() {
		window.location.href = 'home.php';
	}

	
	</script>
	<title>Quiz</title>
  </head>
  <body>
	<div class="container">
	<div class="jumbotron">
			<h1 class="display-4"><? echo $name; ?></h1>
			<!--<hr class="my-4">
			<a class="btn btn-primary btn-lg mb-3"" href="home.php" style="width:10em;" role="button">Home</a>-->
	</div>
			<?
		include 'database_connect.php';
		$user = $_SESSION['id_app_tracker'];
		$user = '1';
		$query = "select type, points, question, question_id, correct_answer from questions where quiz_id = '$quiz_id';";
		$array1 = mysqli_query($conn, $query);
		$count = 0;
		while ($row1 = mysqli_fetch_array($array1, MYSQLI_ASSOC)){
			$count += 1;
			$question = $row1['question'];
			$correct_ans = $row1['correct_answer'];
			$type = $row1['type'];
			$points = $row1['points'];
			$id = $row1['question_id'];
			$query = "select * from answers where question_id = '$id';";
			$array2 = mysqli_query($conn, $query);
			
			echo "<div class='card'>
					<div class='card-header'>$points Points</div>
					<div class='card-body' id='quest_$id'>
						<h5 class='card-title'>$question</h5>
						<p class='card-text'>";
			
			while ($row2 = mysqli_fetch_array($array2, MYSQLI_ASSOC)){
				$answer = $row2['answer'];
				$ans_id = $row2['answer_id'];
				if ($type != 'fill_in') {
					echo "<div class='list-group'>";
					echo "<button type='button' onclick='add(\"$ans_id\", \"$id\", \"multiple\")' class='list-group-item list-group-item-action' id='id_$ans_id'>";
					echo "$answer";
					echo "</button>";
					echo "</div>";
					if ($ans_id == $correct_ans) {
						$mult_answer = $ans_id;
					}
				}
				else {
					echo "<input type='text' onchange='add(\"$ans_id\", \"$id\", \"fill_in\")' class='form-control' id='id_$ans_id'>";
					if ($ans_id == $correct_ans) {
						$fill_answer = $answer;
						$ans_id_1 = $ans_id;
					}
				}
			}

			echo		"</p>
					</div>
				</div><br><br>";
			if ($type == 'fill_in') {
				echo "<script>correct_answers(\"$id\", \"$fill_answer\", \"$ans_id_1\", \"$points\", \"fill_in\");</script>";
			}
			else {
				echo "<script>correct_answers(\"$id\", \"$mult_answer\", \"$mult_answer\", \"$points\", \"multiple\");</script>";
			}
		}
		?>
	<div id="bottom" style="display:none;">
	<div class="alert alert-primary" role="alert">
	<span id="scores"></span>
	</div>
	<div id="sh_ans" style="display:none;">
	<button type='button' class="btn btn-primary btn-lg" onclick="show_answers();">Show Answers</button>&nbsp;
	<button type='button' class="btn btn-primary btn-lg" onclick="redo();">Redo</button>&nbsp;
	<button type='button' class="btn btn-primary btn-lg" onclick="save(<?echo "'$quiz_id'";  ?>);">Save</button>&nbsp;
	<button type='button' class="btn btn-primary btn-lg" onclick="home();">Home</button><br><br>
	</div>
	<div id="sh_no_ans" style="display:none;">
	<button type='button' class="btn btn-primary btn-lg" onclick="redo();">Redo</button>&nbsp;
	<button type='button' class="btn btn-primary btn-lg" onclick="save(<?echo "'$quiz_id'";  ?>);">Save</button>&nbsp;
	<button type='button' class="btn btn-primary btn-lg" onclick="home();">Home</button><br><br>
	</div>
	</div>
	<div id="score_button">
	<button type='button' class="btn btn-primary btn-lg" onclick="score();"><span id="main_button">Score</span></button>&nbsp;
	<button type='button' class="btn btn-primary btn-lg" onclick="home();">Home</button><br><br>
	</div>
	</div>

  </body>
</html>