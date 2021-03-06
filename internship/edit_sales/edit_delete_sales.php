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
	margin-left: 100px;
}

#logout {
	margin-left: 335px;
}

#user {
	margin-left: 335px;
}

img {
	top: 50%;
	margin-left: 335px;
}

#selection {
	width: 800px;
	font-size: 16pt;
	text-align: center;
}

select {
	font-size: 18pt;
	width: 150px;
	text-indent: 0px;
}

#button {
	margin-left: 375px;
}

#dashboard {
	width: 800px;
	text-align: center;
}

input {
	font-size: 16pt;
}
</style>
</head>
<script>
function choice() {
	var html;
	var id = document.getElementById("options");
	var chosen = id.options[id.selectedIndex].value;
	if (chosen == "sku") {
		html = "<label>Enter SKU:&nbsp;</label><input name='sku' type=text'>"; 
	}
	if (chosen == "invoice") {
		html = "<label>Enter Invoice #:&nbsp;</label><input name='invoice' type=text'>"; 
	}
	if (chosen == "date") {
		location.reload();
		return;
	}
	document.getElementById('content').innerHTML = html;
}

</script>
<main>
<body>
<img src="logo.png" alt="logo" style="width:330px;height:255px;">
<div id="centered">
<!--<h1 style="width:250px;text-align:center;">Dashboard</h1>-->
<form action="edit_delete_handle_sales.php">
<div id="selection">
<label><b>Store:</b>&nbsp;</label>
<select style="width:200px;" id="store" name="store">
<option value="all">All</option>
<? 
$query = "SELECT store_id, store_name
			FROM stores;";
	

//running previously created query and creating table of statistics
$array = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
	echo '<option value=\'' . $row['store_id'] . '\'>' . $row['store_name'] . '</option>';
}
?>
  <!--<option value="1">Lowes</option>
  <option value="2">Quinn</option>-->
</select><br>
<label><b>Filter By:</b>&nbsp;</label>
<select name="option" onchange="choice()" id="options" style="width:200px;margin-top:10px;">
<option value="date">Date</option>
<option value="sku">SKU</option>
<option value="invoice">Invoice Number</option>
</select>&nbsp;
<label><b>Employee:</b>&nbsp;</label>
<select name="emp" style="width:200px;margin-bottom:20px;">
<option value="all">All</option>
<?php

ini_set('display_errors', 'Off');

//query to be executed
$query = "SELECT CONCAT(employee_info.first_name, ' ', employee_info.last_name) as name, employee_info.id_num as id
			FROM employee_info;";
	

//running previously created query and creating table of statistics
$array = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
	echo '<option value=\'' . $row['id'] . '\'>' . $row['name'] . '</option>';
}
?>
</select><br>
<span id='content'>
Default Date: Current Week<br>
Other:<br>
<select name="month">
  <option value="default"></option>
  <option value="January">January</option>
  <option value="February">February</option>
  <option value="March">March</option>
  <option value="April">April</option>
  <option value="May">May</option>
  <option value="June">June</option>
  <option value="July">July</option>
  <option value="August">August</option>
  <option value="September">September</option>
  <option value="October">October</option>
  <option value="November">November</option>
  <option value="December">December</option>
</select>
<select name="day">
  <option value="default"></option>
  <option value="01">1</option>
  <option value="02">2</option>
  <option value="03">3</option>
  <option value="04">4</option>
  <option value="05">5</option>
  <option value="06">6</option>
  <option value="07">7</option>
  <option value="08">8</option>
  <option value="09">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
  <option value="25">25</option>
  <option value="26">26</option>
  <option value="27">27</option>
  <option value="28">28</option>
  <option value="29">29</option>
  <option value="30">30</option>
  <option value="31">31</option>
</select>
<select name="year">
<option value="default"></option>
<? 

$query = "SELECT year FROM sales group by year;";
	

//running previously created query and creating table of statistics
$array = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
	echo '<option value=\'' . $row['year'] . '\'>' . $row['year'] . '</option>';
}
?>
  <!--<option value="default"></option>
  <option value="2019">2019</option>
  <option value="2020">2020</option>
  <option value="2021">2021</option>
  <option value="2022">2022</option>
  <option value="2023">2023</option>
  <option value="2024">2024</option>
  <option value="2025">2025</option>
  <option value="2026">2026</option>
  <option value="2027">2027</option>
  <option value="2028">2028</option>
  <option value="2029">2029</option>
  <option value="2030">2030</option>-->
</select></span><br><br><br>
</div></div>
<div id="button">
    <input type="submit" name="submit" value="GO" style="font-size:22pt;height:40px;width:250px;text-align:center;"/>
</form><br><br>
<form action="../admin_home.php">
    <input type="submit" value="Home" style="font-size:22pt;height:40px;width:250px;text-align:center;"/>
</form>
</div>

<br><br>
<?php
$name = $_SESSION['name'];
echo "<div id='user'><h2 style='width:330px;text-align:center;';>" . $name . "</h2></div>";
?>
</body>
</main>
</html>