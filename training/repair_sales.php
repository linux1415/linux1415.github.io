<?php
session_start();
include '../verify.php';

include '../database_connect.php';

?>
<!DOCTYPE html>

<html lang="en">
	
<head> 
<title>Repair Manager</title>
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

</script>
<style type="text/css" media="screen">
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
	overflow: auto;
	}
	
label {
	font-size:12pt;
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
	height: 550px;
}

#totals {
	margin-top: 20px;
}

table {
	width: 1100px;
	margin-left: 50px;
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
	margin-top: 40px;
	margin-left: 50px;
	font-family: sans-serif;
	font-size: 12pt;
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

#action {
	float: right;
	margin-top: 40px;
	margin-right: 50px;
	font-family: sans-serif;
	font-size: 12pt;
	margin-bottom: 5px;
}

select {
	font-size: 12pt;
	font-family: sans-serif;
}

a { cursor: pointer; 
  text-decoration: underline;
}

button, input[type=submit] {
	cursor: pointer;
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
  height: 500px;
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

#details {
	height: 400px;
	overflow: auto;
}

#details2 {
	height: 290px;
	overflow: auto;
}

#details2 input{
	width: 250px;
	font-size: 14pt;
}

#details3 input{
	width: 250px;
	font-size: 14pt;
}

#details3 {
	height: 290px;
	overflow: auto;
}

.no_wrap {
	overflow: auto;
	white-space: nowrap;
}

td, th {
	word-wrap: break-word;
}

.label {
	font-size: 22pt;
}

a {
	/*text-decoration: none;*/
}

#product_table {
	height: 400px;
	overflow: auto;
	width: 100%;
}

#product_table th{
	background-color: white;
}

#parts_table {
	height: 400px;
	overflow: auto;
	width: 100%;
}

#parts_table th{
	background-color: white;
}

</style>
</head>
<script>
function choice() {
	var select = document.getElementById("store");
	var chosen = select.options[select.selectedIndex].value;
	if (chosen == 'none')
		return;
	window.location.href = "repair_sales.php?store=" + chosen;
}

function store() {
	var select = document.getElementById("store");
	var store = select.options[select.selectedIndex].value;
	return store;
}

function month() {
	var select = document.getElementById("month");
	var month = select.options[select.selectedIndex].value;
	return month;
}

function year() {
	var select = document.getElementById("year");
	var year = select.options[select.selectedIndex].value;
	return year;
}

function progress() {
	var select = document.getElementById("progress");
	var progress = select.options[select.selectedIndex].value;
	return progress;
}


function build_url() {
	var chosen_store = store();
	var chosen_month = month();
	var chosen_year = year();
	var chosen_progress = progress();
	if (chosen_store == 'none') {
		alert('Please select a store.');
		return;
	}
	window.location.href = "repair_sales.php?year=" + chosen_year + "&month=" + chosen_month + "&store=" + chosen_store + "&progress=" + chosen_progress;
}

function invoice(a, b) {
	//window.location.href = "../reports/generate_invoice.php?num=" + a + "&cust=" + b;
	window.open("../reports/generate_invoice.php?num=" + a + "&cust=" + b);
}

function cust(a) {
	window.location.href = "repair_sales.php?num=" + a;
}

function details(a) {
	//window.location.href = "../reports/generate_invoice.php?num=" + a + "&cust=" + b;
	//window.open("order_details.php?num=" + a);
	window.location.href = "../sales/order_details.php?num=" + a;
}

function order_num() {
	var num = "";
	while (num == "" || num == " ") {
		num = prompt("Enter the Order Number.");
	}
	if (num != null) {
		window.location.href = 'repair_sales.php?invoice=' + num;
	}
}

