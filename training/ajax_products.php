<?php
session_start();
include '../verify.php';
include '../database_connect.php'; 

$id = $_SESSION['id'];
$query = "select * from permissions where user_id='$id';";
$array = mysqli_query($conn, $query);
$perm1 = mysqli_fetch_array($array, MYSQLI_ASSOC);
if ($perm1['edit_product'] == 'yes' || $_SESSION['account'] == 'admin') {
	$edit = 'yes';
}
if ($perm1['add_inventory'] == 'yes' || $_SESSION['account'] == 'admin') {
	$add = 'yes';
}

if ($add == 'yes') {
	if (isset($_REQUEST['post_sku'])) {
		$sku = mysqli_real_escape_string($conn, $_REQUEST['post_sku']);
		$qty = trim($_REQUEST['post_qty']);
		$item = mysqli_real_escape_string($conn, $_REQUEST['post_item']);
		$category = $_REQUEST['post_cat_id'];
		$model = mysqli_real_escape_string($conn, $_REQUEST['post_model']);
		$price = $_REQUEST['post_price'];
		$store = $_REQUEST['post_store'];
		
		$sql = "INSERT INTO inventory (sku, item_price, item_name, category, store, qty, model_num) VALUES ('$sku', '$price', '$item', '$category', '$store', '$qty', '$model');";
		
		if ($conn->query($sql) === TRUE) {
			echo json_encode("Item Added to Inventory.");		
		} 
		else {
			echo json_encode("Error.");
		}
	}

	if (isset($_REQUEST['post_sku_update'])) {
		$sku = mysqli_real_escape_string($conn, $_REQUEST['post_sku_update']);
		$qty = trim($_REQUEST['post_qty_update']);
		$store = $_REQUEST['post_store_update'];
		
		$sql = "UPDATE inventory SET qty = (qty + $qty) where sku='$sku' and store='$store';";
		
		if ($conn->query($sql) === TRUE) {
			echo json_encode("Inventory Updated.");		
		} 
		else {
			echo json_encode("Error.");
		}
	}
}

if ($edit == 'yes') {
	if (isset($_REQUEST['edit_item'])) {
		$product_id = $_REQUEST['edit_product_id'];
		$item = mysqli_real_escape_string($conn, trim($_REQUEST['edit_item']));
		$category = $_REQUEST['edit_cat_id'];
		$model = mysqli_real_escape_string($conn, trim($_REQUEST['edit_model']));
		$price = trim($_REQUEST['edit_price']);
		$is_part = $_REQUEST['edit_is_part'];
		$edit_inventory = $_REQUEST['edit_inventory'];
		$sku = $_REQUEST['edit_sku'];
		
		$sql = "UPDATE products SET item_name = '$item', category = '$category', item_price = '$price', model_num = '$model', is_part = '$is_part' where id='$product_id';";
		
		if ($conn->query($sql) === TRUE) {
			$first = 'success';		
		} 
		else {
			echo json_encode("Error.");
			die();
		}
		
		if ($edit_inventory == 'yes') {
			$sql2 = "UPDATE inventory SET item_name = '$item', category = '$category', item_price = '$price', model_num = '$model' where sku='$sku';";
			if ($conn->query($sql2) === TRUE) {
				$second = 'success';		
			} 
			else {
				echo json_encode("Error.");
				die();
			}
		}
		
		echo json_encode("Edits Completed.");
	}
}
	





?>