<?php
session_start();
include 'verify.php';
?>
<!DOCTYPE html>
<html lang="en">
	
<head> 
<title>Database Connect</title>
<meta charset="utf-8">
<style type="text/css" media="screen">
	
body {
	font-family: sans-serif;
	width: 450px;
	height: 400px;
	border: 1px solid black;
	box-shadow: 5px 5px 0 0;
	margin-left: auto;
	margin-right: auto;
	}

#title {
	width: 300px;
	text-align: center;
}

#label_id {
	width:150px;
	margin-left:75px;
	text-align: center;
	}
	
main {
	margin-left: 75px;
	margin-top: 1em;
	}
	
select, label {
	font-size:16pt;
	height:25px;
	}
	
</style>
</head>
<main>
<body>

<form action="login.php" method="post">
<div id="title">
<img src="logo.png" alt="logo" style="width:205px;height:162px;">
</div>
<div id="label_id">
<label>PIN:</label>
</div>
<input name="user_id" id="user" type="text" autocomplete="off" style="font-size:16pt;height:25px;width:300px;"><br><br>
<p><input type="submit" name="submit" value="Authenticate" style="font-size:16pt;height:30px;width:150px;margin-left:75px;"></p>
</form>	

</body>
</main>
</html>