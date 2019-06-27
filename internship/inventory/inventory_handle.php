<?php
include '../authenticate_admin.php';


include '../database_connect.php'; 


$item = $_REQUEST['item'];
$price = $_REQUEST['price'];
$sku = $_REQUEST['sku'];
$category = $_REQUEST['category'];
$qty = $_REQUEST['qty'];
$store = $_REQUEST['store'];

//check to see if item exists already
$check_query = "select * from inventory where sku='$sku' and store='$store';";
$array = mysqli_query($conn, $check_query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);

$check_query2 = "select * from products where sku='$sku';";
$array2 = mysqli_query($conn, $check_query2);
$row2 = mysqli_fetch_array($array2, MYSQLI_ASSOC);

$check_query3 = "select store_name from stores where store_id='$store';";
$array3 = mysqli_query($conn, $check_query3);
$row3 = mysqli_fetch_array($array3, MYSQLI_ASSOC);

$now = new DateTime();
$now->setTimezone(new DateTimeZone('America/Chicago'));  
$date = $now->format('Y-m-d H:i:s');
$update = "Inventory Updated: SKU: " . $sku . ", STORE: " . $row3['store_name'] . ", QTY: " . $qty;
$user = $_SESSION['id'];


if (count($row) > 0) {
	$update_query = "UPDATE inventory SET qty = (qty + $qty) where sku='$sku' and store='$store';";
	if ($conn->query($update_query) === TRUE) {
		$log = "insert into logs (date, user_id, description) values ('$date', '$user', '$update');";
		mysqli_query($conn, $log);
		$update_sku = "insert into used_skus (sku) values ('$sku');";
		mysqli_query($conn, $update_sku);
		echo "<script>";
		echo "alert('Inventory Updated');";
		echo "</script>";
		//$_SESSION['inventory_response'] = "Inventory Updated.";		
	}
	else {
		echo "<script>";
		echo "alert('Error');";
		echo "</script>";
	}
}

else {
	$sql = "INSERT INTO inventory (sku, item_price, item_name, category, store, qty) VALUES ('$sku', '$price', '$item', '$category', '$store', '$qty');";
	if ($conn->query($sql) === TRUE) {
		$log = "insert into logs (date, user_id, description) values ('$date', '$user', '$update');";
		mysqli_query($conn, $log);
		$update_sku = "insert into used_skus (sku) values ('$sku');";
		mysqli_query($conn, $update_sku);
		echo "<script>";
		echo "alert('New Item Added to Inventory');";
		echo "</script>";
		if (count($row2) == 0) {
			echo "<script>if (window.confirm('Add item to products database?')) {
								window.location.href = 'inventory_product_add.php?sku=$sku&price=$price&category=$category&item=$item';
							}
			</script>";
		}
	}
	else {
		echo "<script>";
		echo "alert('Error');";
		echo "</script>";
	}
}
//echo $_SESSION['inventory_response'];
//die();
echo '<script>window.location.href="inventory_add.php";</script>';

?>