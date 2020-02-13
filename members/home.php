<?php
include 'verify.php';
include 'database_connect.php';
$user = $_SESSION['member_id'];
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
	
	function select(a) {
		var id = a;
		window.location.href = "resources.php?id=" + id;
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
	@media (min-width: 600px) {
		.hidden-ss {
			display: none !important;
		}
	}
	@media (max-width: 599px) {
		.margin {
			margin-top: .5em;
		}
	}

	</style>
	<title>Home</title>
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
		  <a class="nav-item nav-link active" href="home.php">Home</a>
		  <a class="nav-item nav-link" href="edit_resources.php">Manage</a>
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
	$query = "select resource as category, id from resource_categories where id in (select category_id from category_permissions where user_id = '$user') order by category;";

	$array = mysqli_query($conn, $query);

	while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
		$id = $row['id'];
		$resource_category = $row['category'];		
		echo '<div class="card text-center">';
		echo '<div class="card-header"><b>';
		echo $resource_category;
		echo '</b></div>';
		  echo '<div class="card-body">';
				echo "<button type='button' class='btn bg-dark' onclick='select(\"$id\")' style='color:white;width:9em;font-size:14pt;'>Select</button>&nbsp;<br class='hidden-ss'>";
				echo "<button type='button' class='btn bg-dark margin' data-toggle='modal' data-target='#exampleModalCenter2_$id' style='color:white;width:9em;font-size:14pt;'>Quick Look</button>";
				echo '<div class="modal fade" id="';
				echo "exampleModalCenter2_" . $id;
				echo '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
				<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">';
				echo $resource_category;
				echo '</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">';
				echo '<table class="table"  id="my_table" class="tablesorter">
							<thead class="thead-light">
								<tr>
									<th scope="col">Title</th>
									<th scope="col">Author</th>
									<th scope="col">Date</th>
								</tr>
							</thead>
							<tbody>';
					$query3 = "select (select alias from users where id = '$user') as author, title, id, creation_date FROM resources where id in (SELECT resource_id from resource_permissions where user_id = '$user') and category = '$id' order by title;";
					$array3 = mysqli_query($conn, $query3);

					while ($row3 = mysqli_fetch_array($array3, MYSQLI_ASSOC)){
						$title = $row3['title'];
						$author = $row3['author'];
						$date = $row3['creation_date'];
						echo "<tr class=\"item\">";
						echo "<td>$title</td><td>$author</td><td>$date</td></tr>";
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