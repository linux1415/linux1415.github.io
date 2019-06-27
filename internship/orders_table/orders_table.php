<?php
session_start();
include '../verify.php';

if (!isset($_SESSION['user']))
{
    die(include 'index.html');
}
include '../database_connect.php';
unset($_SESSION['refund_array']);
unset($_SESSION['refund_invoice']);
unset($_SESSION['return_array']);
unset($_SESSION['invoice_r']);
unset($_SESSION['refund_amount']);
?>
<!DOCTYPE html>

<html lang="en">
	
<head> 
<title>Commission Tracker</title>
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
	height: 600px;
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

#actio {
	width: 1000px;
	text-align: center;
	font-size: 14pt;
	margin-bottom: 5px;
}

#action {
	float: right;
	margin-top: 40px;
	margin-right: 50px;
	font-family: sans-serif;
	font-size: 14pt;
}

select {
	font-size: 14pt;
	font-family: sans-serif;
}

a { cursor: pointer; 
  text-decoration: underline;
}

</style>
</head>
<script>
function choice() {
	var select = document.getElementById("store");
	var chosen = select.options[select.selectedIndex].value;
	if (chosen == 'none')
		return;
	window.location.href = "orders_table.php?store=" + chosen;
}

function invoice(a, b) {
	//window.location.href = "../reports/generate_invoice.php?num=" + a + "&cust=" + b;
	window.open("../reports/generate_invoice.php?num=" + a + "&cust=" + b);
}

function cust(a) {
	window.location.href = "../sales/orders_table.php?num=" + a;
}

function details(a) {
	//window.location.href = "../reports/generate_invoice.php?num=" + a + "&cust=" + b;
	//window.open("order_details.php?num=" + a);
	window.location.href = "order_details.php?num=" + a;
}

function order_num() {
	var num = prompt("Enter the Order Number.");
	if (num == "") {
		return;
	}
	window.location.href = 'orders_table.php?invoice=' + num;
}

function select(a, b) {
	var select = document.getElementById(a);
	var chosen = select.options[select.selectedIndex].value;
	if (chosen == '1') {
		window.open("../reports/generate_invoice.php?num=" + a + "&cust=" + b);
	}
	else if (chosen == '2') {
		window.location.href = "order_details.php?num=" + a;
	}
	else if (chosen == '3') {
		window.location.href = "returns.php?num=" + a;
	}
	else if (chosen == '4') {
		window.location.href = "refunds.php?num=" + a;
	}
	else {
		return;
	}
	document.getElementById(a).selectedIndex = "0";

}

</script>
<main>
<div id='search'>
<input oninput="w3.filterHTML('#my_table', '.item', this.value)" placeholder="Filter">
</div>
<body>
<div id='action'>
<label>Store:&nbsp;</label>
<select style="width:100px;" id="store" onchange="choice()">
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
  <!--<option value="1">Lowes</option>
  <option value="2">Quinn</option>-->
<option value="none"></option>
</select>
&nbsp;&nbsp;<button style="font-size:14pt;" type="button" onclick="order_num()">Search</button>

</div>
<div id="body">
<?php

ini_set('display_errors', 'Off');

if(isset($_GET['store'])){ 
	$store = $_GET['store'];
	if ($store == '0') {
		$query = "select invoices.invoice_num as num, invoices.total as total, invoices.balance as balance, invoices.date as date, 
		concat(employee_info.first_name, ' ', employee_info.last_name) as name, concat(customers.first_name, ' ', customers.last_name) as cust,
		invoices.cust_id as cust_id, customers.phone as phone
		from employee_info, customers, invoices
		where customers.id_num=invoices.cust_id
		and employee_info.id_num=invoices.employee_id"; 
	}
	else {
		$query = "select invoices.invoice_num as num, invoices.total as total, invoices.balance as balance, invoices.date as date, 
		concat(employee_info.first_name, ' ', employee_info.last_name) as name, concat(customers.first_name, ' ', customers.last_name) as cust,
		invoices.cust_id as cust_id, customers.phone as phone
		from employee_info, customers, invoices
		where customers.id_num=invoices.cust_id
		and employee_info.id_num=invoices.employee_id
		and invoices.store='$store'";
	}
}
else {
	$query = "select invoices.invoice_num as num, invoices.total as total, invoices.balance as balance, invoices.date as date, 
		concat(employee_info.first_name, ' ', employee_info.last_name) as name, concat(customers.first_name, ' ', customers.last_name) as cust,
		invoices.cust_id as cust_id, customers.phone as phone
		from employee_info, customers, invoices
		where customers.id_num=invoices.cust_id
		and employee_info.id_num=invoices.employee_id";
}

if(isset($_GET['num'])){ 
	$c_num = $_GET['num'];
	$query = $query . " and customers.id_num='$c_num'";
	echo "<script>";
	echo "document.getElementById(\"store\").value='none';";
	echo "</script>";
}

if(isset($_GET['invoice'])){ 
	$i_num = $_GET['invoice'];
	$query = $query . " and invoices.invoice_num='$i_num'";
	echo "<script>";
	echo "document.getElementById(\"store\").value='none';";
	echo "</script>";
}

$query = $query . " order by date desc;";

//echo $query;
//die();



$array = mysqli_query($conn, $query);


echo '<div id="title"><h2>Orders</h2></div><br>';
echo '<div class=scrollable id="table"><table id="my_table" class="tablesorter"><tr>';
echo '<thead>';
echo '<th style="width:75px;">Order</th><th>Customer</th><th>Customer Phone</th><th>Employee</th><th style="width:100px;">Total</th><th style="width:100px;">Balance</th><th>Date</th><th style="width:100px;">Action</th></thead></tr>';
while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
	$num = $row['num'];
	$total = $row['total'];
	$emp = $row['name'];
	$cust = $row['cust'];
	$cust_id = $row['cust_id'];
	$balance = $row['balance'];
	$date = $row['date'];
	$phone = $row['phone'];
	echo "<tr class=\"item\">";
	echo "<td style='width:75px;'><a onclick='details(\"$num\")'>$num</a></td><td><a onclick='cust(\"$cust_id\")'>$cust</a></td><td>$phone</td><td>$emp</td><td style='width:100px;'>$total</td><td style='width:100px;'>$balance</td><td>$date</td><td style='text-align:center;'>";
	echo "<select id='$num' onchange='select(\"$num\", \"$cust_id\")'>
	<option value='0'></option>
	<option value='1'>Invoice</option>
	<option value='2'>Details</option>
	<option value='3'>Returns</option>
	<option value='4'>Refunds</option></select></td></tr>";
}
//<button type='button' onclick='invoice(\"$num\", \"$cust_id\")'>Print Invoice</button>
echo '</table></div>';

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
if(isset($_GET['store'])){ 
	echo "<script>";
	echo "document.getElementById(\"store\").selectedIndex=" . $store . ";";
	echo "</script>";
}
?>