var make = ""; var model = ""; var cust_name = ""; var rep_id = ""; var cust_id = ""; var order = "";
function select(a, b, c, d, e, f) {
	order = a; rep_id = b; cust_id = c; make = d; model = e; cust_name = f;
	var select = document.getElementById(b);
	var chosen = select.options[select.selectedIndex].value;
	document.getElementById(b).value = "0";
	if (chosen == '1') {
		window.open("../reports/generate_invoice.php?num=" + a + "&cust=" + b);
	}
	else if (chosen == '2') {
		window.location.href = "../sales/order_details.php?num=" + a + "&from=repairs";
	}
	else if (chosen == '3') {
		window.location.href = "returns.php?num=" + a;
	}
	else if (chosen == '4') {
		window.location.href = "refunds.php?num=" + a;
	}
	else if (chosen == '5') {
		//window.location.href = "employee_notes.php?num=" + a;
		window.location.href = "notes.php?num=" + a;
	}
	else if (chosen == '6') {
		window.location.href = "../sales/repair_details.php?num=" + b + "&from=repairs";
	}
	else if (chosen == '7') {
		window.location.href = "pay_balance.php?num=" + a;
	}
	else if (chosen == '8') {
		window.location.href = "order_payments.php?num=" + a;
	}
	else if (chosen == '9') {
		window.location.href = "customer_notes.php?num=" + a;
	}
	else if (chosen == '10') {
		window.location.href = "order_repairs.php?num=" + a;
	}
	else if (chosen == '11') {
		window.open("../reports/invoice_repairs.php?num=" + a + "&cust=" + b);
	}
	else if (chosen == '12') {
		window.open("../reports/work_order.php?num=" + a + "&cust=" + b);
	}
	else if (chosen == '13') {
		window.open("../reports/order_quote.php?num=" + a + "&cust=" + b);
	}
	else if (chosen == '14') {
		window.open("../reports/returns_receipt.php?num=" + a + "&cust=" + b);
	}
	else if (chosen == '15') {
		window.location.href = "../administrative/edit_notes.php?num=" + a;
	}
	else if (chosen == '16') {
		b = 'r_' + b;
		modal(b);
	}
	else if (chosen == '17') {
		if (c != '1') {
			b = 'c_' + b;
			modal(b);
		}
	}
	else if (chosen == '18') {
		window.location.href = "category_repair_details.php?num=" + b + "&from=repairs&order=" + a;
	}
	else if (chosen == '19') {
		window.open("../reports/service_request.php?repair=" + b + "&break=yes");
	}
	else if (chosen == '20') {
		b = 'o_' + b;
		modal(b);
	}
	else if (chosen == '21') {
		product_modal();
	}
	else if (chosen == '22') {
		b = 'parts_' + b;
		modal(b);
	}
	else {
		return;
	}
	//document.getElementById(b).selectedIndex = "0";
	document.getElementById(b).value = "0";

}

modals = ['product_modal', 'product_finalize'];

function modal(a) { 
	modals.push(a);
	var modal = document.getElementById(a);
	modal.style.display = "block";
}

function hide(a) {
	var span = document.getElementById(a);
	span.style.display = "none";
}

function modal_2(a) {
	a = 'r_' + a;
	modals.push(a);
	modal(a);
}

function modal_3(a, b) {
	if (b != '1') {
		a = 'c_' + a;
		modals.push(a);
		modal(a);
	}
}

function product_modal() { 
	var modal = document.getElementById('product_modal');
	modal.style.display = "block";
	focus();
}

function final_modal() { 
	var modal = document.getElementById('product_finalize');
	modal.style.display = "block";
}

function focus() {
	document.getElementById('search2').focus();
	document.getElementById('search2').select();
	//document.getElementById('search2').value = "";
}

