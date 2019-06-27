<?php
session_start();

$type = $_GET["type"];
$cash = $_GET["amount"];


if ($cash == 'all') {
	$total = 0;
	foreach ($_SESSION['sales_array'] as $key => $value) {
		$price = $value[2];
		$qty = $value[4];
		$total += ($price * $qty);
		}
	$total2 = round($total + ($total * .09), 2);
	
	if (isset($_SESSION['payment_array'])) {
		$payed = 0;
		foreach ($_SESSION['payment_array'] as $key => $value) {
			$payed += $value;
			}
		$balance = $total2 - $payed;
		if ($balance <= 0) {
			echo '<script>alert("Balance has already been payed.")</script>';
			echo '<script>window.location.href="pay.php";</script>';
			die();
		}
		$cash = $balance;
	}
	else {
	$cash = $total2;
	}
}
	
if (!isset($_SESSION['payment_array']))
{
    $_SESSION['payment_array'] = array();
}

if ($type == 'cash') {
	if (isset($_SESSION['payment_array']['cash'])) {
		$_SESSION['payment_array']['cash'] += $cash;
	}
	else {
		$_SESSION['payment_array']['cash'] = $cash;
	}
}

if ($type == 'card') {
	if (isset($_SESSION['payment_array']['card'])) {
		$_SESSION['payment_array']['card'] += $cash;
	}
	else {
		$_SESSION['payment_array']['card'] = $cash;
	}
}

echo '<script>window.location.href="pay.php";</script>';


?>