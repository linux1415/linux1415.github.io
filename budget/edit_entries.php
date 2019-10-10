<?php
include 'verify.php';
include 'database_connect.php';
$user = $_SESSION['budget_id'];
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
		<script>
	
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
		window.location.href = "edit_entries.php?year=" + chosen_year + "&month=" + chosen_month;
	}
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
	<title>Edit Entries</title>
  </head>
  <body>
	<div class="container">
	<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
	  <a class="navbar-brand" href="home.php">My Budget</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse order-1 dual-collapse2" id="navbarNavAltMarkup">
		<div class="navbar-nav">
		  <a class="nav-item nav-link" href="home.php">Home</a>
		  <a class="nav-item nav-link" href="reports.php">Reports</a>
		  <a class="nav-item nav-link" href="edit_budget_categories.php">Edit Budget</a>
		  <a class="nav-item nav-link active" href="edit_entries.php">Edit Entries</a>
		</div>
	  </div>
	  <div class="navbar-collapse collapse dual-collapse2 order-2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
      </div>
	</nav><br>
		<div class="row no-gutters">
		<div class="col mb-3">
		<select class="form-control" id="month" onchange="build_url()">
		<option value="default">All</option>
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
		<option value="default">All</option>

		<? 
		include 'database_connect.php';
		$query = "SELECT YEAR(entry_date) as year FROM entries where user_id = '$user' group by year;";


		//running previously created query and creating table of statistics
		$array = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
			echo '<option value=\'' . $row['year'] . '\'>' . $row['year'] . '</option>';
		}
		?>

		</select>
		</div>
		</div>
		<table class="table"  id="my_table" class="tablesorter">
			<thead class="thead-light">
				<tr>
					<th scope="col">Date</th>
					<th scope="col">Entry</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
		<?
		$query = "select * from entries where user_id = '$user'";
		
		$current_year = date('Y');

		if(isset($_GET['month'])){ 
			$month = $_GET['month'];
			if ($month != 'default') {
				if(isset($_GET['year'])){ 
					$query = $query . " and MONTH(entry_date) = '$month'";
				}
				else {
					$query = $query . " and MONTH(entry_date) = '$month' and YEAR(entry_date) = '$current_year'";
				}
				echo "<script>";
				echo "document.getElementById(\"month\").value=\"" . $month . "\";";
				echo "</script>";
			}
		}

		if(isset($_GET['year'])){ 
			$year = $_GET['year'];
			if ($year != 'default') {
				$query = $query . " and YEAR(entry_date) = '$year'";
				echo "<script>";
				echo "document.getElementById(\"year\").value=" . $year . ";";
				echo "</script>";
			}
		}
		
		if(!isset($_GET['year']) && !isset($_GET['month'])){ 
			$month = date('m');
			$year = date('Y');
			$query = $query . " and MONTH(entry_date) = '$month' and YEAR(entry_date) = '$year'";
			echo "<script>";
			echo "document.getElementById(\"month\").value=\"" . $month . "\";";
			echo "document.getElementById(\"year\").value=" . $year . ";";
			echo "</script>";
		}
		
		$query = $query . " order by entry_date;";

		$array = mysqli_query($conn, $query);
		
		while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
			$date = $row['entry_date'];
			$entry = $row['entry_desc'];
			$amount = $row['amount'];
			$id = $row['entry_id'];
			$cat_id = $row['category_id'];
			$query2 = "select category_name from categories where category_id = '$cat_id' and user_id = '$user'";
			$array2 = mysqli_query($conn, $query2);
			$row2 = mysqli_fetch_array($array2, MYSQLI_ASSOC);
			$cat_name = $row2['category_name'];
			echo "<tr class=\"item\">";
			echo "<td>$date</td><td>$entry</td><td>";
				echo "<button type='button' class='btn bg-dark' data-toggle='modal' data-target='#exampleModalCenter_$id' style='color:white;'>Select</button>";
				echo '<div class="modal fade" id="';
				echo "exampleModalCenter_" . $id;
				echo '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">';
				echo "Category: " . $cat_name;
				echo '</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">';
				echo "<form action='process_edit_entries.php' method='post'>
				<div class='form-group'>
					<div class='input-group mb-3'>
						<div class='input-group-prepend'>
						<span class='input-group-text' id='inputGroup-sizing-default' style='width:7em;'>Entry</span>
						</div>
						<input type='text' class='form-control' name='entry' autocomplete='off' value='$entry' required>
					</div>
					<div class='input-group mb-3'>
						<div class='input-group-prepend'>
						<span class='input-group-text' id='inputGroup-sizing-default' style='width:7em;'>Amount</span>
						</div>
						<input type='text' class='form-control' name='amount' autocomplete='off' value='$amount' required>
					</div>";
					echo "<div class='input-group mb-3'>
						<div class='input-group-prepend'>
						<span class='input-group-text' id='inputGroup-sizing-default' style='width:7em;'>Date</span>
						</div><input type='date' name='date' ";
						echo " value='$date' ";
					echo " class='form-control' required></div>";
					echo "<input type='text' name='id' value='$id' style='display:none;'>
				</div>";
				echo'</div>
				<div class="modal-footer">
				<input type="Submit" class="btn bg-dark" value="Edit" style="color:white;"></input>
				</form>';
				echo "<form action='delete_entry.php' method='post'>
					<input type='text' name='id' value='$id' style='display:none;'>";
				echo'<input type="Submit" class="btn btn-danger" value="Delete"></input></form>';
				echo '</div>
				</div>
				</div>
				</div>';
			echo "</td></tr>";
		}
			
		
		?>

		</tbody>
	</table>
	<br></div>
	
  </body>
</html>