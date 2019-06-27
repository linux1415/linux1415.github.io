<?php
session_start();
include '../verify.php';
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
  font-size: 10pt;
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
	font-size: 10pt;
	width: 90px;
	height: 27px;
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

select:hover {display: block;}

	
</style>
</head>
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script src="../javascript/jquery-3.3.1.min.js"></script>
<script src="../javascript/jquery.tablesorter.min.js"></script>
<body>
<main>
<div id="title"><h2>Permissions: Writable Features</h2></div>
<form action="permissions_handle.php" method="post">

<div id="body">
<div class="scrollable" id="table"><table id="mytable"><tr><th>Employee</th><th>Add Sale</th><th>Edit Sales</th><th>Add<br>Inventory</th><th>Edit<br>Inventory</th><th>Add<br>Product</th><th>Edit<br>Product</th><th>Add<br>Commission</th><th>Add Repair<br>Option</th><th>Add Repair<br>Sale</th></tr>

<?php

ini_set('display_errors', 'Off');

include '../database_connect.php';


$query = "select permissions.user_id as id, CONCAT(left(employee_info.first_name, 1), '. ', employee_info.last_name) as name, permissions.add_sale, permissions.edit_sale, permissions.add_inventory, permissions.edit_inventory, permissions.add_product, permissions.edit_product, permissions.add_commission, permissions.add_repair_option, permissions.add_repair_sale
from permissions, employee_info
where employee_info.id_num=permissions.user_id;";

$array = mysqli_query($conn, $query);
$count = 0;
while ($row = mysqli_fetch_array($array, MYSQLI_NUM)){
	echo "<tr class=\"item\">";
	$count = 0;
	foreach ($row as $value) {
		if ($count == 0) {
			echo "<td style='display:none;'><input name='sales[]' value='$value' type='text' style='display:none;'></td>";
			$count += 1;
			continue;
		}
		if ($count == 1) {
			echo "<td>$value</td>";
			$count += 1;
			continue;
		}
		echo "<td><select name=\"sales[]\">";
		if ($count == 2) { //add sale
			if ($value == 'full_access') {
				echo "<option value='full_access' selected>Full Access</option>";
				echo "<option value='limited_access'>Limited Access</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			elseif ($value == 'limited_access') {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access' selected>Limited Access</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			else {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access'>Limited Access</option>";
				echo "<option value='no' selected>Unauthorized</option>";
			}
			$count += 1;
			continue;
		}
		if ($count == 3) { //edit sales
			if ($value == 'full_access') {
				echo "<option value='full_access' selected>Full Access</option>";
				echo "<option value='limited_access_no_del'>Individual Access: Edit Only</option>";
				echo "<option value='limited_access'>Individual Access: Edit and Delete</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			elseif ($value == 'limited_access_no_del') {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access_no_del' selected>Individual Access: Edit Only</option>";
				echo "<option value='limited_access'>Individual Access: Edit and Delete</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			elseif ($value == 'limited_access') {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access_no_del'>Individual Access: Edit Only</option>";
				echo "<option value='limited_access' selected>Individual Access: Edit and Delete</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			else {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access_no_del'>Individual Access: Edit Only</option>";
				echo "<option value='limited_access'>Individual Access: Edit and Delete</option>";
				echo "<option value='no' selected>Unauthorized</option>";
			}
			$count += 1;
			continue;
		}
		if ($count == 4) { //add inventory
			if ($value == 'full_access') {
				echo "<option value='full_access' selected>Full Access</option>";
				echo "<option value='limited_access'>Limited Access: Associated Store Only</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			elseif ($value == 'limited_access') {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access' selected>Limited Access: Associated Store Only</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			else {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access'>Limited Access: Associated Store Only</option>";
				echo "<option value='no' selected>Unauthorized</option>";
			}
			$count += 1;
			continue;
		}
		if ($count == 5) { //edit inventory
			if ($value == 'full_access') {
				echo "<option value='full_access' selected>Full Access</option>";
				echo "<option value='limited_access_no_del'>Associated Store Access: Edit Only</option>";
				echo "<option value='limited_access'>Associated Store Access: Edit and Delete</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			elseif ($value == 'limited_access_no_del') {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access_no_del' selected>Associated Store Access: Edit Only</option>";
				echo "<option value='limited_access'>Associated Store Access: Edit and Delete</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			elseif ($value == 'limited_access') {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access_no_del'>Associated Store Access: Edit Only</option>";
				echo "<option value='limited_access' selected>Associated Store Access: Edit and Delete</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			else {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access_no_del'>Associated Store Access: Edit Only</option>";
				echo "<option value='limited_access'>Associated Store Access: Edit and Delete</option>";
				echo "<option value='no' selected>Unauthorized</option>";
			}
			$count += 1;
			continue;
		}
		if ($count == 6) { //add product
			if ($value == 'yes') {
				echo "<option value='yes' selected>Authorized</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			else {
				echo "<option value='yes'>Authorized</option>";
				echo "<option value='no' selected>Unauthorized</option>";
			}
			$count += 1;
			continue;
		}
		if ($count == 7) { //edit product
			if ($value == 'full_access') {
				echo "<option value='full_access' selected>Full Access</option>";
				echo "<option value='limited_access'>Edit Only</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			elseif ($value == 'limited_access') {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access' selected>Edit Only</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			else {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access'>Edit Only</option>";
				echo "<option value='no' selected>Unauthorized</option>";
			}
			$count += 1;
			continue;
		}
		if ($count == 8) { //add commission
			if ($value == 'yes') {
				echo "<option value='yes' selected>Authorized</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			else {
				echo "<option value='yes'>Authorized</option>";
				echo "<option value='no' selected>Unauthorized</option>";
			}
			$count += 1;
			continue;
		}
		if ($count == 9) { //add repair option
			if ($value == 'yes') {
				echo "<option value='yes' selected>Authorized</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			else {
				echo "<option value='yes'>Authorized</option>";
				echo "<option value='no' selected>Unauthorized</option>";
			}
			$count += 1;
			continue;
		}
		if ($count == 10) { //add repair sale
			if ($value == 'full_access') {
				echo "<option value='full_access' selected>Full Access</option>";
				echo "<option value='limited_access'>Limited Access</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			elseif ($value == 'limited_access') {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access' selected>Limited Access</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			else {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access'>Limited Access</option>";
				echo "<option value='no' selected>Unauthorized</option>";
			}
			$count += 1;
			continue;
		}
		echo "</select>";
	}	
	echo "</tr>";
}
echo '</table></div>';
?>
<br>
<div id="dashboard">
<input type="submit" value="Submit" style="font-size:22pt;height:40px;width:250px;"/></span>
</form><br><br>
<form action="../admin_home.php">
    <input type="submit" value="Home" style="font-size:22pt;height:40px;width:250px;"/>
</form>

</div>
</div>
</main>
</body>

</html>