function product(id, sku, item, price, model2) {
	hide('product_modal');
	document.getElementById('part_p').value = item;	
	document.getElementById('rep_id_p').value = rep_id;	
	document.getElementById('price_id_p').value = price;
	document.getElementById('sku_id_p').value = sku;	
	document.getElementById('model_id_p').value = model2;	
	document.getElementById('cust_id_p').value = cust_id;	
	document.getElementById('order_p').innerHTML = order; 
	document.getElementById('make_p').innerHTML = make; 
	document.getElementById('model_p').innerHTML = model; 
	document.getElementById('account_p').innerHTML = cust_id; 
	document.getElementById('name_p').innerHTML = cust_name; 
	final_modal();
	//console.log(id + " " + rep_id);
	//window.location.href = "order_part_from_products.php?id=" + id + "&repair_id=" + rep_id;
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

function sku_check(a){
  var value = "";
  while (value == "") {
	value = prompt('SKU:').trim();
  }
  //var value = document.getElementById(a).value;
  $.ajax({
	url: '../sales/ajax_repair_sales.php',
    type: 'POST',
    data: {sku: value},
    success: function (result) {
		var result = JSON.parse(result);
		if (result != 'allowed') {
			alert('SKU in use. Please choose another.');	
		}
		else {
			document.getElementById(a).value = value;
		}	
	}		
    });
}

function sku_gen(a){
  $.ajax({
	url: '../sales/ajax_repair_sales.php',
    type: 'POST',
    data: {get: 'get'},
    success: function (result) {
		var result = JSON.parse(result);
		document.getElementById(a).value = result;	
	}		
    });
}

function validate(a) {
	var cost = document.getElementById(a).value;
	if (isNaN(cost)) {
		alert('Cost must be numeric.');
		return false;
	}
}

function add_to_cart(a) {
	var id = a;
	 $.ajax({
	url: '../sales/ajax_repair_sales.php',
    type: 'POST',
    data: {part_id: id},
    success: function (result) {
		var result = JSON.parse(result);
		alert(result);
		}		
    });
}
	
	

</script>
<main>
<div style="height:10px;width:1200px;text-align:center;"><h2>Repairs</h2></div>
<div id='search'>
<input style="width:175px;height:17px;font-size:12pt;" oninput="w3.filterHTML('#my_table', '.item', this.value)" placeholder="Filter">
</div>
<body>
<div id='action'>
<label>Progress:&nbsp;</label>
<select id="progress" onchange="build_url()">
	<option value="0">0%</option>
	<option value="25">25%</option>
	<option value="50">50%</option>
	<option value="75">75%</option>
	<option value="100">QC</option>
	<option value="done">Complete</option>
	<option value="picked_up">Picked Up</option>
	<option value="storage">Storage</option>
	<option value="all">All</option>
</select>
<label>Month:&nbsp;</label>
<select id="month" onchange="build_url()">
<option value="default"></option>
  <option value="1">January</option>
  <option value="2">February</option>
  <option value="3">March</option>
  <option value="4">April</option>
  <option value="5">May</option>
  <option value="6">June</option>
  <option value="7">July</option>
  <option value="8">August</option>
  <option value="9">September</option>
  <option value="10">October</option>
  <option value="11">November</option>
  <option value="12">December</option>
  </select>
  <label>Year:&nbsp;</label>
  <select name="year" id="year" onchange="build_url()">
<option value="default"></option>

<? 

$query = "SELECT YEAR(date) as year FROM invoices group by year;";
	

//running previously created query and creating table of statistics
$array = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
	echo '<option value=\'' . $row['year'] . '\'>' . $row['year'] . '</option>';
}
?>

</select>
<label>Store:&nbsp;</label>
<select style="width:100px;" id="store" onchange="build_url()">
<option value="0">All</option>
<? 
$query = "SELECT store_id, store_name
			FROM stores;";
	

//running previously created query and creating table of statistics
$array = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
	echo "<option value=\"" . $row['store_id'] . "\">" . $row['store_name'] . '</option>';
}
?>
 
<option value="none"></option>
</select>
&nbsp;&nbsp;<button style="font-size:14pt;" type="button" onclick="order_num()">Search</button>

</div>
<div id="body">
<?php
$now = new DateTime();
$now->setTimezone(new DateTimeZone('America/Chicago'));  
$date_time = $now->format('Y-m-d H:i:s');
$current_date = $now->format('Y-m-d');

ini_set('display_errors', 'Off');

