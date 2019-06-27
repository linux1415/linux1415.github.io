<?php
session_start();
include '../database_connect.php';

$invoice = $_SESSION['refund_invoice'];

if (isset($_GET['total'])) {
	$total = $_GET['total'];
	if ($total > 0) {
		echo "<script>";
		echo "alert('Error. Check Payouts.');";
		echo "</script>";
		echo "<script>window.location.href = 'refunds.php';</script>";
	}
}
else {
	echo "<script>window.location.href = 'orders_table.php?invoice=$invoice';</script>";
}


$total2 = 0;
if (isset($_SESSION['return_array'])) {

$returns = $_SESSION['return_array'];
foreach ($returns as $key => $value) {
	$item = $value[0];
	$price = $value[1];
	$type = $value[2];
	if ($type == 'item') {
		$update_query = "UPDATE sales SET chargeback = '$price' where sale_id='$key';";
		if (!$conn->query($update_query) === TRUE) {
			echo "<script>";
			echo "alert('Error');";
			echo "</script>";
		}
	}
	else {
		$update_query = "UPDATE repair_sales SET chargeback = '$price' where repair_id='$key';";
		if (!$conn->query($update_query) === TRUE) {
			echo "<script>";
			echo "alert('Error');";
			echo "</script>";
		}
	}	
}

}

//$total2 += $_SESSION['refund_amount'];
$payed = 0;
foreach ($_SESSION['refund_array'] as $key => $value) {
	$payed += $value;
}

if ($payed <= 0) {
	echo "<script>";
	echo "alert('Refund Amount Must Be Greater Than Zero.');";
	echo "</script>";
	echo "<script>window.location.href = 'refunds.php';</script>";
}
	
$update_query = "UPDATE invoices SET refunds = (refunds + '$payed') where invoice_num='$invoice';";
	if (!$conn->query($update_query) === TRUE) {
		echo "<script>";
		echo "alert('Error');";
		echo "</script>";
	}

echo "<script>window.location.href = 'orders_table.php?invoice=$invoice';</script>";
?>