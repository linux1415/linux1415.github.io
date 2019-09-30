<?php
if(isset($_GET['status'])){ 
	$status = $_GET['status'];
  }
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
    <link href="signin.css" rel="stylesheet">
	<title>Quizzer Login</title>
  </head>
   <body class="text-center">
    <form action="check_login.php" method="post" class="form-signin">
		<!--<img class="mb-4" src="./login.php_files/bootstrap-solid.svg" alt="" width="72" height="72">-->
		<h1 class="display-4">Login</h1><br>
		<label for="inputEmail" class="sr-only">Email address</label>
		<input type="text" id="inputEmail" 
		<?
		if ($status == 'demo1') {
			echo ' value="User1" ';
		}
		if ($status == 'demo2') {
			echo ' value="User2" ';
		}
		?>
		name="email" class="form-control" placeholder="Username" required="" autofocus="">
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" id="inputPassword" 
		<?
		if ($status == 'demo1') {
			echo ' value="password" ';
		}
		if ($status == 'demo2') {
			echo ' value="password" ';
		}
		?>
		name="password" class="form-control" placeholder="Password" required="">
		<div class="checkbox mb-3">
		<!--<label>
		<input type="checkbox" value="remember-me"> Remember me
		</label>-->
		<div style="height:100px;"></div>
		</div>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		<div style="margin-top:7em;height:5em;">
		<a class="btn btn-primary btn-sm" href="https://www.jf925.com/quiz/login.php?status=demo1" style="
		<?
		if($status == 'demo1'){ 
			echo 'display:none;';
		}
		?>
		" role="button">Demo 1</a>
		<a class="btn btn-primary btn-sm" href="https://www.jf925.com/quiz/login.php?status=demo2" style="
		<?
		if($status == 'demo2'){ 
			echo 'display:none;';
		}
		?>
		" role="button">Demo 2</a>
		</div>
		<hr>
		<a href="https://www.jf925.com/quiz/create_account.php">Create Account</a>

  </form>
</body>
</html>