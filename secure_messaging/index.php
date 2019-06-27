<?php
include 'initial_authenticate.php';
?>
<!DOCTYPE html>
<html lang="en">
	
<head> 
<title>Login</title>
<meta charset="utf-8">
<style type="text/css" media="screen">
html {
	background-image: url("code.jpg");
	background-repeat: no-repeat;
	background-attachment: fixed;
	background-position: center;
	background-size: cover;
	background-color: grey;
}
	
body {
	font-family: sans-serif;
	background-color: black;
	width: 450px;
	height: 400px;
	border: 1px solid black;
	box-shadow: 5px 5px 0 0;
	margin-top: 100px;
	margin-left: auto;
	margin-right: auto;
	opacity: 0.8;
	}

.labels {
	width:150px;
	margin-left:75px;
	text-align: center;
	color: white;
	}
	
main {
	margin-left: 75px;
	}

input {
	font-family: sans-serif;
	font-weight: bold;
	text-align: center;	
	}

input[type=submit] {
	border-radius: 3px;
	border: 1px solid black;
	background-color: white;
	}
	
</style>
</head>
<main>
<body>
<br><br>
<form action="login.php" method="post" name="input">
<div class="labels">
<h1>LOGIN</h1>
<label>Username:</label>
</div>
<input name="user_id" id="user" type="text" autocomplete="off" style="font-size:16pt;height:25px;width:300px;">
<div class="labels">
<label>Password:</label>
</div>
<input id="pass" name="pass" type="password" autocomplete="off" style="font-size:16pt;height:25px;width:300px;"><br><br>
<br>
<input style="font-size:16pt;height:30px;width:150px;margin-left:75px;font-weight:bold;" type="submit" value='GO'></button></span>
</form>	

</body>
</main>
</html>