if(isset($_GET['store'])){ 
	$store = $_GET['store'];
	if ($store == '0') {
		$query = "select * from repair_sales where 1=1"; 
	}
	else {
		$query = "select * from repair_sales where store='$store'";
	}
	echo "<script>";
	echo "document.getElementById(\"store\").value='$store';";
	echo "</script>";
}
else {
	if (!isset($_GET['num']) && !isset($_GET['invoice'])) {
		$store = $_SESSION['store'];
		echo "<script>";
		echo "document.getElementById(\"store\").value='$store';";
		echo "</script>";
		$query = "select * from repair_sales where store='$store'";
	}
	else {
		$query = "select * from repair_sales where 1=1";
	}
}

if(isset($_GET['num'])){ 
	$c_num = $_GET['num'];
	$query = $query . " and cust_id='$c_num'";
	echo "<script>";
	echo "document.getElementById(\"store\").value='none';";
	echo "</script>";
}

if(isset($_GET['progress'])){ 
	$progress = $_GET['progress'];
	if ($progress != 'all') {
		$query = $query . " and progress='$progress'";
	}
	echo "<script>";
	echo "document.getElementById('progress').value = '$progress';";
	echo "</script>";
}
else {
	if (!isset($_GET['num']) && !isset($_GET['invoice'])) {
		$query = $query . " and progress='picked_up'";
		echo "<script>";
		echo "document.getElementById('progress').value = 'picked_up';";
		echo "</script>";
	}
	else {
		echo "<script>";
		echo "document.getElementById('progress').value = 'all';";
		echo "</script>";
	}
}

if(isset($_GET['invoice'])){ 
	$i_num = $_GET['invoice'];
	$query = $query . " and invoice_num='$i_num'";
	echo "<script>";
	echo "document.getElementById(\"store\").value='none';";
	echo "</script>";
}

$current_year = date('Y');
$current_month = date('m');

if(isset($_GET['month'])){ 
	$month = $_GET['month'];
	if ($month != 'default') {
		if(isset($_GET['year'])){ 
			$query = $query . " and MONTH(date) = '$month'";
		}
		else {
			$query = $query . " and MONTH(date) = '$month' and YEAR(date) = '$current_year'";
		}
		echo "<script>";
		echo "document.getElementById(\"month\").value=\"" . $month . "\";";
		echo "</script>";
	}
}

if(isset($_GET['year'])){ 
	$year = $_GET['year'];
	if ($year != 'default') {
		$query = $query . " and YEAR(date) = '$year'";
		echo "<script>";
		echo "document.getElementById(\"year\").value=" . $year . ";";
		echo "</script>";
	}
}

if(!isset($_GET['year']) && !isset($_GET['month']) && !isset($_GET['num']) && !isset($_GET['invoice'])) {
	$query = $query . " and MONTH(date) = '$current_month' and YEAR(date) = '$current_year'";
	echo "<script>";
	echo "document.getElementById(\"year\").value=" . $current_year . ";";
	echo "document.getElementById(\"month\").value=" . $current_month . ";";
	echo "</script>";
}

$query = $query . " order by invoice_num desc;";

$array = mysqli_query($conn, $query);


