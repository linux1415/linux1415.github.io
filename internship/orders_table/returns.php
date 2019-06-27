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
	width: 1200px;
	height: 800px;
	border: 1px solid black;
	box-shadow: 5px 5px 0 0;
	margin-left: auto;
	margin-right: auto;
}

#centered {
	margin-top: 20px;
	width: 1200px;
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
	width: 1100px;
	table-layout: fixed;
	border-collapse: collapse;
	margin-left: 50px;
}

#overflow {
	height: 75px;
	overflow: auto;
}

table{
  border: 1px solid black;
  font-size: 12pt;
}

td, th {
	border: 0;
}

div.scrollable {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: auto;
}

#table, #table2 {
	height: 150px;
	margin-bottom: 30px;
}

#bottom {
	width: 700px;
	text-align: center;
	margin-left: 250px;
}

button {
	width: 75px;
	cursor: pointer;
	}

</style>
</head>
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script src="../javascript/jquery-3.3.1.min.js"></script>

<script>
function submit(a) {
	window.location.href = "refunds.php?num=" + a;
}

function returns(a, b, c, d) {
	window.location.href = "return_add.php?item=" + a + "&id=" + b + "&type=" + c + "&price=" + d;
}

function del(a) {
	window.location.href = "return_del.php?id=" + a;
}

function back(a) {
	window.location.href = 'orders_table.php?invoice=' + a;
}
</script>
<main>
<body>
<div id="centered">
<?
if (isset($_GET['num'])) {
	$invoice = $_GET['num'];
	$_SESSION['invoice_r'] = $invoice;
	unset($_SESSION['return_array']);
}
else if (isset($_SESSION['invoice_r'])) {
	$invoice = $_SESSION['invoice_r'];
}
else {
	echo "<script>window.location.href = 'orders_table.php';</script>";
}

echo "<h2>Order: " . $invoice . "</h2>";

echo '<div class=scrollable id="table"><table id="mytable"><tr><th>Item</th><th>Item Price</th><th>SKU</th><th>Return</th></tr>';

$query = "SELECT item, sku, item_price , sale_id as id
from sales where invoice_num='$invoice' and not chargeback > 0;";
$array = mysqli_query($conn, $query);
$total = 0;
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){ 
	$item = $row['item'];
	$sku = $row['sku'];
	$price = $row['item_price'];
	$id = $row['id'];
	$item_total = $row['total'];
	echo "<tr>";
	echo "<td>$item</td><td>$$price</td><td>$sku</td><td><button type='button' onclick='returns(\"$item\", \"$id\", \"item\", \"$price\")'>Add</button></td>";
	echo "</tr>";
	$total += $item_total;
	}
	
$query = "SELECT description, sku, cost, repair_id as id
from repair_sales where invoice_num='$invoice' and not chargeback > 0;";
$array = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){ 
	$item = $row['description'];
	$sku = $row['sku'];
	$price = $row['cost'];
	$id = $row['id'];
	$item_total = $row['total'];
	echo "<tr>";
	echo "<td>$item</td><td>$$price</td><td>$sku</td><td><button type='button' onclick='returns(\"$item\", \"$id\", \"repair\", \"$price\")'>Add</button></td>";
	echo "</tr>";
	$total += $item_total;
	}
echo "</table></div>";

?>

<div class=scrollable id='table2' style='height:300px;'>
<?
if (isset($_SESSION['return_array'])) {
	echo "<h2>Returns:</h2>";
	echo "<table id='return_table' style='width:400px;margin-left:400px;'><tr><th>Item</th><th></th></tr>";
	foreach ($_SESSION['return_array'] as $key => $value) {
		$item = $value[0];
		echo "<tr><td>$item</td><td><button type='button' onclick='del(\"$key\")'>Delete</button></td></tr>";	
	}
	echo "</table>";
}
echo '</div>';
?>

</div>
<br><br>

<button style="font-size:22pt;height:40px;margin-left:475px;width:250px;" type="button" <? echo "onclick='submit(\"$invoice\")'"; ?>>Submit</button>
<button style="font-size:22pt;height:40px;margin-left:475px;width:250px;margin-top:10px;" type="button" <? echo "onclick='back(\"$invoice\")'"; ?>>Cancel</button>
<form action="../admin_home.php">
    <input type="submit" value="Home" style="font-size:22pt;height:40px;margin-left:475px;width:250px;margin-top:10px;"/>
</form>
</body>
</main>
</html>