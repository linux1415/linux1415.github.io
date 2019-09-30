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
		window.location.href = "edit_quiz_question.php?id=" + id;
	}
	
	function del(a) {
		var id = a;
		window.location.href = "delete.php?num=" + id;
	}
	</script>
	<title>Quiz Manager</title>
  </head>
  <body>
	<div class="container">
		<div class="jumbotron">
			<h1 class="display-4">Quiz Manager</h1>
			<hr class="my-4">
			<a class="btn btn-primary btn-lg mb-3"" href="create_quiz.php" style="width:10em;" role="button">New Quiz</a>&nbsp;&nbsp;<a class="btn btn-primary btn-lg mb-3" href="home.php" style="width:10em;" role="button">Home</a>
		</div>

		<input class="form-control" oninput="w3.filterHTML('#my_table', '.item', this.value)" placeholder="Filter" style="text-align:center;">
		<table class="table"  id="my_table" class="tablesorter">
			<thead class="thead-light">
				<tr>
					<th scope="col" style="width:30%;">Quiz</th>
					<th scope="col" style="width:15%;"></th>
					<th scope="col" style="width:15%;">Difficulty</th>
					<th scope="col" style="width:40%;"></th>
				</tr>
			</thead>
			<tbody>
		<?
		include 'database_connect.php';
		$user = $_SESSION['quizzer_id'];
		
		$query = "select * from quiz where user_id = '$user' order by quiz_name;";
		
		$array = mysqli_query($conn, $query);

		while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
			$quiz = $row['quiz_name'];
			$diff = $row['difficulty'];
			$id = $row['quiz_id'];
			echo "<tr class=\"item\">";
			echo "<td>$quiz</td><td>";
			
				echo "<button type='button' class='btn btn-success btn-sm mb-3' data-toggle='modal' data-target='#exampleModalCenter_$id'>Edit Title</button>";
				echo '<div class="modal fade" id="';
				echo "exampleModalCenter_" . $id;
				echo '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Change Quiz Title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">';
				echo "<form action='process_title_change.php' method='post'>
				<div class='form-group'>
					<input type='text' class='form-control' name='title' autocomplete='off' value='$quiz'>
					<input type='text' name='id' value='$id' style='display:none;'>
				</div>";
				echo'</div>
				<div class="modal-footer">
				<input type="Submit" class="btn btn-primary" value="Submit"></input>
				</form>
				</div>
				</div>
				</div>
				</div>';
				
			echo "</td><td>$diff</td><td style='text-align:center;'><button type='button' onclick='add(\"$id\")' class='btn btn-success btn-sm mb-3'>Add Questions</button>&nbsp;<button type='button' onclick='edit(\"$id\")' class='btn btn-primary btn-sm mb-3'>Edit Questions</button>&nbsp;";
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
				</button></div><div class="modal-body">Quiz will be permanantly deleted.';
				echo "<form action='delete_quiz.php' method='post'>
				<div class='form-group'>
					<input type='text' name='id' value='$id' style='display:none;'>
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