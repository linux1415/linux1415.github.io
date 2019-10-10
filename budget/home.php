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
	<title>Home</title>
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
		  <a class="nav-item nav-link active" href="home.php">Home</a>
		  <a class="nav-item nav-link" href="reports.php">Reports</a>
		  <a class="nav-item nav-link" href="edit_budget_categories.php">Edit Budget</a>
		  <a class="nav-item nav-link" href="edit_entries.php">Edit Entries</a>
		</div>
	  </div>
	  <div class="navbar-collapse collapse dual-collapse2 order-2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
      </div>
	</nav>
	<br>
	<?
	$month = date('m');

	$query = "SELECT categories.category_id as id, categories.category_name as name, categories.budget as budget from categories where user_id = '$user' order by name;";

	$array = mysqli_query($conn, $query);

	while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
		$name = $row['name'];
		$budget = $row['budget'];
		$id = $row['id'];
		$query2 = "select sum(amount) as total from entries where MONTH(entry_date) = '$month' and category_id = '$id' and user_id = '$user'";
		$array2 = mysqli_query($conn, $query2);
		$row2 = mysqli_fetch_array($array2, MYSQLI_ASSOC);
		$total = $row2['total'];
		if ($total == NULL) {
			$percent = 0;
			$total = 0;
		}
		else {
			$percent = ($total / $budget) * 100;
			$percent = round($percent);
			if ($percent > 100) {
				$percent = '100';
			}
		}		
		echo '<div class="card text-center">';
		echo '<div class="card-header"><b>';
		echo $name . ": $" . $budget;
		echo '</b></div>';
		  echo '<div class="card-body">';
			echo '<h5 class="card-title">'; 
			echo "Left to Spend: $" . ($budget - $total); 
			echo '</h5>
			<p class="card-text">
				<div class="progress" style="height: 2.5em;">
				  <div class="progress-bar bg-dark" role="progressbar" style="width: ';
				  echo $percent;
				  echo '%;font-size:150%;" aria-valuemin="0" aria-valuemax="100">$';
				  echo $total;
				  echo '</div>
				</div>
			</p>';
				echo "<button type='button' class='btn bg-dark' data-toggle='modal' data-target='#exampleModalCenter_$id' style='color:white;width:7em;'>New Entry</button>&nbsp;";
				echo '<div class="modal fade" id="';
				echo "exampleModalCenter_" . $id;
				echo '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">';
				echo $name;
				echo '</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">';
				echo "<form action='add_entry.php' method='post'>
				<div class='form-group'>
					<div class='input-group mb-3'>
						<div class='input-group-prepend'>
						<span class='input-group-text' id='inputGroup-sizing-default' style='width:7em;'>Description</span>
						</div>
						<input type='text' class='form-control' name='desc' autocomplete='off' required>
					</div>
					<div class='input-group mb-3'>
						<div class='input-group-prepend'>
						<span class='input-group-text' id='inputGroup-sizing-default' style='width:7em;'>Amount</span>
						</div>
						<input type='text' class='form-control' name='amount' autocomplete='off' required>
					</div>
					<div class='input-group mb-3'>
						<div class='input-group-prepend'>
						<span class='input-group-text' id='inputGroup-sizing-default' style='width:7em;'>Date</span>
						</div><input type='date' name='date' ";
						$date = date('Y-m-d');
						echo " value='$date' ";
					echo " class='form-control' required></div>
					<input type='text' name='id' value='$id' style='display:none;'>
				</div>";
				echo'</div>
				<div class="modal-footer">
				<input type="Submit" class="btn bg-dark" value="Submit" style="color:white;width:7em;"></input>
				</form>
				</div>
				</div>
				</div>
				</div>';
			//echo "<button type='button' class='btn bg-dark' data-toggle='modal' data-target='#exampleModalCenter_$id' style='color:white;width:7em;'>New Entry</button>&nbsp;";
			//echo '<a href="#" class="btn bg-dark" style="color:white;width:7em;">Details</a>';
				echo "<button type='button' class='btn bg-dark' data-toggle='modal' data-target='#exampleModalCenter2_$id' style='color:white;width:7em;'>Details</button>";
				echo '<div class="modal fade" id="';
				echo "exampleModalCenter2_" . $id;
				echo '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
				<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">';
				echo $name . ": Details";
				echo '</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">';
				echo '<table class="table"  id="my_table" class="tablesorter">
							<thead class="thead-light">
								<tr>
									<th scope="col">Date</th>
									<th scope="col">Description</th>
									<th scope="col">Amount</th>
								</tr>
							</thead>
							<tbody>';
					$query3 = "SELECT entry_date, entry_desc, amount from entries where category_id = '$id' and MONTH(entry_date) = '$month' and user_id = '$user' order by entry_date;";

					$array3 = mysqli_query($conn, $query3);

					while ($row3 = mysqli_fetch_array($array3, MYSQLI_ASSOC)){
						$date = $row3['entry_date'];
						$amount = $row3['amount'];
						$desc = $row3['entry_desc'];
						echo "<tr class=\"item\">";
						echo "<td>$date</td><td>$desc</td><td>$amount</td></tr>";
					}
					echo '</tbody></table>';
				echo'</div>
				</div>
				</div>
				</div>';
		  echo '</div>
		</div><br>';
	}
	?>
	
	<br></div>
	
  </body>
</html>