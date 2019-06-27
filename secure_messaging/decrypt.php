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
	height: 675px;
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
	margin-left: 50px;
	margin-top: 20px;
	height: 450px;
	overflow-y:auto;
}

#user {
	width: 500px;
	margin-left: 100px;
	margin-top: 25px;
}

th, td {
	color: white;
	text-align: center;	
	font-size: 14pt;
	border: 1px solid white;

}

table {
	table-layout: fixed;
	width: 600px;
	border-spacing: 0;
	border: 1px solid white;

}

#button {
	width: 700px;
	text-align: center;
}

input[type=radio] {
    border: 0px;
    width: 100%;
    height: 1.5em;
}

.row {
	width: 100%;
	overflow-y: hidden;
	text-overflow:scroll;
	white-space: nowrap; 
}

th {
  position: sticky;
  top: 0;
  z-index: 2;
  background-color: white;
  color: black;
}

select {
	color: white;
	background-color: black;
	font-family: sans-serif;
	font-size: 14pt;
}

label {
	color: white;
	font-family: sans-serif;
	font-size: 14pt;
}

#action {
	width: 700px;
	text-align: center;
}

#button1 {
	border-radius: 3px;
	border: 1px solid black;
	background-color: white;
	font-weight: bold;
}
	
</style>
</head>
<script>
function choice() {
	var id = document.getElementById("options");
	var chosen = id.options[id.selectedIndex].value;
	if (chosen == "delete") {
		main_button.innerHTML = '<button id="button1" style="font-size:18pt;height:30px;width:200px;margin-bottom:5px;" type="button" onclick="del()">Delete</button>';
	}

	if (chosen == "read") {
		//main_button.innerHTML = "<input style='font-size:18pt;height:30px;width:200px;margin-bottom:5px;' type='Submit' value='Submit'/>"
		window.location.href = "decrypt.php";

	}

}

function del() {
	var items = document.getElementsByName('id');
	var value = '';
	for(var i = 0; i < items.length; i++){
		if(items[i].checked){
			value = items[i].value;
		}
	}
	if (value != '') {
		window.location.href = "delete_message.php?v=" + value;
	}
}
</script>
<main>
<body><br>
<div id='action'>
<label>Action:&nbsp;</label>
<select name="option" id="options" onchange="choice()" style="width:100px;">
<option value="read">View</option>
<option value="delete">Delete</option>
</select>
</div>
<div id="centered">
<form action="handle_decrypt.php" method="post" name="input">
<?php

ini_set('display_errors', 'Off');

include 'db_connect.php';

//checks to see if user exists; also verifies user input preventing sql injection
$query = "Select messages.subject as subject, messages.sender_name as sender, messages.date as date, users.user_name as user from messages, users where messages.reciever=users.user_id and messages.reciever='$user' ORDER BY messages.date desc;";
$a = mysqli_query($conn, $query);
echo "<table border='1'><thead id='head'><tr><th style='width:10%;'></th><th style='width:34%;'>Subject</th><th style='width:33%;'>From</th><th style='width:33%;'>Date</th></tr></thead><tbody id='body'>";
while ($row = mysqli_fetch_array($a, MYSQLI_ASSOC)){
	$mess = $row['subject'];
	$from = $row['sender'];
	$date = $row['date'];
	echo "<tr><td><input style='width:50px;' type='radio' name='id' value='$date'></td>";
	echo "<td><div class='row'>$mess</div></td><td><div class='row'>$from</div></td><td>$date</td></tr>";
	
}
echo "</tr></tbody></table>";

//die(include 'encrypt.html');
?>
</div><br>
<div id='button'>
<span id='main_button'><input style='font-size:18pt;height:30px;width:200px;margin-bottom:5px;' type='Submit' value='Submit'/></span>
</form>
<form action="home.php">
    <input type="submit" value="Home" style="font-size:18pt;height:30px;width:200px;margin-bottom:5px;"/>
</form>
<form action="decrypt.php">
    <input type="submit" value="Refresh" style="font-size:18pt;height:30px;width:200px;"/>
</form>
</div>
<?php
$name = $_SESSION['name'];

if (isset($_SESSION['d'])) {
	echo '<script>';
	//echo 'window.location.href = "decrypt.php";';
	echo "main_button.innerHTML = \"<button id='button1' style='font-size:18pt;height:30px;width:200px;margin-bottom:5px;' type='button' onclick='del()'>Delete</button>\";";
	echo "document.getElementById('options').selectedIndex = 1;";
	echo '</script>';
	}
	
unset($_SESSION['d']);
?>
</body>
</main>
</html>

