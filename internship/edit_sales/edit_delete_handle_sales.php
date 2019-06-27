<?php
session_start();
if (!isset($_SESSION['user']))
{
    die(include 'index.html');
}
?>
<!DOCTYPE html>

<html lang="en">
	
<head> 
<title>Commission Tracker</title>
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
	height: 400px;
}

table {
	width: 950px;
	margin-left: 25px;
	table-layout: fixed;
}

#title {
	width: 500px;	
	text-align: center;
	margin-left: 250px;
}

#dashboard {
	width: 800px;
	text-align: center;
	margin-left: 100px;
}

input {
	width: 102px;
	height: 21px;
	font-size: 12pt;
}

#action {
	width: 1000px;
	text-align: center;
	font-size: 14pt;
	margin-bottom: 5px;
}

select {
	font-size: 14pt;
}

input[type=checkbox] {
	height: 20px;
}

#errors {
	width: 800px;
	margin-left: 100px;
	table-layout: fixed;
}

#err_table {
	height: 100px;
	overflow: auto;
	text-align: center;
}

#h2 {
	width: 1000px;
	text-align: center;
}

input[type=button] {
  appearance:push-button; /* expected from UA defaults */
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
	background-color: gainsboro;
}
	
</style>
</head>
<script>
function choice() {
	var id = document.getElementById("options");
	var chosen = id.options[id.selectedIndex].value;
	if (chosen == "delete") {
	main_button.innerHTML = '<input type="submit" value="Delete" style="font-size:22pt;height:40px;width:250px;"/>';
	var rows = document.getElementById("mytable").rows.length;
	var row_len = 9;
	num = 1;
	while (num < rows) {
		num2 = 1;
		while (num2 < row_len) {
			var value = document.getElementById("mytable").rows[num].cells[num2].innerHTML;
			var array = value.split('"');
			//console.log(array);
			if (num2 == 1) {
				mytable.rows[num].cells[num2].innerHTML = num;
				mytable.rows[num].cells[num2].style.borderColor = "black";

			}
			else {
				mytable.rows[num].cells[num2].innerHTML = array[3];
				mytable.rows[num].cells[num2].style.borderColor = "black";
			}
			num2++;
		}
		num ++;
	}
	span_errors.innerHTML = "";
	}
	if (chosen == "edit") {
		location.reload();
	}

}

function validate() {
	var to_print = "";
	var id = document.getElementById("options");
	var chosen = id.options[id.selectedIndex].value;
	if (chosen == "delete") {
		return true;
	}
	var index = 0;
	var rows = document.getElementById("mytable").rows.length;
	var row_len = 10;
	num = 1;
	while (num < rows) {
		num2 = 1;
		while (num2 < row_len) {
			if (num2 != 1) {
				var value = document.getElementById("mytable").rows[num].cells[num2].children[0].value;
				value = value.trim();
				index += 1;
				if (index == 1) { //date check
					var date = value.split("-");
					if (date.length == 3) {
						if ((!Number.isInteger(Number(date[0])) || date[0].length != 4) || (!Number.isInteger(Number(date[1])) || date[1].length != 2) || (!Number.isInteger(Number(date[2])) || date[2].length != 2)) {
							mytable.rows[num].cells[num2].style.borderColor = "red";
							to_print += 'Date is not valid.';
						}
						else {
							mytable.rows[num].cells[num2].style.borderColor = "black";
						}
					}
					else {
						mytable.rows[num].cells[num2].style.borderColor = "red";
						to_print += 'Date is not valid.';
					}
				}
				if (index == 2) { //item check
					if (value == "") {
						to_print += 'Item is required field.';
						mytable.rows[num].cells[num2].style.borderColor = "red";
					}
					else {
						mytable.rows[num].cells[num2].style.borderColor = "black";
					}
				}
				if (index == 3) { //item price check
					if (isNaN(value) || value == "") {
						to_print += 'Item price must a decimal number.';
						mytable.rows[num].cells[num2].style.borderColor = "red";
					}
					else {
						mytable.rows[num].cells[num2].style.borderColor = "black";
					}
				}
				if (index == 4) { //invoice number check
					if (!Number.isInteger(Number(value)) || value == "") {
						to_print += 'Invoice must be numbers only.';
						mytable.rows[num].cells[num2].style.borderColor = "red";
					}
					else {
						mytable.rows[num].cells[num2].style.borderColor = "black";
					}
				}
				if (index == 5) { //sku check
					if (value == "") {
						to_print += 'SKU is a required field.';
						mytable.rows[num].cells[num2].style.borderColor = "red";
					}
					else {
						mytable.rows[num].cells[num2].style.borderColor = "black";
					}
				}
				if (index == 6) { //commission check
					if (isNaN(value)) {
						to_print += 'Commission must be a decimal number.';
						mytable.rows[num].cells[num2].style.borderColor = "red";
					}
					else {
						mytable.rows[num].cells[num2].style.borderColor = "black";
					}
				}
				if (index == 7) { //chargeback check
					if (isNaN(value)) {
						to_print += 'Chargeback must be a decimal number.';
						mytable.rows[num].cells[num2].style.borderColor = "red";
					}
					else {
						mytable.rows[num].cells[num2].style.borderColor = "black";
					}
				}
			}
			num2++;
		}
		index = 0;
		num ++;
	}
	if (to_print != "") {
		return false;
	}

}

