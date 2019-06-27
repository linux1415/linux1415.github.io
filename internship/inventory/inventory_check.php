<?php

include '../database_connect.php';

$sku= $_GET["sku"];

$query = "select * from products where sku='$sku';";
$array = mysqli_query($conn, $query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);

if (count($row) < 1) {
	$check_query2 = "select * from used_skus where sku='$sku';";
	$array2 = mysqli_query($conn, $check_query2);
	$row2 = mysqli_fetch_array($array2, MYSQLI_ASSOC);
	if (count($row2) > 0) {
		echo "<script>";
		echo "alert('SKU not available.');";
		echo "</script>";
		echo '<script>window.location.href="inventory_add.php";</script>';
		die();
	}
	echo "<script>";
	echo "alert('Item Not Found. SKU can be assigned to new item.');";
	echo "</script>";
	$_SESSION['sku'] = $sku;
	echo '<script>window.location.assign("inventory_add.php?status=write");</script>';
	die();
}
else {
	$_SESSION['int_item_name'] = $row['item_name'];
	$_SESSION['price'] = $row['item_price'];
	$_SESSION['cat'] = $row['category'];
	$_SESSION['sku'] = $row['sku'];
}

//echo '<script>window.location.href="add_inventory.php";</script>';

echo '<script>window.location.assign("inventory_add.php?status=readonly");</script>';

?>