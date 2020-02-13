<?php
include 'verify.php';
include 'database_connect.php';
$user = $_SESSION['member_id'];

if(isset($_GET['id'])){ 
	$resource_category = $_GET['id'];
}
else {
	echo "<script>window.location.href = 'home.php';</script>";
	die();
}

$query = "SELECT resource from resource_categories where id = '$resource_category';";
$array = mysqli_query($conn, $query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
$category_name = $row['resource'];

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
	var category = <? echo $resource_category; ?>;
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
		if (chosen_year == 'default' && chosen_month != 'default') {
			return;
		}
		window.location.href = "resources.php?year=" + chosen_year + "&month=" + chosen_month  + "&id=" + category;
	}
	
	function select(a) {
		var id = a;
		window.open("serve_file.php?id=" + id);
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
	.label {
		font-size: 16pt;
	}
	</style>
	<title>Resources</title>
  </head>
  <body>
	<div class="container">
	<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
	  <a class="navbar-brand" href="home.php">Member Resources</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse order-1 dual-collapse2" id="navbarNavAltMarkup">
		<div class="navbar-nav">
		  <a class="nav-item nav-link" href="home.php">Home</a>
		  <a class="nav-item nav-link" href="edit_resources.php">Manage</a>
		</div>
		<div class="navbar-collapse collapse dual-collapse2 order-2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
	  </div>
	  </div>
	</nav><br>
	<div class="alert alert-dark label" role="alert">
	Resource Category:&nbsp;&nbsp;<?echo $category_name;?>
	</div>
		<div class="row no-gutters">
		<div class="col mb-3">
		<select class="form-control" id="month" onchange="build_url()">
		<option value="default"></option>
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
		<option value="default"></option>

		<? 
		include 'database_connect.php';
		$query = "SELECT YEAR(creation_date) as year FROM resources group by year;";


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
					<th scope="col">Title</th>
					<th scope="col">Author</th>
					<th scope="col">Date</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
		<?
		//$query = "select * from entries where 1=1";
		$query = "select title, (select alias from users where id = '$user') as author, creation_date, path, id from resources where id in (SELECT resource_id from resource_permissions where user_id = '$user') and category = '$resource_category'";
		
		$current_year = date('Y');

		if(isset($_GET['month'])){ 
			$month = $_GET['month'];
			if ($month != 'default') {
				$query = $query . " and MONTH(creation_date) = '$month'";
				echo "<script>";
				echo "document.getElementById(\"month\").value=\"" . $month . "\";";
				echo "</script>";
			}
		}

		if(isset($_GET['year'])){ 
			$year = $_GET['year'];
			if ($year != 'default') {
				$query = $query . " and YEAR(creation_date) = '$year'";
				echo "<script>";
				echo "document.getElementById(\"year\").value=" . $year . ";";
				echo "</script>";
			}
		}
		
		$query = $query . " order by title;";
		//echo $query;
		//die();
		
		$array = mysqli_query($conn, $query);
		$count = 0;
		while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
			$count ++;
			$id = $row['id'];
			$title = $row['title'];
			$path = $row['path'];
			$author = $row['author'];
			$date = $row['creation_date'];
			echo "<tr class=\"item\">";
			echo "<td>$title</td><td>$author</td><td>$date</td>";
			echo "<td><button type='button' class='btn bg-dark' onclick='select(\"$id\")' style='color:white;'>Select</button></td>";
			echo "</tr>";
		}
			
		
		?>

		</tbody>
	</table><br><br>
	<div class="alert alert-dark" role="alert">
	Resources Available:&nbsp;&nbsp;<?echo $count;?>
	</div>
	<br></div>
	
  </body>
</html>