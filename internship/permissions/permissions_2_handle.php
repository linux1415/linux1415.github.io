<?php

include '../database_connect.php';

//variables from html form
$sales = $_REQUEST['sales'];

$index = -1;
$display = 0;
$item_row = 0;
foreach ($sales as $value) {
	$index += 1;
	$item = $sales[$index];
	if ($index % 7 == 0) {		//finds sale id
		$item_row += 1;
		$id = $sales[$index];
		$sales_p = trim($sales[$index+1]);
		$item_p = trim($sales[$index+2]);
		$cat = trim($sales[$index+3]);
		$invent = trim($sales[$index+4]);
		$products = trim($sales[$index+5]);
		$repairs = trim($sales[$index+6]); 
		$update = "UPDATE permissions_tables SET sales_performance = '$sales_p', item_performance = '$item_p', category_performance = '$cat', inventory = '$invent', 
		products = '$products', repairs = '$repairs' WHERE user_id='$id';";
		mysqli_query($conn, $update);
		//echo $update;
		//die();
	}
}
echo "<script>";
echo "alert('Permissions Updated.');";
echo "</script>";
//echo '<script>window.location.href = "edit_delete_sales.php";</script>';
echo '<script>window.location.href = "javascript:history.go(-1)";</script>';


?>