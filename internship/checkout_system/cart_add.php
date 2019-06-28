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
	width: 1000px;
	height: 700px;
	border: 1px solid black;
	box-shadow: 5px 5px 0 0;
	margin-left: auto;
	margin-right: auto;
}

#centered {
	margin-top: 20px;
	width: 1000px;
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
	width: 500px;
	table-layout: fixed;
	border-collapse: collapse;
}

#overflow {
	height: 75px;
	overflow: auto;
}

table, th, td {
  border: 1px solid black;
  font-size: 12pt;
}

div.scrollable {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: auto;
}

#table {
	height: 300px;
	margin-bottom: 30px;
}

</style>
</head>
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script src="../javascript/jquery-3.3.1.min.js"></script>

<script>
window.onload = function focus() {
	document.getElementById('sku').focus();
	document.getElementById('sku').select();
}

function check() {
	var sku = document.getElementById('sku').value;
	if (sku.length > 0) {
		document.getElementById("my_table").style.display="table";
	}
	else {
		document.getElementById("my_table").style.display="none";
	}
}

function add() {
	var sku = document.getElementById('sku').value;
	var qty = document.getElementById('qty').value;
	if (sku != '') {
		window.location.href = "new_sale_handle.php?sku=" + sku + "&qty=" + qty;
	}
}

function del(a) {
	var sku = a;
	window.location.href = "new_sale_delete.php?sku=" + sku;
}

function update(a) {
	var sku = a;
	var price = document.getElementById('price_' + sku).value;
	var qty = document.getElementById('qty_' + sku).value;
	window.location.href = "new_sale_update.php?sku=" + sku + "&qty=" + qty + "&price=" + price;
}

function checkout() {
	window.location.href = "choose_customer.php";
}

function del_new() {
	window.location.href = "new_sale_add.php";
}

function go(event) {
    if (event.which == 13 || event.keyCode == 13) {
		add();
		return false;
    }
}

function add_row() {
  var len = document.getElementById("mytable").rows.length;
  var table = document.getElementById("mytable");
  var row = table.insertRow(len);
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3)
  var cell5 = row.insertCell(4);
  var cell6 = row.insertCell(5)
  cell1.innerHTML = "<input name='sales[]' type='text'>";
  cell2.innerHTML = "<input name='sales[]' type='text'>";
  cell3.innerHTML = "<input name='sales[]' type='text'>";
  cell4.innerHTML = "<input name='sales[]' type='text'>";
  cell5.innerHTML = "<input name='sales[]' type='text'>";
  cell6.innerHTML = "<button type='button' onclick='del_row(\"" + len + "\")'>Delete</button>";
}

function del_row(num) {
  document.getElementById("mytable").deleteRow(num);
}

function create() {
	var type;
	if (window.confirm('Choose OK if this is a repair.')) {
		type = "repair";
	}
	else {
		type = "item";
	}
	var desc = document.getElementById('new_desc').value;
	var price = document.getElementById('new_price').value;
	var sku = document.getElementById('new_sku').value;
	var cat = document.getElementById('new_cat').value;
	var qty = document.getElementById('new_qty').value;
	window.location.href = "special_sale.php?sku=" + sku + "&qty=" + qty + "&price=" + price + "&cat=" + cat + "&desc=" + desc + "&type=" + type;
}
</script>
<main>
<body>
<div id="centered">
<h2>Cart:</h2>
<!--<button style="font-size:10pt;height:40px;width:75px;margin-bottom:10px;" type="button" id="buttonMain" onclick="add_row()">Special Sale</button>-->
<?
if (count($_SESSION['sales_array']) < 1) {
	unset($_SESSION['sales_array']);
}
if (isset($_SESSION['sales_array']) || (isset($_GET['type']) && isset($_GET['sku'])))
{
	echo '<div class=scrollable id="table"><table id="mytable" style="width: 950px;margin-left:25px;"><tr><th>Item</th><th>Item Price</th><th>SKU</th><th>Category</th><th>Quantity</th><th></th></tr>';
	if (isset($_SESSION['sales_array'])) {
	$sales = $_SESSION['sales_array'];
	//echo '<div class=scrollable id="table"><table id="mytable" style="width: 950px;margin-left:25px;"><tr><th>Item</th><th>Item Price</th><th>SKU</th><th>Category</th><th>Quantity</th><th></th></tr>';
	$index = 0; $total = 0;
	foreach ($_SESSION['sales_array'] as $key => $value) {
		$item = $value[1];
		$price = $value[2];
		$sku = $value[0];
		$category = $value[3];
		$qty = $value[4];
		echo "<tr>";
		echo "<td>$item</td><td><input id='price_$sku' style='width: 75px;' value='$price' type='text'></td><td>$sku</td><td>$category</td><td><input id='qty_$sku' style='width: 75px;' value='$qty' type='text'></td><td><button type='button' onclick='update(\"$sku\")'>Update</button>&nbsp;&nbsp;<button type='button' onclick='del(\"$sku\")'>Delete</button></td>";
		echo "</tr>";
		$total += ($price * $qty);
	}
	$total2 = round($total + ($total * .09), 2);
	}
	if (isset($_GET['type']) && isset($_GET['sku'])) {
		$new_sku = $_GET['sku'];
		echo "<tr>";
		echo "<td><input id='new_desc' placeholder='Description' type='text'></td><td><input id='new_price' placeholder='Price' style='width: 75px;' type='text'></td><td><input id='new_sku' value='$new_sku' type='text'></td>";
		echo "<td><select id='new_cat'>";

		$query2 = "SELECT category_name, category_id
			FROM categories;";
	
		$array2 = mysqli_query($conn, $query2);
		while ($row2 = mysqli_fetch_array($array2, MYSQLI_ASSOC)){
			echo '<option value=\'' . $row2['category_id'] . '\'>' . $row2['category_name'] . '</option>';
		}
		echo "</select></td>";
		echo "<td><input id='new_qty' placeholder='Quantity' style='width: 75px;' type='text'></td><td><button type='button' onclick='create()'>Create</button>&nbsp;&nbsp;<button type='button' onclick='del_new()'>Delete</button></td>";
		echo "</tr>";
	}
	echo "</table></div>";
	if (isset($_SESSION['sales_array'])) {
		echo "<label><b>Subtotal:</b>&nbsp;$$total</label><br>";
		echo "<label><b>Total:</b>&nbsp;$$total2</label><br><br>";
	}

}
else {
	echo "<h3>Cart is Empty</h3>";
}
?>
<table style = "margin-left: 250px;">
<tr>
<th>Add Item to Cart:</th>
<td>
<label>SKU:</label>
<input type="text" id="sku" style="margin-bottom:10px;margin-top:10px;width:150px;" autocomplete="off" onkeypress="return go(event)">
<label>Quantity:</label>
<input type="text" value="1" id="qty" style="width:35px;" autocomplete="off">&nbsp;&nbsp;
<button style="font-size:12pt;height:30px;width:75px;margin-bottom:10px;" type="button" id="buttonMain" onclick="add()">Add</button>
</td>
</tr>
</table>
</div>
<button style="font-size:22pt;height:40px;width:250px;margin-left:375px;margin-top:15px;" type="button" onclick="checkout()">Checkout</button><br>
<form action="../admin_home.php">
    <input type="submit" value="Home" style="font-size:22pt;height:40px;width:250px;margin-left:375px;margin-top:10px;"/>
</form>
</body>
</main>
</html>
