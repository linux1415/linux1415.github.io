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
	a {
		color: black;
	}
	</style>
	<title>Create Account</title>
  </head>
  <body>
	<div class="container">
		<div class="jumbotron">
			<h1 class="display-4">Create Account</h1>
		</div>
		<form action="process_create_account.php" method="post">
		  <div class="form-group">
			<label for="exampleInputEmail1">Username</label>
			<input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Username" required>
		  </div>
		  <div class="form-group">
			<label for="exampleInputPassword1">Password</label>
			<input type="password" name="pass" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
		  </div>
		  <div class="form-group">
			<label for="exampleInputPassword1">Password</label>
			<input type="password" name="pass2" class="form-control" id="exampleInputPassword1" placeholder="Enter Password Again" required>
		  </div>
		  <input type='Submit' class="btn btn-primary btn-lg" value='Submit'></input>
		</form>
		<hr>
		<a href="https://www.jf925.com/quiz/login.php">Login</a>
	</div>

  </body>
</html>