</script>
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script src="../javascript/jquery-3.3.1.min.js"></script>
<script src="../javascript/jquery.tablesorter.min.js"></script>
<body>
<main>
<div id='search'>
<input oninput="w3.filterHTML('#mytable', '.item', this.value)" placeholder="Search..">
</div>
<div id="title"><h2>Sales Edit</h2></div>
<form action="edit_delete_process_sales.php" method="post" onsubmit="return validate()">
<div id='action'>
<label>Action:&nbsp;</label>
<select name="option" id="options" onchange="choice()" style="width:100px;">
<option value="edit">Edit</option>
<option value="delete">Delete</option>
</select>
</div>
<div id="body">
<?php

ini_set('display_errors', 'Off');

include '../database_connect.php';

//get variables from form
$month = $_REQUEST['month'];
$day = $_REQUEST['day'];
$year = $_REQUEST['year'];
$skuNum = $_REQUEST['sku'];
$invoiceNum = $_REQUEST['invoice'];
$user = $_REQUEST['emp'];
$store = $_REQUEST['store'];


//grabbing session variable and the current date
//$user = $_SESSION['user'];
$date = date('Y-m-d');

//incomplete query to be executed
if ($user == 'all') {
	$partial_q = "SELECT sales.date as DATE, employee_info.first_name as first, employee_info.last_name as last, sales.item as item, sales.item_price as price, sales.sku as SKU, sales.commission as commission, sales.chargeback as chargeback, sales.invoice_num as invoice_num, sales.sale_id as id, categories.category_id as category
			FROM employee_info, sales, categories
			WHERE employee_info.id_num=sales.user_id
			and sales.category=categories.category_id";
}
else {
$partial_q = "SELECT sales.date as DATE, employee_info.first_name as first, employee_info.last_name as last, sales.item as item, sales.item_price as price, sales.sku as SKU, sales.commission as commission, sales.chargeback as chargeback, sales.invoice_num as invoice_num, sales.sale_id as id, categories.category_id as category
			FROM employee_info, sales, categories
			WHERE employee_info.id_num=$user
			and sales.user_id=$user
			and sales.category=categories.category_id";
}

if ($store != 'all') {
	$partial_q = $partial_q . " and sales.store='$store'";
	}
			
$order = " ORDER BY DATE;";