echo '<div class=scrollable id="table"><table id="my_table" class="tablesorter"><tr>';
echo '<thead>';
echo '<th>Customer</th><th>Make</th><th>Model</th><th style="width:90px;">Date Received</th><th style="width:90px;">Due Date</th><th>Device Issue</th><th>Work Needed</th><th style="width:80px;">Progress</th><th style="width:50px;"></th></thead></tr>';
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
	$num = $row['invoice_num'];
	$repair_id = $row['repair_id'];
	$repair = $row['description'];
	$cost = $row['cost'];
	$device_id = $row['device_id'];
	$cust_id = $row['cust_id'];
	$details = $row['details'];
	$date = $row['date'];
	$make = $row['make'];
	$color = $row['color'];
	$progress = $row['progress'];
	$notes = $row['notes'];
	$war_date = $row['war_date'];
	$trouble = $row['troubleshooting'];
	$tech = $row['tech_that_verified'];
	$work_needed = $row['work_needed'];
	$drop_date = $row['drop_date'];
	$due_date = $row['due_date'];
	$model = $row['model'];
	if ($cust_id == '1') {
		$cust_name = 'Guest';
	}
	else {
		$query3 = "select CONCAT(first_name, ' ', last_name) as name from customers where id_num = $cust_id;";
		$array3 = mysqli_query($conn, $query3);
		$row3 = mysqli_fetch_array($array3, MYSQLI_ASSOC);
		$cust_name = $row3['name'];
	}
	if ($progress == '100') {
		$progress = 'QC';
	}
	if ($progress == 'done') {
		$progress = 'Complete';
	}
	if ($progress == 'storage') {
		$progress = 'Storage';
	}
	if ($progress == 'picked_up') {
		$progress = 'Picked Up';
	}
	if (is_numeric($progress)) {
		$progress = $progress . '%';
	}
	$ordered_query = "select * from ordered_parts where repair_id='$repair_id';";
	$ordered_array = mysqli_query($conn, $ordered_query);
	$ordered_row = mysqli_fetch_array($ordered_array, MYSQLI_ASSOC);
	echo "<tr class=\"item\">";
	echo "<td class='no_wrap'><a onclick='modal_3(\"$repair_id\", \"$cust_id\")'>$cust_name</a></td><td class='no_wrap'><a onclick='modal_2(\"$repair_id\")'>$make</a></td><td class='no_wrap'>$model</td><td>$drop_date</td><td>$due_date</td><td>$details</td><td>$work_needed</td><td class='no_wrap' style='text-align:center;'>$progress</td><td style='text-align:center;'>";
	echo "<select style='width:97%;' id='$repair_id' onchange='select(\"$num\", \"$repair_id\", \"$cust_id\", \"$make\", \"$model\", \"$cust_name\")'>
	<option value='0'></option>
	<option value='16'>Repair Details</option>
	<option value='2'>Order Details</option>
	<option value='17'>Customer Details</option>
	<option value='19'>Service Request</option>
	<option value='6'>Edit General Details</option>
	<option value='18'>Edit Category Details</option>";
	if (count($ordered_row) > 0) {
		echo "<option value='22'>On Order Parts</option>";
	}
	echo "<option value='20'>Order New Part</option>
	<option value='21'>Order Part From Products</option>
	</select></td></tr>";
}
//<button type='button' onclick='invoice(\"$num\", \"$cust_id\")'>Print Invoice</button>
echo '</table></div>';

