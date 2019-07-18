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
	<style>
	span, label {
		width: 8em;
	}
	</style>
  </head>
  <script>
  function get_info() {
	var company = document.getElementById("company").value;
	var title = document.getElementById("title").value;
	var notes = document.getElementById("notes").value;
	var date = document.getElementById("date").value;
	var select = document.getElementById("screen");
	var screen = select.options[select.selectedIndex].value;
	var select = document.getElementById("interview");
	var interview = select.options[select.selectedIndex].value;
	var select = document.getElementById("status");
	var status = select.options[select.selectedIndex].value;
	window.location.href = "process_new.php?company=" + company + "&title=" + title + "&screen=" + screen + "&interview=" + interview + "&status=" + status + "&notes=" + notes + "&date=" + date;
  }
  </script>
  <body>
	<div class="container">
		<form action="process_new.php" method="post" name="input">
		<div class="jumbotron">
			<h1 class="display-4">New Entry</h1>
			<hr class="my-4">
			<a class="btn btn-primary btn-lg" href="home.php" style="width:7em;" role="button">Home</a>&nbsp;&nbsp;<a class="btn btn-primary btn-lg" href="applications.php" style="width:7em;" role="button">Applications</a>&nbsp;&nbsp;<a class="btn btn-primary btn-lg" href="logout.php" style="width:7em;" role="button">Logout</a>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text" style="width:8em;">Company</span>
			</div>
			<input type="text" name="company" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text">Job Title</span>
			</div>
			<input type="text" name="title" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<label class="input-group-text" for="screen">Phone Screen</label>
			</div>
			<select class="custom-select" name="screen">
				<option value="Yes">Yes</option>
				<option value="No" selected>No</option>
			</select>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<label class="input-group-text" for="inputGroupSelect01">Interview</label>
			</div>
			<select class="custom-select" name="interview">
				<option value="Yes">Yes</option>
				<option value="No" selected>No</option>
			</select>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<label class="input-group-text" for="inputGroupSelect01">Status</label>
			</div>
			<select class="custom-select" name="status">
				<option value="No Contact" selected>No contact</option>
				<option value="In Progress">In Progress</option>
				<option value="Rejected">Rejected</option>
			</select>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text">Notes</span>
			</div>
			<textarea name="notes" class="form-control" aria-label="With textarea"></textarea>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text">Date</span>
			</div>
		    <input type="date" name="date" 
			<?             
			$date = date('Y-m-d');
			echo " value='$date' ";
			?>
			class="form-control" placeholder="Current date.." required>
		</div>
		
		<input type='Submit' class="btn btn-primary btn-lg" value='Submit'></input>
		</form>
	</div>
	<br><br>
  </body>
</html>