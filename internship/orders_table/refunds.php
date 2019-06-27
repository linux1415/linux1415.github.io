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
function cash() {
  var amount = prompt("Please enter the cash amount.");
  if (amount == null) {
	return;
	}
  var type = 'cash';
  window.location.href = "refund_add.php?type=" + type + "&amount=" + amount;
}

function card() {
  var amount = prompt("Please enter the card amount.");
  if (amount == null) {
	return;
	}
  var type = 'card';
  window.location.href = "refund_add.php?type=" + type + "&amount=" + amount;
}

function del(type) {
	window.location.href = "refund_del.php?type=" + type;
}

function card_all() {
  var type = 'card';
  window.location.href = "refund_add.php?type=" + type + "&amount=all";
}

function cash_all() {
  var type = 'cash';
  window.location.href = "refund_add.php?type=" + type + "&amount=all";
}

function add_refund() {
  var amount = prompt("Please enter amount to refund customer.");
  if (amount == null) {
	return;
	}
  window.location.href = "refunds.php?refund_amount=" + amount;
}

function reset_refund() {
  var reset = 'reset';
  window.location.href = "refunds.php?refund_amount=" + reset;
}

function back(a) {
	window.location.href = 'orders_table.php?invoice=' + a;
}

function submit(a) {
	window.location.href = "refunds_process.php?total=" + a;
}
</script>
<main>
<body>
<div id="centered">
<?

if (isset($_REQUEST['num'])) {
	$invoice = $_REQUEST['num'];
	$_SESSION['refund_invoice'] = $invoice;
	unset($_SESSION['refund_array']);
}
else {
	$invoice = $_SESSION['refund_invoice'];
}

if (!isset($_SESSION['refund_amount'])) {
	$_SESSION['refund_amount'] = 0;
}

if (isset($_REQUEST['refund_amount'])) {
	$refund_total = $_REQUEST['refund_amount'];
	if ($refund_total == 'reset') {
		$_SESSION['refund_amount'] = 0;
	}
	else {
		$_SESSION['refund_amount'] += $refund_total;
	}
}

echo "<h2>Refunds: Order " . $invoice . "</h2>";


$query = "SELECT total, balance, amount_payed, refunds
from invoices where invoice_num='$invoice';";
$array = mysqli_query($conn, $query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);

$a_payed = $row['amount_payed'];
//$balance = $row['balance'];
//$refunds = $row['refunds'];

echo "<label>Amount Payed by Customer:&nbsp;$</label><b>$a_payed</b><br><br>";


?>
<button style="font-size:14pt;height:50px;width:150px;" type="button" onclick="add_refund()">Add Refund</button>&nbsp;&nbsp;
<button style="font-size:14pt;height:50px;width:150px;" type="button" onclick="reset_refund()">Reset</button><br><br>

<h3>Payout:</h3>
<button style="font-size:14pt;height:50px;width:100px;" type="button" onclick="cash_all()">Cash: Balance</button>&nbsp;&nbsp;
<button style="font-size:14pt;height:50px;width:100px;" type="button" onclick="cash()">Cash: Specific</button>&nbsp;&nbsp;
<button style="font-size:14pt;height:50px;width:100px;" type="button" onclick="card_all()">Card: Balance</button>&nbsp;&nbsp;
<button style="font-size:14pt;height:50px;width:100px;" type="button" onclick="card()">Card: Specific</button><br><br>
<div class=scrollable id='table2' style='height:100px;'>
<?

$payed = 0;
if (isset($_SESSION['refund_array'])) {
	echo "<table id='pay_table' style='width:400px;margin-left:400px;'><tr><th>Amount</th><th>Type</th><th></th></tr>";
	foreach ($_SESSION['refund_array'] as $key => $value) {
		$key = strtoupper($key);
		echo "<tr><td>$value</td><td>$key</td><td><button type='button' onclick='del(\"$key\")'>Delete</button></td></tr>";	
		$payed += $value;
	}
	echo "</table>";
}
echo '</div>';
//$balance = $balance + $payed;
//echo "<label><b>Balance:</b>&nbsp;$<span id='balance'><b>$balance</b></span></label><br><br>";

$total = 0;
if (isset($_SESSION['return_array'])) {
	$returns = $_SESSION['return_array'];
	foreach ($returns as $key => $value) {
		$item = $value[0];
		$price = $value[1];
		$total += $price;
	}	
	$total = round($total + ($total * .09), 2);
}
echo "<label>Refunds From Returns:&nbsp;$</label><b>$total</b><br>";
$other = $_SESSION['refund_amount'];
echo "<label>Other Refunds:&nbsp;$</label><b>$other</b><br><br>";

$total += $_SESSION['refund_amount'];
$total -= $payed;
echo "<label>Owed Customer:&nbsp;$</label><b>$total</b><br><br>";


?>

</div>
<br><br><br>
<button style="font-size:22pt;height:40px;margin-left:475px;width:250px;margin-top:10px;" type="button" <? echo "onclick='submit(\"$total\")'"; ?>>Submit</button>
<button style="font-size:22pt;height:40px;margin-left:475px;width:250px;margin-top:10px;" type="button" <? echo "onclick='back(\"$invoice\")'"; ?>>Cancel</button>
<form action="../admin_home.php">
    <input type="submit" value="Home" style="font-size:22pt;height:40px;width:250px;margin-left:475px;margin-top:10px;"/>
</form>
</body>
</main>
</html>