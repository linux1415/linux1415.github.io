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
	if ($index % 10 == 0) {		//finds sale id
		$item_row += 1;
		$id = $sales[$index];
		$sale = trim($sales[$index+1]);
		$edit_sales = trim($sales[$index+2]);
		$add_int = trim($sales[$index+3]);
		$edit_int = trim($sales[$index+4]);
		$add_prod = trim($sales[$index+5]);
		$edit_prod = trim($sales[$index+6]); 
		$add_comm = trim($sales[$index+7]);
		$add_rep_opt = trim($sales[$index+8]);
		$add_rep = trim($sales[$index+9]);
		$update = "UPDATE permissions SET add_sale = '$sale', edit_sale = '$edit_sales', add_inventory = '$add_int', edit_inventory = '$edit_int', 
		add_product = '$add_prod', edit_product = '$edit_prod', add_commission = '$add_comm', add_repair_option = '$add_rep_opt', add_repair_sale = '$add_rep'  WHERE user_id='$id';";
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