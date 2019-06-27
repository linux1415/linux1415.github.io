<?php
session_start();
include '../verify.php';

if (!isset($_SESSION['user']))
{
    die(include 'index.html');
}
include '../database_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Database Connect</title>
<meta charset="utf-8">
<style type="text/css" media="screen">
	
body {
	font-family: sans-serif;
	margin-left: 2em;
	width: 1000px;
	height: 700px;
	border: 1px solid black;
	box-shadow: 5px 5px 0 0;
	margin-left: auto;
	margin-right: auto;
}

#centered {
	margin-top: 20px;
	width: 1000px;
	text-align: center;
	height: 550px;
}

input[type=text] {
	font-size:12pt;
	height:20px;
	width:150px;
	text-align: center;
}

label {
	font-size: 12pt;
}

select {
	font-size: 14pt;
	height: 30px;
}

table {
	width: 500px;
	table-layout: fixed;
	border-collapse: collapse;
}

#overflow {
	height: 75px;
	overflow: auto;
}

table, th, td {
  border: 1px solid black;
  font-size: 12pt;
}

div.scrollable {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: auto;
}

#table {
	height: 300px;
	margin-bottom: 30px;
}

</style>
</head>
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script src="../javascript/jquery-3.3.1.min.js"></script>
<script>
function check() {
	var name = document.getElementById('name').value;
	name = name.toLowerCase();
	var phone = document.getElementById('phone').value;
	if (name != '' || phone != '') {
		window.location.href = "choose_customer.php?name=" + name + "&phone=" + phone;
	}
}

function choose(id, fname, lname) {
	window.location.href = "sale_finalize.php?id=" + id + "&f_name=" + fname + "&l_name=" + lname;
}

function add() {
	var f_name = document.getElementById('f_name').value;
	var l_name = document.getElementById('l_name').value;
	var n_phone = document.getElementById('n_phone').value.trim();
	var city = document.getElementById('city').value;
	var zip = document.getElementById('zip').value;
	if (n_phone.length == 10 && l_name != '') {
		window.location.href = "new_customer.php?f_name=" + f_name + "&l_name=" + l_name + "&n_phone=" + n_phone + "&city=" + city + "&zip=" + zip;
	}
	else {
		alert("Please type in a valid phone number and a last name.");
	}
}

function new_cust() {
	var name = document.getElementById('name').value;
	name = name.toLowerCase();
	var phone = document.getElementById('phone').value;
	window.location.href = "choose_customer.php?name=" + name + "&phone=" + phone;
}

function del() {
	window.location.href = "choose_customer.php";
}

function guest() {
	window.location.href = "sale_finalize.php?id=guest";
}
</script>
<main>
<body>
<div id="centered">
<h2>Choose Customer:</h2>
<label>Phone:</label>&nbsp;&nbsp;
<input type="text" id="phone" style="margin-bottom:10px;margin-top:10px;width:150px;" autocomplete="off" onkeypress="return go(event)">
<label>&nbsp;&nbsp;<b>OR</b>&nbsp;&nbsp; Last Name:</label>
<input type="text" id="name" style="width:150px;" autocomplete="off">&nbsp;&nbsp;
<button style="font-size:12pt;height:30px;width:75px;margin-bottom:10px;" type="button" onclick="check()">Go</button><br>
<button style="font-size:12pt;height:30px;width:75px;margin-bottom:10px;" type="button" onclick="new_cust()">New</button>
<button style="font-size:12pt;height:30px;width:75px;margin-bottom:10px;" type="button" onclick="guest()">Guest</button><br><br>
<?
if (isset($_SESSION['sales_array'])) {
	if (count($_SESSION['sales_array']) < 1) {
		echo "<script>window.location.href = 'new_sale_add.php';</script>";
	}
}
else {
	echo "<script>window.location.href = 'new_sale_add.php';</script>";
}

if (isset($_GET['phone']) || isset($_GET['name']))
{
	$phone = $_GET['phone'];
	$name = $_GET['name'];
	$query = "select id_num, first_name, last_name, phone, city, zip from customers
	where LOWER(last_name)='$name' or phone='$phone';";
	$check_query = "select * from customers
	where LOWER(last_name)='$name' or phone='$phone';";
	$array = mysqli_query($conn, $query);
	$array2 = mysqli_query($conn, $check_query);
	$check = mysqli_fetch_array($array2, MYSQLI_ASSOC);
	echo '<div class=scrollable id="table"><table id="mytable" style="width: 950px;margin-left:25px;"><tr><th>First Name</th><th>Last Name</th><th>Phone</th><th>City</th><th>Zip</th><th></th></tr>';
	if (count($check) > 0) {
		while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){ 
			$f_name = $row['first_name'];
			$l_name = $row['last_name'];
			$phone = $row['phone'];
			$city = $row['city'];
			$zip = $row['zip'];
			$id = $row['id_num'];
			echo "<tr>";
			echo "<td>$f_name</td><td>$l_name</td><td>$phone</td><td>$city</td><td>$zip</td><td><button type='button' onclick='choose(\"$id\", \"$f_name\", \"$l_name\")'>Choose</button></td>";
			echo "</tr>";
		}
	}
	else {
		$name = strtoupper(substr($name, 0, 1)) . '' . substr($name, 1);
		echo "<tr>";
		echo "<td><input id='f_name' placeholder='First Name' type='text'></td><td><input id='l_name' placeholder='Last Name' value='$name' type='text'></td><td><input id='n_phone' placeholder='Phone' value='$phone' type='text'></td><td><input id='city' placeholder='City' type='text'></td><td><input id='zip' placeholder='Zip' type='text'></td><td><button type='button' onclick='add()'>Add</button>&nbsp;<button type='button' onclick='del()'>Delete</button></td>";
		echo "</tr>";
	}
	echo "</table></div>";
}

?>
</div>
<form action="new_sale_add.php">
    <input type="submit" value="Back" style="font-size:22pt;height:40px;width:250px;margin-left:375px;margin-top:10px;"/>
</form>
<form action="../admin_home.php">
    <input type="submit" value="Home" style="font-size:22pt;height:40px;width:250px;margin-left:375px;margin-top:10px;"/>
</form>
</body>
</main>
</html>