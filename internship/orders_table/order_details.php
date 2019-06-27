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
	height: 1000px;
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

#table, #table2, #table3 {
	height: 150px;
	margin-bottom: 30px;
}

#bottom {
	width: 700px;
	text-align: center;
	margin-left: 250px;
}

</style>
</head>
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script src="../javascript/jquery-3.3.1.min.js"></script>

<script>
function back() {
  window.history.back();
}
</script>
<main>
<body>
<div id="centered">
<?
if (isset($_GET['num'])) {
	$invoice = $_GET['num'];
}
else {
	echo "<script>window.location.href = 'orders_table.php';</script>";
}

echo "<h2>Details: Order " . $invoice . "</h2>";

echo '<div class=scrollable id="table"><table id="mytable"><tr><th>Item</th><th>Item Price</th><th>SKU</th><th>Quantity</th><th>Total</th></tr>';

$query = "SELECT item, sku, item_price, count(sku) as qty, sum(item_price) as total, sum(chargeback) as chargeback
from sales where invoice_num='$invoice' group by item, sku, item_price;";
$array = mysqli_query($conn, $query);
$total = 0;
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){ 
	$item = $row['item'];
	$sku = $row['sku'];
	$price = $row['item_price'];
	$qty = $row['qty'];
	$item_total = $row['total'];
	$chargeback = $row['chargeback'];
	echo "<tr>";
	echo "<td>$item</td><td class='desc'>$$price</td><td>$sku</td><td>$qty</td><td>$$item_total</td>";
	echo "</tr>";
	$total += $item_total;
	}
	
$query = "SELECT description, sku, cost, count(sku) as qty, sum(cost) as total 
from repair_sales where invoice_num='$invoice' group by description, sku, cost;";
$array = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){ 
	$item = $row['description'];
	$sku = $row['sku'];
	$price = $row['cost'];
	$qty = $row['qty'];
	$item_total = $row['total'];
	echo "<tr>";
	echo "<td>$item</td><td>$$price</td><td>$sku</td><td>$qty</td><td>$$item_total</td>";
	echo "</tr>";
	$total += $item_total;
	}
echo "</table></div>";
	
$query = "SELECT description, sku, device_id, color, details
from repair_sales where invoice_num='$invoice';";
$array = mysqli_query($conn, $query);

$counter = 0;
while ($row2 = mysqli_fetch_array($array, MYSQLI_ASSOC)){ 
	if ($counter == 0) {
		echo "<h3>Repair Details:</h3>";
		echo '<div class=scrollable id="table2"><table><tr><th>Repair</th><th>SKU</th><th>Device ID</th><th>Color</th><th>Description</th></tr>';
	}
	$item = $row2['description'];
	$sku = $row2['sku'];
	$id = $row2['device_id'];
	$color = $row2['color'];
	$details = $row2['details'];
	echo "<tr>";
	echo "<td>$item</td><td>$sku</td><td>$id</td><td>$color</td><td>$details</td>";
	echo "</tr>";
	$counter += 1;
	}
if ($counter > 0) {
	echo "</table></div>";
}


$query = "SELECT *
from sales where invoice_num='$invoice' and chargeback > 0;";
$array = mysqli_query($conn, $query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);

$query = "SELECT *
from repair_sales where invoice_num='$invoice' and chargeback > 0;";
$array = mysqli_query($conn, $query);
$row2 = mysqli_fetch_array($array, MYSQLI_ASSOC);

if (count($row) > 0 || count($row2) > 0) {
echo "<h3>Returns:</h3>";
echo '<div class=scrollable id="table3"><table id="mytable3"><tr><th>Item</th><th>Item Price</th><th>SKU</th></tr>';

$query = "SELECT item, sku, item_price
from sales where invoice_num='$invoice' and chargeback > 0;";
$array = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){ 
	$item = $row['item'];
	$sku = $row['sku'];
	$price = $row['item_price'];
	$qty = $row['qty'];
	$item_total = $row['total'];
	$chargeback = $row['chargeback'];
	echo "<tr>";
	echo "<td>$item</td><td>$$price</td><td>$sku</td>";
	echo "</tr>";
	}
	
$query = "SELECT description, sku, cost
from repair_sales where invoice_num='$invoice' and chargeback > 0;";
$array = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){ 
	$item = $row['description'];
	$sku = $row['sku'];
	$price = $row['cost'];
	$qty = $row['qty'];
	$item_total = $row['total'];
	echo "<tr>";
	echo "<td>$item</td><td>$$price</td><td>$sku</td>";
	echo "</tr>";
	}
echo "</table></div>";
}


$tax = round($total * .09, 2);
$total2 = round($total + ($total * .09), 2);

$query = "SELECT total, balance, amount_payed, refunds
from invoices where invoice_num='$invoice';";
$array = mysqli_query($conn, $query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);

$payed = $row['amount_payed'];
$balance = $row['balance'];
$refunds = $row['refunds'];
//$total = $row['total'];

echo "<label><b>Subtotal:</b>&nbsp;$$total</label><br>";
echo "<label><b>Total:</b>&nbsp;$$total2</label><br>";
echo "<label><b>Amount Payed:</b>&nbsp;$$payed</label><br>";
if ($refunds > 0) {
	echo "<label><b>Refunds:</b>&nbsp;$$refunds</label><br>";
}
echo "<br><label style='font-size:14pt;'><b>Balance:</b>&nbsp;$$balance</label><br><br>";

?>
<button style="font-size:22pt;height:40px;width:250px;" type="button" onclick="back()">Back</button>
<form action="../admin_home.php">
    <input type="submit" value="Home" style="font-size:22pt;height:40px;width:250px;margin-top:10px;"/>
</form>
</div>
</body>
</main>
</html>