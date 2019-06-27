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
	width: 130px;
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
<div id="title"><h2>Permissions: Read Only Features</h2></div>
<form action="permissions_2_handle.php" method="post">

<div id="body">
<div class="scrollable" id="table"><table id="mytable"><tr><th>Employee</th><th>Sales<br>Performance</th><th>Item<br>Performance</th><th>Category<br>Performance</th><th>Inventory<br>Table</th><th>Products<br>Table</th><th>Repairs<br>Table</th></tr>

<?php

ini_set('display_errors', 'Off');

include '../database_connect.php';


$query = "select permissions_tables.user_id as id, CONCAT(left(employee_info.first_name, 1), '. ', employee_info.last_name) as name, permissions_tables.sales_performance, permissions_tables.item_performance, permissions_tables.category_performance, permissions_tables.inventory, permissions_tables.products, permissions_tables.repairs
from permissions_tables, employee_info
where employee_info.id_num=permissions_tables.user_id;";

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
		if ($count == 2) { //sales performance
			if ($value == 'full_access') {
				echo "<option value='full_access' selected>Full Access</option>";
				echo "<option value='store_access'>Associated Store Access</option>";
				echo "<option value='individual_access'>Individual Access</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			elseif ($value == 'store_access') {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='store_access' selected>Associated Store Access</option>";
				echo "<option value='individual_access'>Individual Access</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			elseif ($value == 'individual_access') {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='store_access'>Associated Store Access</option>";
				echo "<option value='individual_access' selected>Individual Access</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			else {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='store_access'>Associated Store Access</option>";
				echo "<option value='individual_access'>Individual Access</option>";
				echo "<option value='no' selected>Unauthorized</option>";
			}
			$count += 1;
			continue;
		}
		if ($count == 3) { //item_performance
			if ($value == 'full_access') {
				echo "<option value='full_access' selected>Full Access</option>";
				echo "<option value='limited_access'>Associated Store Only</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			elseif ($value == 'limited_access') {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access' selected>Associated Store Only</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			else {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access'>Associated Store Only</option>";
				echo "<option value='no' selected>Unauthorized</option>";
			}
			$count += 1;
			continue;
		}
		if ($count == 4) { //category performance
			if ($value == 'full_access') {
				echo "<option value='full_access' selected>Full Access</option>";
				echo "<option value='limited_access'>Associated Store Only</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			elseif ($value == 'limited_access') {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access' selected>Associated Store Only</option>";
				echo "<option value='no'>Unauthorized</option>";
			}
			else {
				echo "<option value='full_access'>Full Access</option>";
				echo "<option value='limited_access'>Associated Store Only</option>";
				echo "<option value='no' selected>Unauthorized</option>";
			}
			$count += 1;
			continue;
		}
		if ($count == 5) { //inventory table
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
		if ($count == 6) { //products table
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
		if ($count == 7) { //repairs table
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