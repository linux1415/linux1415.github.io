<?php
include 'verify.php';
include 'database_connect.php';
$user = $_SESSION['member_id'];

if(isset($_GET['id'])){ 
	$resource_category = $_GET['id'];
}
else {
	echo "<script>window.location.href = 'edit_resources.php';</script>";
	die();
}

//checking access for category
$query = "SELECT * from edit_categories_permissions where category_id = '$resource_category' and user_id = '$user';";
$array = mysqli_query($conn, $query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
if (count($row) < 1) {
	echo "<script>window.location.href = 'edit_resources.php';</script>";
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
	
	function getFile(filePath) {
        return filePath.substr(filePath.lastIndexOf('\\') + 1).split('.')[0];
    }
	
	function get_file_name() {
		var file_name = document.getElementById("upload_file").value;
		file_name = getFile(file_name);
		document.getElementById("chosen_file").innerHTML = file_name;
		var file_title = document.getElementById("file_title").value;
		if (file_title.length < 1) {
			document.getElementById("file_title").value = file_name;
		}
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
	<title>Add Resource</title>
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
	<form action="add_resource_process.php" method="post" enctype="multipart/form-data">
		<input type="text" name="category" value="<?echo$resource_category;?>" style="display:none;">
		  <div class="form-group">
			<label class="label" for="exampleInputEmail1">Upload</label>
			<div class="custom-file">
				<input type="file" class="custom-file-input" id="upload_file" name="upload_file" onchange="get_file_name();" aria-describedby="inputGroupFileAddon04">
				<label class="custom-file-label" for="inputGroupFile04"><div id="chosen_file">File</div></label>
			</div>
		  </div>
		  <div class="form-group">
			<label class="label" for="exampleInputPassword1">Title</label>
			<input type="text" name="file_title" id="file_title" class="form-control" placeholder="Title" required>
		  </div>
		  <input type='Submit' class="btn bg-dark btn-lg" style='color:white;' value='Submit'></input>
		</form>
	<br></div>
	
  </body>
</html>