//modal 1
$array2 = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($array2, MYSQLI_ASSOC)){
	$num = $row['invoice_num'];
	$cust_id = $row['cust_id'];
	$repair_id = $row['repair_id'];
	$repair = $row['description'];
	$cost = $row['cost'];
	$sku = $row['sku'];
	$device_id = $row['device_id'];
	$cust_id = $row['cust_id'];
	$details = $row['details'];
	$date = $row['date'];
	$color = $row['color'];
	$notes = $row['notes'];
	$make = $row['make'];
	$war_date = $row['war_date'];
	$trouble = $row['troubleshooting'];
	$tech = $row['tech_that_verified'];
	$work_needed = $row['work_needed'];
	$drop_date = $row['drop_date'];
	$comp_date = $row['completed_date'];
	$due_date = $row['due_date'];
	$model = $row['model'];
	echo "<div id='r_$repair_id' class='modal'>";

	echo "<div class='modal-content'>
		<span class='close' onclick='hide(\"r_$repair_id\")'>&times;</span>";
	echo "<p>";
	echo "<label><b>Order:</b>&nbsp;$num</label><br>";
	echo "<label><b>Date:</b>&nbsp;$date</label><br>";
	echo "<label><b>Account:</b>&nbsp;$cust_id</label><br>";
	echo "<hr><div id='details'>";
	echo "<label><b>Repair:</b><br>$repair</label><br><br>";
	if (strlen($model) > 0) {
		echo "<label><b>Model:</b><br>$model</label><br><br>";
	}
	if (strlen($make) > 0) {
		echo "<label><b>Make:</b><br>$make</label><br><br>";
	}
	if (strlen($device_id) > 0) {
		echo "<label><b>Device ID:</b><br>$device_id</label><br><br>";
	}
	if (strlen($color) > 0) {
		echo "<label><b>Color:</b><br>$color</label><br><br>";
	}
	echo "<label><b>SKU:</b><br>$sku</label><br><br>";
	echo "<label><b>Cost:</b><br>$cost</label><br><br>";
	if ($drop_date != '0000-00-00') {
		echo "<label><b>Drop Off Date:</b><br>$drop_date</label><br><br>";
	}
	if ($due_date != '0000-00-00') {
		echo "<label><b>Due Date:</b><br>$due_date</label><br><br>";
	}
	if ($comp_date != '0000-00-00') {
		echo "<label><b>Completed Date:</b><br>$comp_date</label><br><br>";
	}
	if ($war_date != '0000-00-00') {
		echo "<label><b>Warranty Date:</b><br>$war_date</label><br><br>";
	}
	if (strlen($trouble) > 0) {
		echo "<label><b>Troubleshooting:</b><br>$trouble</label><br><br>";
	}
	if (strlen($tech) > 0) {
		echo "<label><b>Tech That Verified:</b><br>$tech</label><br><br>";
	}
	if (strlen($details) > 0) {
		echo "<label><b>Device Issue:</b><br>$details</label><br><br>";
	}
	if (strlen($work_needed) > 0) {
		echo "<label><b>Work Needed:</b><br>$work_needed</label><br><br>";
	}
	if (strlen($notes) > 0) {
		echo "<label><b>Notes:</b><br>$notes</label><br><br>";
	}
	echo "</div></p></div></div>";	
	
	
	//modal 2
	echo "<div id='c_$repair_id' class='modal'>";

	echo "<div class='modal-content' style='width:30%;height:30%;overflow:auto;'>
		<span class='close' onclick='hide(\"c_$repair_id\")'>&times;</span>";
	echo "<p>";
			$query3 = "select CONCAT(first_name, ' ', last_name) as name, first_name, last_name, phone, credit, city, email, zip, date(join_date)as date, id_num from customers where id_num = $cust_id;";
			$array3 = mysqli_query($conn, $query3);
			$row3 = mysqli_fetch_array($array3, MYSQLI_ASSOC);
			$fname = $row3['first_name'];
			$lname = $row3['last_name'];
			$phone = $row3['phone'];
			$name = $row3['name'];
			$credit = $row3['credit'];
			$city = $row3['city'];
			$email = $row3['email'];
			$zip = $row3['zip'];
			$join = $row3['date'];
			$account = $row3['id_num'];
	echo "<label style='font-size:16pt;'><b>Account:</b>&nbsp;$account</label><br>";
	echo "<label style='font-size:16pt;'><b>Phone:</b>&nbsp;$phone</label><br>";
	if (strlen($email) > 0) {
		echo "<label style='font-size:16pt;'><b>Email:</b>&nbsp;$email</label><br>";
	}
	if (strlen($city) > 0) {
		echo "<label style='font-size:16pt;'><b>City:</b>&nbsp;$city</label><br>";
	}
	if (strlen($zip) > 0) {
		echo "<label style='font-size:16pt;'><b>Zip:</b>&nbsp;$zip</label><br>";
	}
	echo "<br><label style='font-size:16pt;text-decoration:underline;'><a onclick='cust(\"$account\")'>See all repairs for this account</a></label><br>";
	echo "</p></div></div>";
	
	
	//modal 3
	echo "<div id='o_$repair_id' class='modal'>";

	echo "<div class='modal-content' style='width:40%'>
		<span class='close' onclick='hide(\"o_$repair_id\")'>&times;</span>";
	echo "<form action='order_parts.php'  onsubmit='return validate(\"cost_$repair_id\")' method='post'>";
	echo "<input type='text' name='rep_id' value='$repair_id' style='display:none;'>";
	echo "<input type='text' name='cust_id' value='$cust_id' style='display:none;'>";
	echo "<p>";
	echo "<label><b>Order:</b>&nbsp;$num</label><br>";
	echo "<label><b>Make:</b>&nbsp;$make</label><br>";
	echo "<label><b>Model:</b>&nbsp;$model</label><br>";
	echo "<label><b>Account:</b>&nbsp;$account</label><br>";
	echo "<label><b>Customer:</b>&nbsp;$name</label><br>";
	echo "<hr><div id='details2'>";
	echo "<label>Part:</label><br>";
	echo "<input type='text' autocomplete='off' name='part' required><br><br>";
	echo "<label>Part Color:</label><br>";
	echo "<input type='text' autocomplete='off' name='part_color'><br><br>";
	echo "<label>Part Model:</label><br>";
	echo "<input type='text' value='$model' autocomplete='off' name='part_model'><br><br>";
	echo "<label>SKU:&nbsp;<a style='font-size:10pt;text-decoration:underline;' onclick='sku_check(\"sku_$repair_id\")'>Create</a>&nbsp;<a style='font-size:10pt;text-decoration:underline;' onclick='sku_gen(\"sku_$repair_id\")'>Generate</a></label><br>";
	echo "<input type='text' autocomplete='off' id='sku_$repair_id' name='new_sku' style='caret-color: transparent !important;' onkeydown='return false;' required><br><br>";
	echo "<label>Cost:</label><br>";
	echo "<input type='text' autocomplete='off' id='cost_$repair_id' name='cost'><br><br>";
	echo "<label>Order Date:</label><br>";
	echo "<input type='date' value='$current_date' name='order_date'><br><br>";
	echo "<label>Due Date:</label><br>";
	echo "<input type='date' name='due_date'><br><br>";
	echo "<label>Expectation Date:</label><br>";
	echo "<input type='date' name='exp_date'><br><br>";
	echo "<label>Ordered From:</label><br>";
	echo '<textarea rows="5" name="order_from" autocomplete="off" style="width:250px;"></textarea>';
	echo "</div></p><hr>";
	echo '<input style="float:right;width:200px;font-size:14pt;margin-right:50px;margin-top:5px;" type="Submit" value="Place Part On Order"></input>';
	echo "</form></div></div>";
	
	//on order parts modal
	echo "<div id='parts_$repair_id' class='modal'>";

	  echo "<div class='modal-content' style='width:80%;'>
		<span class='close' onclick='hide(\"parts_$repair_id\")'>&times;</span>";
	$query = "select * from ordered_parts where repair_id='$repair_id' order by order_date desc;";

	$array5 = mysqli_query($conn, $query);
	echo '<div id="parts_table"><center><table style="width:90%;margin-left:0px;" class="tablesorter"><tr>';
	echo '<thead>';
	echo '<th>Part</th><th style="width:10%;">Color</th><th style="width:15%;">SKU</th><th style="width:8%;">Price</th><th style="width:10%;">Order Date</th><th style="width:10%;">Due Date</th><th style="width:10%;">Expectation Date</th><th style="width:12%"></th></thead></tr>';
	while ($row5 = mysqli_fetch_array($array5, MYSQLI_ASSOC)){
		$part = $row5['part'];
		$part_id = $row5['id'];
		$part_color = $row5['part_color'];
		$o_date = $row5['order_date'];
		$d_date = $row5['due_date'];
		$exp_date = $row5['exp_date'];
		$part_sku = $row5['sku'];
		$checkout = $row5['checked_out'];
		$part_price = $row5['price'];
		echo "<tr class=\"item\">";
		echo "<td>$part</td><td>$part_color</td><td>$part_sku</td><td>$part_price</td><td>$o_date</td><td>$d_date</td><td>$exp_date</td><td style='text-align:center;'>";
		if ($checkout == 'yes') {
			echo 'Part Purchased';
		}
		else {
			echo "<button type='button' onclick='add_to_cart(\"$part_id\")'>Add to Cart</button>";
		}
		
		echo "</td></tr>";

	}
	echo '</table></center></div>';
	echo "</div></div>";
	
}


