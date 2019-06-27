<?php
session_start();
if (!isset($_SESSION['user']))
{
    die(include 'index.html');
}
?>
<!DOCTYPE html>

<html lang="en">
	
<head> 
<title>Commission Tracker</title>
<meta charset="utf-8">
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script src="../javscript/jquery-3.3.1.min.js"></script>
<script src="../javascript/jquery.tablesorter.min.js"></script>
<script>
$(function () {
	$('table').tablesorter({
		cssAsc: 'up',
		cssDesc: 'down',
		cssNone: ''
	});
});

</script>
<style type="text/css" media="screen">
html {
	background-color: white; 
}
	
body {
	font-family: sans-serif;
	margin-left: 2em;
	background-color: #white;
	width: 1000px;
	height: 700px;
	border: 1px solid black;
	box-shadow: 5px 5px 0 0;
	margin-left: auto;
	margin-right: auto;
	}
	
main {
	margin-top: 25px;
	overflow: auto;
	}
	
label {
	font-size:16pt;
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
	height: 450px;
}

#totals {
	margin-top: 20px;
}

table {
	width: 950px;
	margin-left: 25px;
	table-layout: fixed;
}

#title {
	width: 600px;	
	text-align: center;
	margin-left: 200px;
}

#dashboard {
	width: 800px;
	text-align: center;
	margin-left: 100px;
}

input {
	width: 117px;
	height: 18px;
	font-size: 12pt;
}

.center {
	text-align: center;
}

.h1 {
	text-align: center;
	margin-top: 50px;
	margin-bottom: 50px;
}

#search {
	float: left;
	margin-top: 10px;
	margin-left: 25px;
	font-family: sans-serif;
	font-size: 14pt;
	width: 175px;
}

th {
	cursor: pointer;
	background-color: gainsboro;
}

thead th {
    background-repeat: no-repeat;
    background-position: right center;
}
thead th.up {
    padding-right: 20px;
    background-image: url(data:image/gif;base64,R0lGODlhFQAEAIAAACMtMP///yH5BAEAAAEALAAAAAAVAAQAAAINjI8Bya2wnINUMopZAQA7);
}
thead th.down {
    padding-right: 20px;
    background-image: url(data:image/gif;base64,R0lGODlhFQAEAIAAACMtMP///yH5BAEAAAEALAAAAAAVAAQAAAINjB+gC+jP2ptn0WskLQA7);
}
</style>
</head>
<main>
<div id='search'>
<input oninput="w3.filterHTML('#my_table', '.item', this.value)" placeholder="Search..">
</div>
<body>
<div id="body">
<?php

ini_set('display_errors', 'Off');

include '../database_connect.php';

//get variables from form
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$store = $_REQUEST['store'];


//grabbing session variable and the current date
//$user = $_SESSION['user'];
$date = date('Y-m-d');
$current_year = date('Y');

//incomplete query to be executed
$partial_q = "SELECT sku, item, count(sale_id) as amount, sum(item_price) as total
			FROM sales
			WHERE '1'='1'";


if ($store != 'all') {
	$partial_q = $partial_q . " and store='$store'";
	}
		
$to_print = "";		
//adding onto query based on user input
if(isset($month)) {
if ($month == "default" and $year == "default") {
	$query = $partial_q . " and year='$current_year'";
	$to_print = "$current_year";
}
elseif ($month != "default" and $year == "default") {
	$query = $partial_q . " and month='$month' and year='$current_year'";
	$to_print = "$month" . ", " . "$current_year";
}
elseif ($month != "default" and $year != "default") {
	$query = $partial_q . " and month='$month' and year='$year'";
	$to_print = "$month" . ", " . "$year";
}
elseif ($month == "default" and $year != "default") {
	$query = $partial_q . " and year='$year'";
	$to_print = "$year";
}
else {
	die("There is an error");
}
}

$query = $query . " group by sku, item order by amount desc;";

	

//running previously created query and creating table of statistics
$array = mysqli_query($conn, $query);
$check = mysqli_query($conn, $query);
$length = count(mysqli_fetch_array($check, MYSQLI_NUM));

if ($length > 0) {
echo '<div id="title"><h2>Item Performance: ' . $to_print . '</h2></div><br>';
echo '<div class=scrollable id="table"><table id="my_table" class="tablesorter"><tr>';
echo '<thead>';
echo '<th>SKU</th><th>Item</th><th>Number Sold</th><th>Total</th></thead></tr>';
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
	$item = $row['item'];
	$total = $row['total'];
	$amount = $row['amount'];
	$sku = $row['sku'];
	echo "<tr class=\"item\">";
	echo "<td>$sku</td><td>$item</td><td>$amount</td><td>$total</td></tr>";

}
echo '</table></div>';


}
else {
	echo "<h1 class='h1'>There are no items to display.</h1>";
}
?>
<br>

<div id="dashboard">
<form action="item_performance_filter.php">
    <input type="submit" value="Back" style="font-size:22pt;height:40px;width:250px;"/>
</form><br>
<form action="../admin_home.php">
    <input type="submit" value="Home" style="font-size:22pt;height:40px;width:250px;"/>
</form>

</div>
</body>
</div>
</main>

</html>