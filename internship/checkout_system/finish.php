<?php
session_start();
include '../verify.php';

if (!isset($_SESSION['user']))
{
    die(include 'index.php');
}
include '../database_connect.php';

$cust_id = $_SESSION['customer_id'];
$employee = $_SESSION['id'];
$date = date('Y-m-d');
$store = $_SESSION['store'];
$totals = $_SESSION['total_sales'];
//$invoice = '12345';

$now = new DateTime();
$now->setTimezone(new DateTimeZone('America/Chicago'));  
$date_time = $now->format('Y-m-d H:i:s');

$sql = "INSERT INTO invoices (cust_id, date, total, store, employee_id) 
VALUES ('$cust_id', '$date_time', '$totals', '$store', '$employee');";
mysqli_query($conn, $sql);

$get_query = "select invoice_num from invoices where date='$date_time' and employee_id='$employee' and store='$store' and total='$totals';";
$array = mysqli_query($conn, $get_query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
$invoice = $row['invoice_num'];


if (isset($_SESSION['repairs'])) {
	$repairs = $_SESSION['repairs'];
	//var_dump($repairs);
	//die();
	$count = 0; $index = 0;
	foreach ($repairs as $x) {
		if ($count == 0) {
			$desc = $repairs[$index];
			$re_sku = $repairs[$index + 1];
			$device_num = $repairs[$index + 2];
			$color = $repairs[$index + 3];
			$details = $repairs[$index + 4];
			$sql = "INSERT INTO repair_sales (description, sku, invoice_num, device_id, details, color, week, month, day, year, date, user_id, store, chargeback) 
			VALUES ('$desc', '$re_sku', '$invoice', '$device_num', '$details', '$color', WEEKOFYEAR('$date'), MONTHNAME('$date'), DAY('$date'), YEAR('$date'), '$date', '$employee', '$store', '0.00');";
			mysqli_query($conn, $sql);
		}
		$count += 1;
		$index += 1;
		if ($count == 5) {
			$count = 0;
		}
	}
}


//adding from sales array
$sales = $_SESSION['sales_array'];
$total = 0;
foreach ($sales as $key => $value) {
	$item = $value[1];
	$price = $value[2];
	$sku = $value[0];
	//$category = $value[3];
	$qty = $value[4];
	$type = $value[5];
	$category = $value[6];
	if ($type != 'repair') {
		$count = 0;
		while ($count < $qty) {
			$sql = "INSERT INTO sales (user_id, item_price, item, sku, invoice_num, week_of_year, month, day, year, date, store, category, cust_id, chargeback) 
			VALUES ('$employee', '$price', '$item', '$sku', '$invoice', WEEKOFYEAR('$date'), MONTHNAME('$date'), DAY('$date'), YEAR('$date'), '$date', '$store', '$category', '$cust_id', '0.00');";
			mysqli_query($conn, $sql);
			//echo $sql;
			$count += 1;
		}
		$check_query = "select * from inventory where sku='$sku' and store='$store';";
		$array = mysqli_query($conn, $check_query);
		$row = mysqli_fetch_array($array, MYSQLI_ASSOC);

		if (count($row) > 0) {
			$update_query = "UPDATE inventory SET qty = (qty - $qty) where sku='$sku' and store='$store';";
			if (!$conn->query($update_query) === TRUE) {
			echo "<script>";
			echo "alert('Error');";
			echo "</script>";
			}
		}
	}
	else {
		$sql = "UPDATE repair_sales SET cost = '$price', category = '$category' where invoice_num='$invoice' and sku='$sku';";
		mysqli_query($conn, $sql);
	}
		
	$total += ($price * $qty);
	}
$total2 = round($total + ($total * .09), 2);
	
//adding from payment array	
if (isset($_SESSION['payment_array'])) {
	$payed = 0;
	foreach ($_SESSION['payment_array'] as $key => $value) {
		$payed += $value;
	}
}
else {
	$payed = 0;
}

$balance = $total2 - $payed;

//$sql = "INSERT INTO invoices (cust_id, date, total, balance, amount_payed) 
//VALUES ('$cust_id', '$date', '$total2', '$balance', '$payed');";
$sql = "UPDATE invoices SET total = '$total2', balance = '$balance', amount_payed = '$payed', refunds = '0.00' where invoice_num='$invoice';";
mysqli_query($conn, $sql);

unset($_SESSION['payment_array']);
unset($_SESSION['sales_array']);
unset($_SESSION['repairs']);
unset($_SESSION['customer_id']);
echo "<script>alert('Sale Completed');</script>";
echo "<script>window.location.href = 'orders_table.php?invoice=$invoice';</script>";

?>