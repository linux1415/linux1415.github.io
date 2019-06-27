<?php
include '../authenticate_admin.php';
include '../database_connect.php';
include '../verify.php';

if(isset($_GET['status'])){ 
	$status = $_GET['status'];
}
?>
<!DOCTYPE html>

<html lang="en">
	
<head> 
<title>Add Product</title>
<meta charset="utf-8">
<style type="text/css" media="screen">
html {
	background-color: white; 
}
	
body {
	font-family: sans-serif;
	margin-left: 2em;
	background-color: #white;
	width: 1000px;
	height: 700px;
	border: 1px solid black;
	box-shadow: 5px 5px 0 0;
	margin-left: auto;
	margin-right: auto;
	}
	
main {
	margin-left: 75px;
	margin-top: 50px;
	}
	
label {
	font-size:16pt;
	}
	
table, th, td {
  border: 1px solid black;
  font-size: 16pt;
}

table {
	width: 800px;
	margin-left: 25px;
}

#title {
	width: 800px;	
	text-align: center;
	margin-left: 25px;
}

#dash {
	width: 800px;
	margin-left: 150px;
}

input {
    width: 100%;
    box-sizing: border-box;
	line-height: 40px;
	font-size: 30px;
}

th {
	width: 25%;
}

tr {
	line-height: 40px;
}

select {
	font-size: 16pt;
	height: 35px;
	width: 150px;
}

button {
	margin-top: 8px;
	margin-left: 10px;
	position: absolute;
}

#bottom {
	height: 90px;
}


</style>
</head>
<script>
function validate() {
	var to_print = '';
	var item = document.forms["myForm"]["item"].value;
	var price = document.forms["myForm"]["price"].value;
	var sku = document.forms["myForm"]["sku"].value;
	if ((item == "") || (price == "") || (sku == "")) {
		to_print += 'All Fields Are Required.\n';
	}
	if (isNaN(price)) {
		to_print += 'Item price must be a decimal or an integer.\n';
	}
	if (to_print != '') {
		alert(to_print);
		return false;
	}
}	

function check() {
	var sku = document.getElementById('SKU').value;
	if (sku != '') {
		window.location.href = "inventory_check.php?sku=" + sku;
	}
}
</script>
<main>
<body>
<div id="title">
<h1>Add Product to Inventory</h1>
</div>
<!--<button type="button" onclick="validate()">Click Me!</button>-->
<form name="myForm" action="inventory_handle.php" onsubmit="return validate()" method="post">
<table>
<tr>
<th>SKU</th>
<td>
<input style="width:200px;" name="sku" id="SKU" 
<?
if(isset($_SESSION['sku'])){ 
   echo " value=\"" . $_SESSION['sku'] . "\" ";
   unset($_SESSION['sku']);
} 
?>  
type="text" autocomplete="off" <? if ($status == 'readonly' || $status == 'write') {echo 'readonly';} ?>>
<button style="font-size:14pt;height:30px;width:150px;" type="button" onclick="check()">Check</button>
</td>
</tr>
<tr>
<th>Product Name</th>
<td><input name="item" id="item_sold" 
<?
if(isset($_SESSION['int_item_name'])){ 
    echo " value=\"" . $_SESSION['int_item_name'] . "\" ";
    unset($_SESSION['int_item_name']);
} 
?> 
type="text" autocomplete="off" <? if ($status == 'readonly') {echo 'readonly';} ?>></td>
</tr>
<tr>
<th>Product Price</th>
<td><input name="price" id="item_price" 
<?
if(isset($_SESSION['price'])){ 
   echo " value=\"" . $_SESSION['price'] . "\" ";
   unset($_SESSION['price']);
} 
?> 
type="text" autocomplete="off" <? if ($status == 'readonly') {echo 'readonly';} ?>></td>
</tr>
<th>Category</th>
<td>
<select style="width:200px;" id="category" name="category">
<? 
$query = "SELECT category_name, category_id
			FROM categories;";
	

//running previously created query and creating table of statistics
$array = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
	echo '<option value=\'' . $row['category_id'] . '\'>' . $row['category_name'] . '</option>';
}
?>
	<!--<option value="1">Phones</option>
	<option value="2">Game Systems</option>
	<option value="3">Laptops</option>
	<option value="4">Desktops</option>
	<option value="5">Tv's</option>
	<option value="6">Other</option>-->
</select>
</td>
</tr>
</tr>
<th>Quantity</th>
<td>
<select style="width:200px;" id="qty" name="qty">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
</select>
</td>
</tr>
</tr>
<th>Store</th>
<td>
<select style="width:200px;" id="store" name="store">
<? 
$query = "SELECT store_id, store_name
			FROM stores;";
	

//running previously created query and creating table of statistics
$array = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
	echo '<option value=\'' . $row['store_id'] . '\'>' . $row['store_name'] . '</option>';
}
?>
  <!--<option value="1">Lowes</option>
  <option value="2">Quinn</option>-->
</select>
</td>
</tr>
</table>
<br>
<div id='bottom'>
<?
if(isset($_GET['status'])){ 
echo '<input type="submit" name="submit" value="Update Inventory" style="font-size:20pt;height:40px;width:250px;margin-left:300px;margin-bottom:10px;">';
echo '<input type="button" onclick="location.href=\'inventory_add.php\';" value="Reset" style="font-size:20pt;height:40px;width:250px;margin-left:300px;margin-bottom:10px;">';
}
else {
	echo '<br>';
}
?>
</form>
<form action="../admin_home.php">
    <input type="submit" value="Home" style="font-size:22pt;height:40px;width:250px;margin-left:300px;"/>
</form>
</div>
</body>
</main>
</html>
<?
if(isset($_SESSION['cat'])){ 
	echo "<script>";
	echo "document.getElementById(\"category\").value=" . $_SESSION['cat'] . ";";
	echo "</script>";
	unset($_SESSION['cat']);
}

$store = $_SESSION['store'];
echo "<script>";
echo "document.getElementById(\"store\").value=" . $store . ";";
echo "</script>";

?>