//modal 5
	echo "<div id='product_modal' class='modal'>";

	echo "<div class='modal-content'>
		<span class='close' onclick='hide(\"product_modal\")'>&times;</span>";
	echo '<center><input style="width:200px;height:17px;font-size:12pt;" id="search2" oninput="w3.filterHTML(\'#p_table\', \'.item\', this.value)" placeholder="Filter"></center>';
	echo "<p>";
	$query = "select * from products where is_part = 'yes' order by item_name;";

	$array4 = mysqli_query($conn, $query);
	echo '<div id="product_table"><center><table style="width:90%;margin-left:0px;" id="p_table" class="tablesorter"><tr>';
	echo '<thead>';
	echo '<th>Item</th><th>Model</th><th>SKU</th><th>Price</th><th></th></thead></tr>';
	while ($row4 = mysqli_fetch_array($array4, MYSQLI_ASSOC)){
		$item = $row4['item_name'];
		$sku = $row4['sku'];
		$id = $row4['id'];
		$price = $row4['item_price'];
		$model = $row4['model_num'];
		echo "<tr class=\"item\">";
		echo "<td>$item</td><td>$model</td><td>$sku</td><td>$price</td><td style='text-align:center;'><button type='button' onclick='product(\"$id\", \"$sku\", \"$item\", \"$price\", \"$model\")'>Order</button></td></tr>";

	}
	echo '</table></center></div>';
	echo "</p></div></div>";	
	
	