//adding onto query based on user input
if(isset($month)) {
if ($month == "default" and $day == "default" and $year == "default") {
	$query = $partial_q . " and week_of_year=WEEKOFYEAR('$date')" . $order;
}
elseif ($month != "default" and $day == "default" and $year == "default") {
	$query = $partial_q . " and month='$month' and year=YEAR('$date')" . $order;
}
elseif ($month != "default" and $day != "default" and $year == "default") {
	$query = $partial_q . " and month='$month' and day='$day' and year=YEAR('$date')" . $order;
}
elseif ($month != "default" and $day != "default" and $year != "default") {
	$query = $partial_q . " and month='$month' and day='$day' and year='$year'" . $order;
}
elseif ($month == "default" and $day == "default" and $year != "default") {
	$query = $partial_q . " and year='$year'" . $order;
}
elseif ($month != "default" and $day == "default" and $year != "default") {
	$query = $partial_q . " and month='$month' and year='$year'" . $order;
}
else {
	die("There is an error");
}
}

if(isset($skuNum)) {
	$query = $partial_q . " and SKU='$skuNum'" . $order;
}

if(isset($invoiceNum)) {
	$query = $partial_q . " and invoice_num='$invoiceNum'" . $order;
}


//running previously created query and creating table of statistics
$array = mysqli_query($conn, $query);
$count = 0;
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
	if ($count == 0) {
		echo '<div class=scrollable id="table"><table id="mytable"><tr><th style="width:52px;">Select</th><th>Date<br>(yyyy-mm-dd)</th><th>Item</th><th>Item Price</th><th>Invoice Number</th><th>SKU</th><th>Commission</th><th>Chargeback</th><th>Category</th></tr>';
	}
	$count ++;
	$sale = $row['id'];
	$date = $row['DATE'];
	$item = $row['item'];
	$price = $row['price'];
	$sku = $row['SKU'];
	$invoice = $row['invoice_num'];
	$commission = $row['commission'];
	$chargeback = $row['chargeback'];
	$category = $row['category'];
	$sale_items = $sale;	
	echo "<tr class=\"item\"><td><input style='width:50px;' type='checkbox' name='ids[]' value='$sale'></td>";
	//echo "<td style='text-align:center;'>$count</td>";
	echo "<td style='display:none;'><input name='sales[]' value='$sale' type='text' style='display:none;'></td>";
	echo "<td><input name='sales[]' value='$date' type='text'></td><td><input name='sales[]' value='$item' type='text'></td><td><input name='sales[]' value='$price' type='text'></td><td><input name='sales[]' value='$invoice' type='text'></td><td><input name='sales[]' value='$sku' type='text'></td><td><input name='sales[]' value='$commission' type='text'><td><input name='sales[]' value='$chargeback' type='text'></td>";
	echo "<td><select style=\"width:106px;height:27px;font-size:12pt;\" name=\"sales[]\">";

$query2 = "SELECT category_name, category_id
			FROM categories;";
	

//running previously created query and creating table of statistics
$array2 = mysqli_query($conn, $query2);
while ($row2 = mysqli_fetch_array($array2, MYSQLI_ASSOC)){
	if ($row2['category_id'] == $category) {
		echo '<option value=\'' . $row2['category_id'] . '\' selected>' . $row2['category_name'] . '</option>';
	}
	else {
		echo '<option value=\'' . $row2['category_id'] . '\'>' . $row2['category_name'] . '</option>';
	}
}
	
echo "</select>";
echo "</tr>";
}
echo '</table></div>';
?>
<br>
<div id="dashboard">
	<span id='main_button'><input type="submit" value="Submit" style="font-size:22pt;height:40px;width:250px;"/></span>
</form><span id='buttons1'><br><br></span>
<form action="edit_delete_sales.php">
    <input type="submit" value="Back" style="font-size:22pt;height:40px;width:250px;"/>
</form><span id='buttons2'><br></span>
<form action="../admin_home.php">
    <input type="submit" value="Home" style="font-size:22pt;height:40px;width:250px;"/>
</form>

</div>
</div>
</main>
</body>

</html>