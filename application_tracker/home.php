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
    <title>Application Tracker</title>
  </head>
  <body>
	<div class="container">
		<div class="jumbotron">
			<h1 class="display-4">Home</h1>
			<hr class="my-4">
			<a class="btn btn-primary btn-lg" href="new.php" style="width:7em;" role="button">New Entry</a>&nbsp;&nbsp;<a class="btn btn-primary btn-lg" href="applications.php" style="width:7em;" role="button">Applications</a>&nbsp;&nbsp;<a class="btn btn-primary btn-lg" href="logout.php" style="width:7em;" role="button">Logout</a>
		</div>
			<?
		include 'database_connect.php';
		$user = $_SESSION['id_app_tracker'];
		$query = "select count(id) as amount, (select count(id) from applications where phone_screen = 'Yes' and user = '$user') as screens, (select count(id) from applications where interview = 'Yes' and user = '$user') as interviews, (select count(id) from applications where status = 'Rejected' and user = '$user') as rejected from applications where user = '$user';";
		$array = mysqli_query($conn, $query);

		$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
		$apps = $row['amount'];
		$screens = $row['screens'];
		$interviews = $row['interviews'];
		$rejected = $row['rejected'];
		?>
		<div class="card-deck justify-content-center">
		<div class="card bg-light mb-3 text-center" style="max-width: 18rem;">
			<div class="card-header">Jobs Applied To</div>
			<div class="card-body">
				<h5 class="card-title"><?echo $apps;?></h5>
			</div>
		</div>
		<div class="card bg-light mb-3 text-center" style="max-width: 18rem;">
			<div class="card-header">Phone Screenings</div>
			<div class="card-body">
				<h5 class="card-title"><?echo $screens;?></h5>
			</div>
		</div>
		<div class="card bg-light mb-3 text-center" style="max-width: 18rem;">
			<div class="card-header">Video/In Person Interviews</div>
			<div class="card-body">
				<h5 class="card-title"><?echo $interviews;?></h5>
			</div>
		</div>
		<div class="card bg-light mb-3 text-center" style="max-width: 18rem;">
			<div class="card-header">Verbal or Written Rejections</div>
			<div class="card-body">
				<h5 class="card-title"><?echo $rejected;?></h5>
			</div>
		</div>
		</div>
		<div class="card-deck justify-content-center">
		<div class="card bg-light mb-3 text-center" style="max-width: 18rem;">
			<div class="card-header">Percent Of Applications That Lead To A Phone Screen</div>
			<div class="card-body">
				<h5 class="card-title"><?echo round(($screens/$apps)*100, 1) . '%';?></h5>
			</div>
		</div>
		<div class="card bg-light mb-3 text-center" style="max-width: 18rem;">
			<div class="card-header">Percent Of Applications That Lead To An Interview</div>
			<div class="card-body">
				<h5 class="card-title"><?echo round(($interviews/$apps)*100, 1) . '%';?></h5>
			</div>
		</div>
		<div class="card bg-light mb-3 text-center" style="max-width: 18rem;">
			<div class="card-header">Percent Of Applications That Lead To A Rejection</div>
			<div class="card-body">
				<h5 class="card-title"><?echo round(($rejected/$apps)*100, 1) . '%';?></h5>
			</div>
		</div>
		</div>
	</div>

  </body>
</html>