//modal 6
	echo "<div id='product_finalize' class='modal'>";

	echo "<div class='modal-content' style='width:40%'>
		<span class='close' onclick='hide(\"product_finalize\")'>&times;</span>";
	echo "<form action='order_parts_from_products.php' method='post'>";
	echo "<input type='text' name='rep_id_p' id='rep_id_p' style='display:none;'>";
	echo "<input type='text' name='cust_id_p' id='cust_id_p' style='display:none;'>";
	echo "<input type='text' name='sku_id_p' id='sku_id_p' style='display:none;'>";
	echo "<input type='text' name='price_id_p' id='price_id_p' style='display:none;'>";
	echo "<input type='text' name='model_id_p' id='model_id_p' style='display:none;'>";
	echo "<p>";
	echo "<label><b>Order:</b>&nbsp;<span id = 'order_p'></span></label><br>";
	echo "<label><b>Make:</b>&nbsp;<span id = 'make_p'></span></label><br>";
	echo "<label><b>Model:</b>&nbsp;<span id = 'model_p'></span></label><br>";
	echo "<label><b>Account:</b>&nbsp;<span id = 'account_p'></span></label><br>";
	echo "<label><b>Customer:</b>&nbsp;<span id = 'name_p'></span></label><br>";
	echo "<hr><div id='details3'>";
	echo "<label>Part:</label><br>";
	echo "<input type='text' id='part_p' autocomplete='off' name='part' required><br><br>";
	echo "<label>Part Color:</label><br>";
	echo "<input type='text' autocomplete='off' name='part_color'><br><br>";
	echo "<label>Order Date:</label><br>";
	echo "<input type='date' value='$current_date' name='order_date'><br><br>";
	echo "<label>Due Date:</label><br>";
	echo "<input type='date' name='due_date'><br><br>";
	echo "<label>Expectation Date:</label><br>";
	echo "<input type='date' name='exp_date'><br><br>";
	echo "<label>Ordered From:</label><br>";
	echo '<textarea rows="5" name="order_from" autocomplete="off" style="width:250px;"></textarea>';
	echo "</div></p><hr>";
	echo '<input style="float:right;width:200px;font-size:14pt;margin-right:50px;margin-top:5px;" type="Submit" value="Place Part On Order"></input>';
	echo "</form></div></div>";

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