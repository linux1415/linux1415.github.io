<?php
session_start();
include '../database_connect.php'; 

$employee = $_SESSION['user'];
$store = $_SESSION['store'];
$sku= $_GET["sku"];
$qty = $_GET["qty"];
//$invoice = $_GET["invoice"];
$_SESSION['invoice_num'] = $invoice;

$check_query = "select * from inventory where sku='$sku' and store='$store';";

$array = mysqli_query($conn, $check_query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
$total_qty = $row['qty'];

$check_query2 = "select * from repair_info where sku='$sku';";

$array2 = mysqli_query($conn, $check_query2);
$row2 = mysqli_fetch_array($array2, MYSQLI_ASSOC);


if (count($row) < 1 && count($row2) < 1) {
	$used_query = "select * from used_skus where sku='$sku';";
	$sku_array = mysqli_query($conn, $used_query);
	$sku_row = mysqli_fetch_array($sku_array, MYSQLI_ASSOC);
	if (count($sku_row) > 0) {
		echo "<script>";
		echo "alert('Item or Repair Does Not Exist. SKU not available.');";
		echo "</script>";
		echo "<script>window.location.href='new_sale_add.php;'</script>";
		die();
	}
	echo "<script>";
	echo "alert('Item or Repair Does Not Exist. SKU available.');";
	echo "window.location.href = 'new_sale_add.php?type=new&sku=$sku';";
	//echo 'window.location.href="new_sale_add.php";';
	echo "</script>";
	die();
}

if (!isset($_SESSION['sales_array']))
{
    $_SESSION['sales_array'] = array();
}

if (count($row) > 0) {

$query = "select inventory.item_name as item, inventory.item_price as price, categories.category_name as category, categories.category_id as cat_id
	from inventory, categories
	where inventory.category=categories.category_id
	and inventory.sku='$sku';";

$array = mysqli_query($conn, $query);

while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
	$category = $row['category'];
	$cat_id = $row['cat_id'];
	$item = $row['item'];
	$price = $row['price'];
	$type = "item";
}
}

else {
	$query = "select repair_info.description as item, repair_info.cost as price, categories.category_name as category, categories.category_id as cat_id
	from repair_info, categories
	where repair_info.category=categories.category_id
	and repair_info.sku='$sku';";

$array = mysqli_query($conn, $query);

while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
	$category = $row['category'];
	$cat_id = $row['cat_id'];
	$item = $row['item'];
	$price = $row['price'];
	$type = "repair";
}

}

//array_push($_SESSION['sales_array'],$item, $price, $sku, $category, $qty); 
//$_SESSION['sales_array'] = array();


if (isset($_SESSION['sales_array']["$sku"])) {
	$_SESSION['sales_array']["$sku"][4] += $qty;
}
else {
	$_SESSION['sales_array']["$sku"] = array($sku, $item, $price, $category, $qty, $type, $cat_id);
}

if (count($row2) < 1) {
if ($total_qty == 0) {
	unset($_SESSION['sales_array']["$sku"]);
	echo "<script>";
	echo "alert('Item is out of stock.');";
	echo "</script>";
	echo '<script>window.location.href="new_sale_add.php";</script>';
	die();
	}
if ($_SESSION['sales_array']["$sku"][4] > $total_qty) {
	echo "<script>";
	echo "alert('Number in stock: " . $total_qty . "');";
	echo "</script>";
	$_SESSION['sales_array']["$sku"][4] = $total_qty;
}
}

echo '<script>window.location.href="new_sale_add.php";</script>';

?>