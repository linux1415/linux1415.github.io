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
?>
<!DOCTYPE html>

<html lang="en">
	
<head> 
<title>Products</title>
<meta charset="utf-8">
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script src="../javascript/jquery-3.3.1.min.js"></script>
<script src="../javascript/jquery.tablesorter.min.js"></script>
<script>
$(function () {
	$('table').tablesorter({
		cssAsc: 'up',
		cssDesc: 'down',
		cssNone: ''
	});
});

modals = ['store_modal', 'edit_modal'];


var product_sku; var product_item; var product_cat_id; var product_price; var product_model; var product_qty; var product_add_type; var product_item_id; var product_is_part;

function select(sku, item, cat_id, price, model, product_id, add_type, is_part) {
	var select = document.getElementById(product_id);
	var chosen = select.options[select.selectedIndex].value;
	document.getElementById(product_id).value = "0";	
	product_sku = window.atob(sku);
	product_item = window.atob(item);
	product_cat_id = cat_id;
	product_price = price;
	product_model = window.atob(model);
	product_item_id = product_id;
	product_add_type = add_type;
	product_is_part = is_part;
	if (chosen == '1') {
		store_modal();
	}
	if (chosen == '2') {
		edit_modal();
	}
	
}

function store_modal() { 
	var modal = document.getElementById('store_modal');
	modal.style.display = "block";
	document.getElementById('modal_item_label_add').innerHTML = product_item; 
	document.getElementById('modal_sku_label_add').innerHTML = product_sku; 
	document.getElementById('modal_model_label_add').innerHTML = product_model; 
}

function edit_modal() { 
	var modal = document.getElementById('edit_modal');
	modal.style.display = "block";
	var inventory = document.getElementById('inv_edit_option');
	if (product_add_type == 'update') {
		inventory.style.display = "block";
	}
	else {
		inventory.style.display = "none";
	}
	document.getElementById('modal_item').value = product_item;	
	document.getElementById('modal_price').value = product_price;	
	document.getElementById('modal_model').value = product_model;
	document.getElementById('modal_category').value = product_cat_id;	
	document.getElementById('modal_is_part').value = product_is_part;	
	document.getElementById('modal_item_label').innerHTML = product_item; 
	document.getElementById('modal_sku_label').innerHTML = product_sku; 
	document.getElementById('modal_model_label').innerHTML = product_model; 
}

function hide(a) {
	var span = document.getElementById(a);
	span.style.display = "none";
}

function get_store(a) {
	var store = document.getElementById("store").value;
	//var store = select.options[select.selectedIndex].value;
	product_qty = document.getElementById('modal_qty').value.trim();
	if (!Number.isInteger(Number(product_qty)) || Number(product_qty) < 0 || product_qty == "") {
		alert("Quantity must be an integer.");
	}
	else {
		hide(a);
		if (product_add_type == 'update') {
			add_inventory_update(store);
		}
		if (product_add_type == 'new') {
			add_inventory_new(store);
		}
	}
}

function add_inventory_new(store) {
		//console.log(product_sku + "," + product_item + "," + product_cat_id + "," + product_price + "," + product_model + "," + product_qty + "," + store + "," + product_item_id + "," + product_add_type);
		//return;
		$.ajax({
		url: 'ajax_products.php',
		type: 'POST',
		data: {post_sku: product_sku,
			post_item: product_item,
			post_cat_id: product_cat_id,
			post_price: product_price,
			post_model: product_model,
			post_qty: product_qty,
			post_store: store},
		success: function (result) {
			var result = JSON.parse(result);
			alert(result);
			window.location.href = "products_table.php";
			}		
		});
}

function add_inventory_update(store) {
		//console.log(product_sku + "," + store + "," + product_qty);
		//return;
		$.ajax({
		url: 'ajax_products.php',
		type: 'POST',
		data: {post_sku_update: product_sku,
			post_qty_update: product_qty,
			post_store_update: store},
		success: function (result) {
			var result = JSON.parse(result);
			alert(result);
			window.location.href = "products_table.php";
			}		
		});
}

