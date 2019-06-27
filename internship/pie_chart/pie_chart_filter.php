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
<main>
<body>
<img src="logo.png" alt="logo" style="width:330px;height:255px;">
<div id="centered">
<!--<h1 style="width:250px;text-align:center;">Dashboard</h1>-->
<form action="pie_chart.php">
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
</select><br><br>
<label><b>From:</b>&nbsp;</label>
<select style="width:200px;" name="type">
<option value="all">All</option>
<option value="sales">Sales</option>
<option value="repairs">Repairs</option>
</select><br><br>
Default Date: Current Year<br>
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

</select><br><br><br>
</div></div>
<div id="button">
    <input type="submit" name="submit" value="GO" style="font-size:22pt;height:40px;width:250px;text-align:center;"/>
</form><br><br>
<form action="../admin_home.php">
    <input type="submit" value="Home" style="font-size:22pt;height:40px;width:250px;text-align:center;"/>
</form>
</div>
</body>
</main>
</html>