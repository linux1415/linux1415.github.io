<?php
include 'verify.php';

if(isset($_GET['id'])){ 
	$quiz_id = $_GET['id'];
	}
	
include 'database_connect.php';
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
	
	function edit(a, b) {
		var id = a;
		var quiz = b;
		window.location.href = "edit_question_answers.php?id=" + id  + "&quiz=" + quiz;
	}
	
	function del(a) {
		var id = a;
		window.location.href = "delete.php?num=" + id;
	}
	</script>
	<title>Edit Quiz Questions</title>
  </head>
  <body>
	<div class="container">
		<div class="jumbotron">
			<h1 class="display-4">Edit Quiz Questions</h1>
			<p class="lead">Quiz: <?echo $name; ?></p>
			<hr class="my-4">
			<a class="btn btn-primary btn-lg mb-3"" href="quiz_manager.php" style="width:10em;" role="button">Quiz Manager</a>&nbsp;&nbsp;<a class="btn btn-primary btn-lg mb-3" href="home.php" style="width:10em;" role="button">Home</a>
		</div>

		<input class="form-control" oninput="w3.filterHTML('#my_table', '.item', this.value)" placeholder="Filter" style="text-align:center;">
		<table class="table"  id="my_table" class="tablesorter">
			<thead class="thead-light">
				<tr>
					<th scope="col" style="width:40%;">Question</th>
					<th scope="col" style="width:15%;"></th>
					<th scope="col" style="width:20%;">Type</th>
					<th scope="col" style="width:25%;"></th>
				</tr>
			</thead>
			<tbody>
		<?
		
		$query = "select * from questions where quiz_id = '$quiz_id' order by type;";
		
		$array = mysqli_query($conn, $query);

		while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
			$quest = $row['question'];
			$type = $row['type'];
			$id = $row['question_id'];
			echo "<tr class=\"item\">";
			echo "<td>$quest</td><td>";
			
				echo "<button type='button' class='btn btn-success btn-sm mb-3' data-toggle='modal' data-target='#exampleModalCenter_$id'>Edit Question</button>";
				echo '<div class="modal fade" id="';
				echo "exampleModalCenter_" . $id;
				echo '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Edit Question</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">';
				echo "<form action='process_question_title_change.php' method='post'>
				<div class='form-group'>
					<input type='text' class='form-control' name='title' autocomplete='off' value='$quest'>
					<input type='text' name='id' value='$id' style='display:none;'>
					<input type='text' name='quiz_id' value='$quiz_id' style='display:none;'>
				</div>";
				echo'</div>
				<div class="modal-footer">
				<input type="Submit" class="btn btn-primary" value="Submit"></input>
				</form>
				</div>
				</div>
				</div>
				</div></td>';
			if ($type == 'true_false') {
				echo "<td>True/False</td>";
			}
			if ($type == 'multiple') {
				echo "<td>Multiple Choice</td>";
			}
			if ($type == 'fill_in') {
				echo "<td>Fill In</td>";
			}
			echo "<td style='text-align:center;'>";
			if ($type != 'true_false') {
				echo "<button type='button' onclick='edit(\"$id\", \"$quiz_id\")' class='btn btn-primary btn-sm mb-3'>Edit Answers</button>&nbsp;";
			}
			//echo "<button type='button' onclick='del(\"$id\")' class='btn btn-danger btn-sm mb-3'>Delete Question</button>";
			echo "<button type='button' class='btn btn-danger btn-sm mb-3' data-toggle='modal' data-target='#exampleModalCenter2_$id'>Delete</button>";
				echo '<div class="modal fade" id="';
				echo "exampleModalCenter2_" . $id;
				echo '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Are you sure?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button></div><div class="modal-body">Question will be permanantly deleted.';
				echo "<form action='delete_question.php' method='post'>
				<div class='form-group'>
					<input type='text' name='id' value='$id' style='display:none;'>
					<input type='text' name='quiz_id' value='$quiz_id' style='display:none;'>
				</div>";
				echo'</div><div class="modal-footer"><input type="Submit" class="btn btn-primary" value="Delete"></input>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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