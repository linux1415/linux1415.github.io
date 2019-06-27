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
	margin-top: 200px;
}

#user {
	width: 500px;
	margin-left: 100px;
	margin-top: 200px;
}

a {
	color: white; 
}
	
</style>
</head>
<main>
<body>
<div id="centered">
<form action="compose.php">
    <input type="submit" value="Compose" style="font-size:22pt;height:40px;width:330px;"/>
</form><br>
<form action="decrypt.php">
    <input type="submit" value="Inbox" style="font-size:22pt;height:40px;width:330px;"/>
</form><br>
<form action="logout.php">
    <input type="submit" value="Logout" style="font-size:22pt;height:40px;width:330px;"/>
</form>
</div>
<?php
$name = $_SESSION['name'];
echo "<div id='user'><h2 style='text-align:center;color:white;';>" . $name . "</h2></div>";
?>
</body>
</main>
</html>