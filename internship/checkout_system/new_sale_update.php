<?
session_start();
include '../database_connect.php'; 

$sku= $_GET["sku"];
$qty = $_GET["qty"];
$price = $_GET["price"];
$invoice = $_GET["invoice"];
$_SESSION['invoice_num'] = $invoice;
$store = '1';

$check_query = "select * from inventory where sku='$sku' and store='$store';";

$array = mysqli_query($conn, $check_query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);

$check_query2 = "select * from repair_info where sku='$sku';";

$array2 = mysqli_query($conn, $check_query2);
$row2 = mysqli_fetch_array($array2, MYSQLI_ASSOC);

$_SESSION['sales_array']["$sku"][4] = $qty;
$_SESSION['sales_array']["$sku"][2] = $price;

if (count($row2) < 1 && count($row) > 0) {
if ($qty > $row['qty']) {
	echo "<script>";
	echo "alert('Number in stock: " . $row['qty'] . "');";
	echo "</script>";
	$_SESSION['sales_array']["$sku"][4] = $row['qty'];
}
}

echo '<script>window.location.href="new_sale_add.php";</script>';
?>