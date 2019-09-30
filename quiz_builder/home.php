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
    <script>
	function take(a) {
		var id = a;
		window.location.href = "quiz.php?id=" + id;
	}
	function stats(a) {
		var id = a;
		window.location.href = "statistics.php?id=" + id;
	}
	</script>
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
	<title>My Quizzes</title>
  </head>
  <body>
	<div class="container">
		<div class="jumbotron">
			<h1 class="display-4">My Quizzes</h1>
			<hr class="my-4">
			<a class="btn btn-primary btn-lg mb-3"" href="quiz_manager.php" style="width:10em;" role="button">Quiz Manager</a>&nbsp;&nbsp;<a class="btn btn-primary btn-lg mb-3" href="logout.php" style="width:10em;" role="button">Logout</a>
		</div>
			<?
		include 'database_connect.php';
		$user = $_SESSION['quizzer_id'];
		$query = "select count(quiz_id) as amount from quiz where user_id = '$user';";
		$array = mysqli_query($conn, $query);

		$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
		$amount = $row['amount'];
		?>
		<input class="form-control" oninput="w3.filterHTML('#my_table', '.item', this.value)" placeholder="Filter" style="text-align:center;">
		<table class="table"  id="my_table" class="tablesorter">
			<thead class="thead-light">
				<tr>
					<th scope="col" style="width:40%;">Quiz</th>
					<th scope="col" style="width:20%;">Difficulty</th>
					<th scope="col" style="width:40%;"></th>
				</tr>
			</thead>
			<tbody>
		<?
		
		$query = "select * from quiz where user_id = '$user' order by quiz_name;";
		
		$array = mysqli_query($conn, $query);

		while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
			$quiz = $row['quiz_name'];
			$diff = $row['difficulty'];
			$id = $row['quiz_id'];
			echo "<tr class=\"item\">";
			echo "<td>$quiz</td><td>$diff</td><td style='text-align:center;'><button type='button' onclick='take(\"$id\")' class='btn btn-success btn-md mb-3'>Take</button>&nbsp;&nbsp;&nbsp;<button type='button' onclick='stats(\"$id\")' class='btn btn-primary btn-md mb-3'>Statistics</button>";
			echo "</td></tr>";
		}
		?>
			</tbody>
		</table>
	</div>

  </body>
</html>