window.onclick = function(event) {
	var x;
	for (x of modals) {
		var modal = document.getElementById(x);
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
}

function submit_edit() {
	var m_item = document.getElementById('modal_item').value;	
	var m_price = document.getElementById('modal_price').value;	
	var m_model = document.getElementById('modal_model').value;
	var m_category = document.getElementById('modal_category').value;	
	var m_is_part = document.getElementById('modal_is_part').value;
	var m_edit_inventory = document.getElementById('modal_edit_inventory').value;
	//console.log(m_item + "," + m_price + "," + m_model + "," + m_category + "," + m_is_part + "," + product_item_id + "," + m_edit_inventory);
	//return;
	$.ajax({
		url: 'ajax_products.php',
		type: 'POST',
		data: {
			edit_item: m_item,
			edit_cat_id: m_category,
			edit_price: m_price,
			edit_model: m_model,
			edit_is_part: m_is_part,
			edit_product_id: product_item_id,
			edit_inventory: m_edit_inventory,
			edit_sku: product_sku
			},
		success: function (result) {
			var result = JSON.parse(result);
			alert(result);
			window.location.href = "products_table.php";
			}		
		});
}
	


</script>
<style type="text/css" media="all">
html {
	background-color: white; 
}
	
body {
	font-family: sans-serif;
	margin-left: 2em;
	background-color: #white;
	width: 1200px;
	height: 800px;
	border: 1px solid black;
	box-shadow: 5px 5px 0 0;
	margin-left: auto;
	margin-right: auto;
	}
	
main {
	margin-top: 25px;
	overflow: auto;
	}
	
label {
	font-size:16pt;
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
	height: 525px;
}

#totals {
	margin-top: 20px;
}

table {
	width: 1150px;
	margin-left: 25px;
	table-layout: fixed;
}

#title {
	width: 500px;	
	text-align: center;
	margin-left: 350px;
}

#dashboard {
	width: 800px;
	text-align: center;
	margin-left: 200px;
}

.center {
	text-align: center;
}

.h1 {
	text-align: center;
	margin-top: 50px;
	margin-bottom: 50px;
}

#search {
	float: left;
	margin-top: 10px;
	margin-left: 25px;
	font-family: sans-serif;
	font-size: 14pt;
	width: 175px;
}

th {
	cursor: pointer;
	background-color: gainsboro;
}

