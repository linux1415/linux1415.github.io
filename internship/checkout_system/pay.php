<?php
session_start();
include '../verify.php';

if (!isset($_SESSION['user']))
{
    die(include 'index.php');
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

#table2 {
	height: 150px;
	margin-bottom: 30px;
}

#table {
	height: 100px;
	margin-bottom: 30px;
}

</style>
</head>
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script src="../javascript/jquery-3.3.1.min.js"></script>

<script>
var money = [];

function generate() {
	var id = document.getElementById('c_id').value;
	window.location.href = "../reports/invoice.php?id=" + id;
} 

function cash() {
  var amount = prompt("Please enter the cash amount.");
  if (amount == null) {
	return;
	}
  var type = 'cash';
  window.location.href = "payment_add.php?type=" + type + "&amount=" + amount;
}

function card() {
  var amount = prompt("Please enter the card amount.");
  if (amount == null) {
	return;
	}
  var type = 'card';
  window.location.href = "payment_add.php?type=" + type + "&amount=" + amount;
}

function del(type) {
	window.location.href = "payment_del.php?type=" + type;
}

function card_all() {
  var type = 'card';
  window.location.href = "payment_add.php?type=" + type + "&amount=all";
}

function cash_all() {
  var type = 'cash';
  window.location.href = "payment_add.php?type=" + type + "&amount=all";
}

function generate() {
	var id = document.getElementById('c_id').value;
	window.location.href = "../reports/quote.php?id=" + id;
} 
</script>
<main>
<body>
<div id="centered">
<form action="finish.php" method="post" onsubmit="return validate()">
<h2>Summary</h2>
<?

if (isset($_REQUEST['repairs'])) {
	$repairs = $_REQUEST['repairs'];
	$_SESSION['repairs'] = $repairs;
	//$first = $_REQUEST['first'];
	//$last = $_REQUEST['last'];
}

if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	if ($id == 'guest') {
		$id = '1';
	}
	$_SESSION['customer_id'] = $id;
}

if (!isset($_SESSION['customer_id'])) {
	echo '<script>window.location.href="choose_customer.php";</script>';
	die();
}

$cust_id = $_SESSION['customer_id'];
echo "<input value='$cust_id' id='c_id' name = 'id' style='display:none'>";



//echo '<label>Customer:&nbsp;' . $first . ' ' . $last . '</label><br><br>';
$sales = $_SESSION['sales_array'];
echo '<div class=scrollable id="table"><table id="mytable"><tr><th>Item</th><th>Item Price</th><th>SKU</th><th>Category</th><th>Quantity</th></tr>';
$index = 0; $total = 0;
foreach ($_SESSION['sales_array'] as $key => $value) {
	$item = $value[1];
	$price = $value[2];
	$sku = $value[0];
	$category = $value[3];
	$qty = $value[4];
	$type = $value[5];
	if ($type == 'repair') {
		$repair = 'yes';
	}
	echo "<tr>";
	echo "<td>$item</td><td>$price</td><td>$sku</td><td>$category</td><td>$qty</td>";
	echo "</tr>";
	$total += ($price * $qty);
	}
	$total2 = round($total + ($total * .09), 2);
	echo "</table></div>";
	echo "<label><b>Subtotal:</b>&nbsp;$$total</label><br>";
	echo "<label><b>Total:</b>&nbsp;$$total2</label><br><br>";
	$_SESSION['total_sales'] = $total2;
?>
<h2>Pay:</h2>
<button style="font-size:14pt;height:50px;width:100px;" type="button" onclick="cash_all()">Cash: Balance</button>&nbsp;&nbsp;
<button style="font-size:14pt;height:50px;width:100px;" type="button" onclick="cash()">Cash: Specific</button>&nbsp;&nbsp;
<button style="font-size:14pt;height:50px;width:100px;" type="button" onclick="card_all()">Card: Balance</button>&nbsp;&nbsp;
<button style="font-size:14pt;height:50px;width:100px;" type="button" onclick="card()">Card: Specific</button><br><br>
<div class=scrollable id='table2' style='height:100px;'>
<?
$payed = 0;
if (isset($_SESSION['payment_array'])) {
	echo "<table id='pay_table' style='width:400px;margin-left:400px;'><tr><th>Amount</th><th>Type</th><th></th></tr>";
	foreach ($_SESSION['payment_array'] as $key => $value) {
		$key = strtoupper($key);
		echo "<tr><td>$value</td><td>$key</td><td><button type='button' onclick='del(\"$key\")'>Delete</button></td></tr>";	
		$payed += $value;
	}
	echo "</table>";
}
echo '</div>';
$balance = $total2 - $payed;
echo "<label><b>Balance:</b>&nbsp;$<span id='balance'><b>$balance</b></span></label><br><br>";
?>

</div>
<br><br><br>
<input type="submit" value="Submit" style="font-size:22pt;height:40px;margin-left:475px;width:250px;"/>
</form>
<form action="../admin_home.php">
    <input type="submit" value="Home" style="font-size:22pt;height:40px;width:250px;margin-left:475px;margin-top:10px;"/>
</form>
</body>
</main>
</html>