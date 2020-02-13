<?php
include '../verify.php';

include '../database_connect.php'; 

if (isset($_REQUEST['sku'])) {
	$sku = trim($_REQUEST['sku']);

	$used_query = "select * from used_skus where sku='$sku';";
	$sku_array = mysqli_query($conn, $used_query);
	$sku_row = mysqli_fetch_array($sku_array, MYSQLI_ASSOC);

	if (count($sku_row) > 0) {
		echo json_encode('fail');
	}
	else {
		echo json_encode('allowed');
	}
}

if (isset($_REQUEST['get'])) {
	$sku_row = array("item");
	while (count($sku_row) > 0) {
		$sku = rand(1000,9999);
		$used_query = "select * from used_skus where sku='$sku';";
		$sku_array = mysqli_query($conn, $used_query);
		$sku_row = mysqli_fetch_array($sku_array, MYSQLI_ASSOC);
	}
	echo json_encode($sku);
}

if (isset($_REQUEST['part_id'])) {
	$part_id = trim($_REQUEST['part_id']);
	
	$query = "select * from ordered_parts where id='$part_id';";
	$array = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
	$part = $row['part'];
	$part_id = $row['id'];
	$part_color = $row['part_color'];
	$o_date = $row['order_date'];
	$d_date = $row['due_date'];
	$exp_date = $row['exp_date'];
	$part_sku = $row['sku'];
	$part_price = $row['price'];
	$cat_id = $row['category_id'];
	
	$query2 = "select category_name from categories where category_id='$cat_id';";
	$array2 = mysqli_query($conn, $query2);
	$row2 = mysqli_fetch_array($array2, MYSQLI_ASSOC);
	$cat_name = $row2['category_name'];
	
	if (!isset($_SESSION['sales_array']))
	{
		$_SESSION['sales_array'] = array();
	}
	$_SESSION['sales_array']["$part_sku"] = array($part_sku, $part, $part_price, $cat_name, '0', 'item', $cat_id, '1');
	if (!isset($_SESSION['on_order_array']))
	{
		$_SESSION['on_order_array'] = array();
	}
	$_SESSION['on_order_array']["$part_id"] = $sku;
	
	echo json_encode('Item Added to Cart');
}


?>