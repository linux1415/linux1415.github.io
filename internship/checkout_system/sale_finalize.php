<?php
session_start();
include '../verify.php';

if (!isset($_SESSION['user']))
{
    die(include 'index.html');
}
include '../database_connect.php';
unset($_SESSION['payment_array']);
unset($_SESSION['repairs']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Database Connect</title>
<meta charset="utf-8">
<style type="text/css" media="screen">
	
body {
	font-family: sans-serif;
	margin-left: 2em;
	width: 1200px;
	height: 800px;
	border: 1px solid black;
	box-shadow: 5px 5px 0 0;
	margin-left: auto;
	margin-right: auto;
}

#centered {
	margin-top: 20px;
	width: 1200px;
	text-align: center;
	height: 550px;
}

input[type=text] {
	font-size:12pt;
	height:20px;
	width:150px;
	text-align: center;
}

label {
	font-size: 12pt;
}

select {
	font-size: 14pt;
	height: 30px;
}

table {
	width: 1100px;
	table-layout: fixed;
	border-collapse: collapse;
	margin-left: 50px;
}

#overflow {
	height: 75px;
	overflow: auto;
}

table{
  border: 1px solid black;
  font-size: 12pt;
}

td, th {
	border: 0;
}

div.scrollable {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: auto;
}

#table, #table2 {
	height: 150px;
	margin-bottom: 30px;
}

#bottom {
	width: 700px;
	text-align: center;
	margin-left: 250px;
}

</style>
</head>
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script src="../javascript/jquery-3.3.1.min.js"></script>

<script>
function generate() {
	var id = document.getElementById('c_id').value;
	//window.location.href = "../reports/quote.php?id=" + id;
	window.open("../reports/quote.php?id=" + id);
} 
</script>
<main>
<body>
<div id="centered">
<form action="pay.php" method="post" onsubmit="return validate()">
<h2>Finalize</h2>
<?
if (isset($_GET['id'])) {
	$cust_id = $_GET['id'];
	echo "<input value='$cust_id' id='c_id' name = 'id' style='display:none'>";
}
else {
	echo "<script>window.location.href = 'new_sale_add.php';</script>";
}

if (isset($_GET['f_name']) && isset($_GET['l_name'])) {
	$first = $_GET['f_name'];
	$last = $_GET['l_name'];
	echo "<input value='$first' name = 'first' style='display:none'>";
	echo "<input value='$last' name = 'last' style='display:none'>";
	echo '<label>Customer:&nbsp;' . $first . ' ' . $last . '</label><br><br>';
}
if ($cust_id == 'guest') {
	echo '<label>Customer:&nbsp;Guest</label><br><br>';
}


if (isset($_SESSION['sales_array']))
{
	$repair = 'no';
	//echo '<label>Customer:&nbsp;' . $first . ' ' . $last . '</label><br><br>';
	if (count($_SESSION['sales_array']) > 0) {
	$sales = $_SESSION['sales_array'];
	echo '<div class=scrollable id="table"><table id="mytable"><tr><th>Item</th><th>Item Price</th><th>SKU</th><th>Category</th><th>Quantity</th></tr>';
	$index = 0; $total = 0;
	foreach ($_SESSION['sales_array'] as $key => $value) {
		$item = $value[1];
		$price = $value[2];
		$sku = $value[0];
		$category = $value[3];
		$qty = $value[4];
		$type = $value[5];
		if ($type == 'repair') {
			$repair = 'yes';
		}
		echo "<tr>";
		echo "<td>$item</td><td>$price</td><td>$sku</td><td>$category</td><td>$qty</td>";
		echo "</tr>";
		$total += ($price * $qty);
	}
	$total2 = round($total + ($total * .09), 2);
	echo "</table></div>";
	echo "<label><b>Subtotal:</b>&nbsp;$$total</label><br>";
	echo "<label><b>Total:</b>&nbsp;$$total2</label><br><br>";
	if ($repair == 'yes') {
	echo '<label>Repair Details</label>';
	echo '<div class=scrollable id="table2"><table id="mytable2"><tr><th>Repair</th><th>SKU</th><th>Device ID</th><th>Color</th><th>Description</th></tr>';
	foreach ($_SESSION['sales_array'] as $key => $value) {
		$item = $value[1];
		$price = $value[2];
		$sku = $value[0];
		$category = $value[3];
		$qty = $value[4];
		$type = $value[5];
		$count = 0;
		if ($type == 'repair') {
			while ($count < $qty) {
				//echo "<input value='$item' name = 'repairs[]' style='display:none'>";
				//echo "<input value='$sku' name = 'repairs[]' style='display:none'>";
				echo "<tr>";
				echo "<td>$item<input value='$item' name = 'repairs[]' style='display:none'></td><td>$sku<input value='$sku' name = 'repairs[]' style='display:none'></td><td><input id='id_$sku' name = 'repairs[]' type='text'></td><td><input id='color_$sku' name = 'repairs[]' type='text'></td><td><textarea id='desc_$sku' name = 'repairs[]' rows='4'></textarea></td>";
				echo "</tr>";
				$count += 1;
			}
		}
	}
	echo "</table></div>";
	}
	//echo "<label><b>Balance:</b>&nbsp;<span id = 'balance'>$$total2</span></label><br><br>";
	}
	else {
		unset($_SESSION['sales_array']);
		echo "<script>window.location.href = 'new_sale_add.php';</script>";
	}

}
else {
	echo "<script>window.location.href = 'new_sale_add.php';</script>";
}
?>
</div>
<br><br>
<div id='bottom'>
<input type="submit" value="Pay" style="font-size:22pt;height:40px;width:250px;"/>
<button style="font-size:22pt;height:40px;width:250px;" type="button" onclick="generate()">Quote</button>
</form>
<form action="choose_customer.php">
    <input type="submit" value="Back" style="font-size:22pt;height:40px;width:250px;margin-top:10px;"/>
</form>
<form action="../admin_home.php">
    <input type="submit" value="Home" style="font-size:22pt;height:40px;width:250px;margin-top:10px;"/>
</form>
</div>
</body>
</main>
</html>