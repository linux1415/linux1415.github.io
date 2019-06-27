<?php
session_start();
include '../database_connect.php';


$invoice = $_SESSION['invoice_r'];

if (!isset($_SESSION['return_array']))
{
	echo '<script>window.location.href="returns.php";</script>';
}

$returns = $_SESSION['return_array'];
$total = 0;
foreach ($returns as $key => $value) {
	$get_price = "select item_price from sales where sale_id='$key';";
	$array = mysqli_query($conn, $get_price);
	$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
	$price = $row['item_price'];
	
	$update_query = "UPDATE sales SET chargeback = '$price' where sale_id='$key';";
	if (!$conn->query($update_query) === TRUE) {
		echo "<script>";
		echo "alert('Error');";
		echo "</script>";
	}
	$total += $price;
}

$total2 = round($total + ($total * .09), 2);
	
$update_query = "UPDATE invoices SET balance = (balance - '$total2'), refunds = (refunds + '$total2') where invoice_num='$invoice';";
	if (!$conn->query($update_query) === TRUE) {
		echo "<script>";
		echo "alert('Error');";
		echo "</script>";
	}

echo "<script>window.location.href = 'refunds.php?num=$invoice';</script>";
?>