<?php
session_start();
include '../database_connect.php';

$type = $_GET["type"];
$cash = $_GET["amount"];

$invoice = $_SESSION['refund_invoice'];

$query = "SELECT total, balance, amount_payed, refunds
from invoices where invoice_num='$invoice';";
$array = mysqli_query($conn, $query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);

//$balance = $row['balance'];

$total = 0; $balance = 0;
if (isset($_SESSION['return_array'])) {
	$returns = $_SESSION['return_array'];
	foreach ($returns as $key => $value) {
		$item = $value[0];
		$price = $value[1];
		$total += $price;
	}
$balance = round($total + ($total * .09), 2);	
}

$balance += $_SESSION['refund_amount'];

if ($balance == 0) {
	echo '<script>alert("There is no balance to pay out.")</script>';
	echo '<script>window.location.href="refunds.php";</script>';
	die();
	}
	
//$balance = substr($balance, 1);

if ($cash == 'all') {
	if (isset($_SESSION['refund_array'])) {
		$payed = 0;
		foreach ($_SESSION['refund_array'] as $key => $value) {
			$payed += $value;
			}
		$balance = $balance - $payed;
		$cash = $balance;
	}
	else {
		$cash = $balance;
	}
}
	
if (!isset($_SESSION['refund_array']))
{
    $_SESSION['refund_array'] = array();
}

if ($type == 'cash') {
	if (isset($_SESSION['refund_array']['cash'])) {
		$_SESSION['refund_array']['cash'] += $cash;
	}
	else {
		$_SESSION['refund_array']['cash'] = $cash;
	}
}

if ($type == 'card') {
	if (isset($_SESSION['refund_array']['card'])) {
		$_SESSION['refund_array']['card'] += $cash;
	}
	else {
		$_SESSION['refund_array']['card'] = $cash;
	}
}

echo '<script>window.location.href="refunds.php";</script>';


?>