thead th {
    background-repeat: no-repeat;
    background-position: right center;
}
thead th.up {
    padding-right: 20px;
    background-image: url(data:image/gif;base64,R0lGODlhFQAEAIAAACMtMP///yH5BAEAAAEALAAAAAAVAAQAAAINjI8Bya2wnINUMopZAQA7);
}
thead th.down {
    padding-right: 20px;
    background-image: url(data:image/gif;base64,R0lGODlhFQAEAIAAACMtMP///yH5BAEAAAEALAAAAAAVAAQAAAINjB+gC+jP2ptn0WskLQA7);
}

button, input[type=submit] {
	cursor: pointer;
}

@media print {
        html, body, main, div.scrollable  {
            border: 1px solid white;
            height: 99%;
            page-break-after: avoid;
            page-break-before: avoid;
		    overflow: visible;
        }
		#dashboard, #search, #store_modal, #edit_modal {
			display: none;
		}
    }
	
td {
	word-wrap: break-word;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

.modal label {
	font-size: 14pt;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto;  /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 60%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

#details3 input, select{
	width: 350px;
	font-size: 14pt;
}

#details3 {
	height: 290px;
	overflow: auto;
}
</style>
</head>
<main>
<div id='search'>
<input style="width:175px;height:17px;font-size:12pt;" oninput="w3.filterHTML('#my_table', '.item', this.value)" placeholder="Filter">
</div>
<body>
<div id="body">
<?php

$query = "select products.item_name as name, products.item_price as price, products.sku as sku, categories.category_name as category, products.model_num as model, products.is_part as is_part, products.category as cat_id, products.id as id
from products, categories
where products.category=categories.category_id
order by products.item_name;";


	

$array = mysqli_query($conn, $query);


echo '<div id="title"><h2>Products</h2></div><br>';
echo '<div class=scrollable id="table"><table id="my_table" class="tablesorter"><tr>';
echo '<thead>';
echo '<th>Item</th><th>Model</th><th style="width:8%;">Price</th><th>SKU</th><th>Category</th><th style="width:8%;">Is Part</th><th style="width:10%;">In Inventory</th><th style="width:5%;"></th></thead></tr>';
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
	$category = $row['category'];
	$cat_id = $row['cat_id'];
	$item = $row['name'];
	$product_id = $row['id'];
	$model = $row['model'];
	$price = $row['price'];
	$sku = $row['sku'];
	$is_part = $row['is_part'];
	$is_part = strtoupper($is_part);
	if ($is_part != 'YES') {
		$is_part = 'NO';
	}
	$check_query2 = "select * from inventory where sku='$sku';";
	$array2 = mysqli_query($conn, $check_query2);
	$row2 = mysqli_fetch_array($array2, MYSQLI_ASSOC);
	if (count($row2) == 0) {
		$add_type = 'new';
	}
	else {
		$add_type = 'update';
	}
	
	echo "<tr class=\"item\">";
	echo "<td>$item</td><td>$model</td><td>$price</td><td>$sku</td><td>$category</td><td style='text-align:center;'>$is_part</td><td style='text-align:center;'>";
	if (count($row2) == 0) {
		echo "NO";
	}
	else {
		echo 'YES';
	}
	echo "</td>";
	$is_part = strtolower($is_part);
	$item = base64_encode($item);
	$sku = base64_encode($sku);
	$model = base64_encode($model);
	//echo "<td><select style='width:97%;font-size:12pt;' id='$product_id' onchange='select(\"$sku\",\"$item\",\"$cat_id\",\"$price\",\"$model\",\"$product_id\",\"$add_type\",\"$is_part\")'>
	echo "<td><select style='width:97%;font-size:12pt;' id='$product_id' onchange='select(\"$sku\",\"$item\",\"$cat_id\",\"$price\",\"$model\",\"$product_id\",\"$add_type\",\"$is_part\")'>
	<option value='0'></option>";
	if ($add == 'yes') {
		echo "<option value='1'>Add to Inventory</option>";
	}
	if ($edit == 'yes') {
		echo "<option value='2'>Edit Product</option>";
	}
	echo "</select></td>";
	
	echo "</tr>";

}
echo '</table></div>';

	//choose store modal
	echo "<div id='store_modal' class='modal'>";

	echo "<div class='modal-content' style='width:35%'>
		<span class='close' onclick='hide(\"store_modal\")'>&times;</span>";
	echo "<p>";
	echo "<label><b>Item:</b>&nbsp;<span id = 'modal_item_label_add'></span></label><br>";
	echo "<label><b>SKU:</b>&nbsp;<span id = 'modal_sku_label_add'></span></label><br>";
	echo "<label><b>Model:</b>&nbsp;<span id = 'modal_model_label_add'></span></label><br>";	
	echo "<hr>";
	echo "<label>Store:</label><br>";
	echo '<select style="width:200px;font-size:16pt;" id="store">';
	$query = "SELECT store_id, store_name
				FROM stores;";
	$array = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
		echo "<option value=\"" . $row['store_id'] . "\">" . $row['store_name'] . '</option>';
	}
	echo '</select><br><br>';
	echo "<label>Quantity:</label><br>";
	echo "<input style='width:200px;font-size:16pt;'type='text' id='modal_qty' autocomplete='off'><br><br>";
	echo "</p>";
	echo "<button type='button' style='width:100px;height:30px;font-size:16pt;' onclick='get_store(\"store_modal\")'>Submit</button>";
	echo "</div></div>";
	
	
	//edit modal
	echo "<div id='edit_modal' class='modal'>";

	echo "<div class='modal-content' style='width:40%;height:450px;'>
		<span class='close' onclick='hide(\"edit_modal\")'>&times;</span>";
	echo "<p>";
	echo "<label><b>Item:</b>&nbsp;<span id = 'modal_item_label'></span></label><br>";
	echo "<label><b>SKU:</b>&nbsp;<span id = 'modal_sku_label'></span></label><br>";
	echo "<label><b>Model:</b>&nbsp;<span id = 'modal_model_label'></span></label><br>";
	echo "<hr><div id='details3'>";
	echo "<label>Item:</label><br>";
	echo "<input type='text' id='modal_item' autocomplete='off'><br><br>";
	echo "<label>Model:</label><br>";
	echo "<input type='text' id='modal_model' autocomplete='off'><br><br>";
	echo "<label>Price:</label><br>";
	echo "<input type='text' id='modal_price' autocomplete='off'><br><br>";
	echo "<label>Category:</label><br>";
	echo '<select id="modal_category">';
	$query = "SELECT category_name, category_id
				FROM categories;";
			$array = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
		echo '<option value=\'' . $row['category_id'] . '\'>' . $row['category_name'] . '</option>';
	}
	echo '</select><br><br>';
	echo "<label>Is Part:</label><br>";
	echo '<select id="modal_is_part">';
	echo '<option value="yes">Yes</option>';
	echo '<option value="no">No</option>';
	echo '</select><br><br>';
	echo "<div id='inv_edit_option'><label>Edit in Inventory:</label><br>";
	echo '<select id="modal_edit_inventory">';
	echo '<option value="no"></option>';
	echo '<option value="yes">Yes</option>';
	echo '<option value="no">No</option>';
	echo '</select><br><br></div>';
	echo "</div></p><hr>";
	echo "<button type='button' style='float:right;width:100px;font-size:14pt;margin-right:50px;margin-top:5px;' onclick='submit_edit()'>Submit</button>";
	echo "</div></div>";

?>
<br>
<br>
<div id="dashboard">
<form action="../admin_home.php">
    <input type="submit" value="Home" style="font-size:22pt;height:40px;width:250px;"/>
</form>

</div>
</body>
</div>
</main>

</html>
<?
$home_store = $_SESSION['store'];
echo "<script>";
echo "document.getElementById(\"store\").value=" . $home_store . ";";
echo "</script>";
?>