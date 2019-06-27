<?php

include '../database_connect.php';

//variables from html form
$option = $_REQUEST['option'];
$ids = $_REQUEST['ids'];

if ($option == 'delete') {
	foreach ($ids as $id) {
		$delete = "DELETE FROM sales WHERE sale_id='$id';";
		mysqli_query($conn, $delete);
	}
}

if ($option == 'edit') {


$sales = $_REQUEST['sales'];
$index = -1;
$display = 0;
$item_row = 0;
foreach ($sales as $value) {
	$index += 1;
	$item = $sales[$index];
	if ($index % 9 == 0) {		//finds sale id
		$item_row += 1;
		if (in_array($item, $ids, TRUE)) {
			$id = $sales[$index];
			$date = trim($sales[$index+1]);
			$item = trim($sales[$index+2]);
			$price = trim($sales[$index+3]);
			$invoice = trim($sales[$index+4]);
			$sku = trim($sales[$index+5]);
			$commission = trim($sales[$index+6]); 
			$chargeback = trim($sales[$index+7]);
			$category = trim($sales[$index+8]);
			if (is_numeric($commission)) {
				$commission = "'$commission'";
			}
			else {
				$commission = "NULL";
			}
			if (is_numeric($chargeback)) {
				$chargeback = "'$chargeback'";
			}
			else {
				$chargeback = "NULL";
			}
			$update = "UPDATE sales SET item_price = '$price', item = '$item', sku = '$sku', invoice_num = '$invoice', week_of_year = WEEKOFYEAR('$date'), month = MONTHNAME('$date'), day = DAY('$date'), year = YEAR('$date'), date = '$date', commission = $commission, chargeback = $chargeback, category = '$category' WHERE sale_id='$id';";
			mysqli_query($conn, $update);
		}
		else {
			continue;
		}
	}
}
echo "<script>";
echo "alert('Edits Completed.');";
echo "</script>";
//echo '<script>window.location.href = "edit_delete_sales.php";</script>';
echo '<script>window.location.href = "javascript:history.go(-1)";</script>';
}

?>