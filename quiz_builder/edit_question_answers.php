<?php
include 'verify.php';

if(isset($_GET['id']) && isset($_GET['quiz'])){ 
	$quest_id = $_GET['id'];
	$quiz_id = $_GET['quiz'];
	}
	
include 'database_connect.php';
$user = '1';
		
$query = "select question from questions where question_id = '$quest_id';";
		
$array = mysqli_query($conn, $query);

$row = mysqli_fetch_array($array, MYSQLI_ASSOC);

$name = $row['question'];
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
    <script src="jquery.tablesorter.min.js"></script>
	<script src="https://www.w3schools.com/lib/w3.js"></script>

	<script>
	$(function () {
		$('table').tablesorter({
			cssAsc: 'up',
			cssDesc: 'down',
			cssNone: ''
		});
	});
	</script>
	<style>
	th {
		cursor: pointer;
	}
	thead th.up {
		padding-right: 20px;
		background-image: url(data:image/gif;base64,R0lGODlhFQAEAIAAACMtMP///yH5BAEAAAEALAAAAAAVAAQAAAINjI8Bya2wnINUMopZAQA7);
	}
	thead th.down {
		padding-right: 20px;
		background-image: url(data:image/gif;base64,R0lGODlhFQAEAIAAACMtMP///yH5BAEAAAEALAAAAAAVAAQAAAINjB+gC+jP2ptn0WskLQA7);
	}
	thead th {
		background-repeat: no-repeat;
		background-position: right center;
	}
	</style>
	<script>
	function add(a) {
		var id = a;
		window.location.href = "create_quiz_question.php?id=" + id;
	}
	
	function edit(a) {
		var id = a;
		window.location.href = "edit_question_answers.php?id=" + id;
	}
	
	function del(a) {
		var id = a;
		window.location.href = "delete.php?num=" + id;
	}
	</script>
	<title>Edit Question Answers</title>
  </head>
  <body>
	<div class="container">
		<div class="jumbotron">
			<h1 class="display-4">Edit Question Answers</h1>
			<p class="lead">Question: <?echo $name; ?></p>
			<hr class="my-4">
			<a class="btn btn-primary btn-lg mb-3"" href="edit_quiz_questions.php?id=<? echo $quiz_id; ?>" style="width:10em;" role="button">Back</a>&nbsp;&nbsp;<a class="btn btn-primary btn-lg mb-3"" href="quiz_manager.php" style="width:10em;" role="button">Quiz Manager</a>&nbsp;&nbsp;<a class="btn btn-primary btn-lg mb-3" href="home.php" style="width:10em;" role="button">Home</a>
		</div>

		<table class="table"  id="my_table" class="tablesorter">
			<thead class="thead-light">
				<tr>
					<th scope="col" style="width:40%;">Answer</th>
					<th scope="col" style="width:20%;"></th>
					<th scope="col" style="width:40%;"></th>
				</tr>
			</thead>
			<tbody>
		<?
		
		$query = "select * from answers where question_id = '$quest_id' order by answer;";
		
		$array = mysqli_query($conn, $query);

		while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
			$answer = $row['answer'];
			$id = $row['answer_id'];
			echo "<tr class=\"item\">";
			echo "<td>$answer</td><td>";
			
				echo "<button type='button' class='btn btn-success btn-sm mb-3' data-toggle='modal' data-target='#exampleModalCenter_$id'>Edit Answer</button>";
				echo '<div class="modal fade" id="';
				echo "exampleModalCenter_" . $id;
				echo '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Edit Answer</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">';
				echo "<form action='process_answer_title_change.php' method='post'>
				<div class='form-group'>
					<input type='text' class='form-control' name='title' autocomplete='off' value='$answer'>
					<input type='text' name='id' value='$id' style='display:none;'>
					<input type='text' name='quest_id' value='$quest_id' style='display:none;'>
					<input type='text' name='quiz_id' value='$quiz_id' style='display:none;'>
				</div>";
				echo'</div>
				<div class="modal-footer">
				<input type="Submit" class="btn btn-primary" value="Submit"></input>
				</form>
				</div>
				</div>
				</div>
				</div>';
				
			echo "</td></tr>";
		}
		?>
			</tbody>
		</table>
	</div>

  </body>
</html>