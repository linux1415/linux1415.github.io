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
		window.location.href = "edit.php?num=" + id;
	}
	function del(a) {
		var id = a;
		window.location.href = "delete.php?num=" + id;
	}
	
	function month() {
		var select = document.getElementById("month");
		var month = select.options[select.selectedIndex].value;
		return month;
	}

	function year() {
		var select = document.getElementById("year");
		var year = select.options[select.selectedIndex].value;
		return year;
	}

	function build_url() {
		var chosen_month = month();
		var chosen_year = year();
		window.location.href = "applications.php?year=" + chosen_year + "&month=" + chosen_month;
	}
	</script>
	<title>Application Tracker</title>
  </head>
  <body>
	<div class="container">
		<div class="jumbotron">
			<h1 class="display-4">Job Applications</h1>
			<hr class="my-4">
			<a class="btn btn-primary btn-lg mb-3" href="home.php" style="width:7em;" role="button">Home</a>&nbsp;&nbsp;<a class="btn btn-primary btn-lg mb-3" href="new.php" style="width:7em;" role="button">New Entry</a>&nbsp;&nbsp;<a class="btn btn-primary btn-lg mb-3" href="logout.php" style="width:7em;" role="button">Logout</a>
		</div>
		<div class="row no-gutters">
		<div class="col mb-3">
		<select class="form-control" id="month" onchange="build_url()">
		<option value="default">Month</option>
		  <option value="1">January</option>
		  <option value="2">February</option>
		  <option value="3">March</option>
		  <option value="4">April</option>
		  <option value="5">May</option>
		  <option value="6">June</option>
		  <option value="7">July</option>
		  <option value="8">August</option>
		  <option value="9">September</option>
		  <option value="10">October</option>
		  <option value="11">November</option>
		  <option value="12">December</option>
		</select>
		</div>
		<div class="col mb-3">
		<select class="form-control" id="year" onchange="build_url()">
		<option value="default">Year</option>

		<? 
		include 'database_connect.php';
		$user = $_SESSION['id_app_tracker'];
		$query = "SELECT YEAR(date) as year FROM applications where user = '$user' group by year;";
			

		//running previously created query and creating table of statistics
		$array = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
			echo '<option value=\'' . $row['year'] . '\'>' . $row['year'] . '</option>';
		}
		?>

		</select>
		</div>
		</div>
		<input class="form-control" oninput="w3.filterHTML('#my_table', '.item', this.value)" placeholder="Filter" style="text-align:center;">
		<table class="table"  id="my_table" class="tablesorter">
			<thead class="thead-light">
				<tr>
					<th scope="col">Company</th>
					<th scope="col">Title</th>
					<th scope="col" style="width:7%;">Phone Screen</th>
					<th scope="col" style="width:7%;">Interview</th>
					<th scope="col" style="width:10%;">Status</th>
					<th scope="col" style="width:10%;">Date</th>
					<th scope="col" style="width:23%;"></th>
				</tr>
			</thead>
			<tbody>
		<?
		$query = "select * from applications where user = '$user'";
		
		$current_year = date('Y');

		if(isset($_GET['month'])){ 
			$month = $_GET['month'];
			if ($month != 'default') {
				if(isset($_GET['year'])){ 
					$query = $query . " and MONTH(date) = '$month'";
				}
				else {
					$query = $query . " and MONTH(date) = '$month' and YEAR(date) = '$current_year'";
				}
				echo "<script>";
				echo "document.getElementById(\"month\").value=\"" . $month . "\";";
				echo "</script>";
			}
		}

		if(isset($_GET['year'])){ 
			$year = $_GET['year'];
			if ($year != 'default') {
				$query = $query . " and YEAR(date) = '$year'";
				echo "<script>";
				echo "document.getElementById(\"year\").value=" . $year . ";";
				echo "</script>";
			}
		}
		
		$query = $query . " order by date desc;";

		$array = mysqli_query($conn, $query);

		while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
			$comp = $row['company'];
			$title = $row['title'];
			$screen = $row['phone_screen'];
			$interview = $row['interview'];
			$status = $row['status'];
			$date = $row['date'];
			$notes = $row['notes'];
			$id = $row['id'];
			echo "<tr class=\"item\">";
			echo "<td>$comp</td><td>$title</td><td>$screen</td><td>$interview</td><td>$status</td><td>$date</td><td style='text-align:center;'><button type='button' style='width:4em;' onclick='add(\"$id\")' class='btn btn-primary btn-sm mb-3'>Edit</button>&nbsp;<button type='button' onclick='del(\"$id\")' class='btn btn-danger btn-sm mb-3'>Delete</button>";
				echo "&nbsp;<button type='button' style = 'width:5.5em' class='btn btn-success btn-sm mb-3' data-toggle='modal' data-target='#exampleModalCenter_$id'>Notes";
				if (strlen($notes) > 1) {
					echo "&nbsp;<span class='badge badge-light'>&#10003;</span>";
				}
				else {
					$notes = "No notes.";
				}
				echo "</button>";
				echo '<div class="modal fade" id="';
				echo "exampleModalCenter_" . $id;
				echo '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Notes</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">';
				echo $notes;
				echo'</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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