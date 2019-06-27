<?php
include 'authenticate.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Database Connect</title>
<meta charset="utf-8">
<style type="text/css" media="screen">
html {
	background-image: url("code.jpg");
	background-repeat: no-repeat;
	background-attachment: fixed;
	background-position: center;
	background-size: cover;
	background-color: black;
}
	
body {
	font-family: sans-serif;
	background-color: black;
	width: 700px;
	height: 650px;
	border: 1px solid black;
	box-shadow: 5px 5px 0 0;
	margin-top: 25px;
	margin-left: auto;
	margin-right: auto;
	opacity: 0.8;
	}

.content {
	width:500px;
	margin-left: 100px;
	text-align: center;
	color: white;
	text-align: center;
	}
	

input {
	font-family: sans-serif;
	font-weight: bold;
	text-align: center;
	}

#textbox {
	margin-left: 50px;
	}
	
button {
	border-radius: 3px;
	border: 1px solid black;
	background-color: white;
	}
	
input[type=submit] {
	border-radius: 3px;
	border: 1px solid black;
	background-color: white;
	}

#centered {
	width: 500px;
	text-align: center;
	margin-left: 100px;
}

#user {
	width: 500px;
	margin-left: 100px;
	margin-top: 200px;
}

#top {
	margin-top: 50px;
	width: 700px;
	text-align: center;
	margin-bottom: 50px;
}

label {
	color: white;
	font-size: 14pt;
}

#home_button {
	margin-top: 150px;
}

h1 {
	width: 700px;
	text-align: center;
	color: white;
}

select {
	width: 700px;
	text-align: center;
	font-size: 16pt;
}
</style>
</head>
<main>
<body>
<h1>Compose</h1>
<form action="encrypt.php" method="post" name="input">
<div id='top'>
<label>To:</label><br>
<select name="to_whom" style="width:250px;">
<option value="all"></option>
<?php

ini_set('display_errors', 'Off');

include 'db_connect.php';

//query to be executed
$query = "SELECT concat(first_name, ' ', last_name) as name, user_id as id
			FROM users;";
	

//running previously created query and creating table of statistics
$array = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
	echo '<option value=\'' . $row['id'] . '\'>' . $row['name'] . '</option>';
}
?>
</select><br><br>
<label>Subject:</label><br><input name="subject" id="subject" type="text" autocomplete="off" style="font-size:14pt;height:22px;width:350px;" maxlength="200" onkeypress="return event.keyCode != 13;">
<br><label>Key Alias:</label><br><input name="nickname" id="nickname" type="text" autocomplete="off" style="font-size:14pt;height:22px;width:350px;" onkeypress="return event.keyCode != 13;">
</div>
<div id="centered">
<input style='font-size:18pt;height:30px;width:200px;font-weight:bold;' type='Submit' value='Next'></input>
</form>
<div id='home_button'>
<form action="home.php">
    <input type="submit" value="Home" style="font-size:18pt;height:35px;width:250px;"/>
</form>
</div>
</div>
</body>
</main>
</html>