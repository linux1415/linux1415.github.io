<!DOCTYPE html>
<html lang="en-US">
<style type="text/css" media="screen">
	
body {
	font-family: sans-serif;
	width: 1000px;
	height: 700px;
	border: 1px solid black;
	box-shadow: 5px 5px 0 0;
	margin-left: auto;
	margin-right: auto;
}

</style>
<body>

<?php

ini_set('display_errors', 'Off');

include '../database_connect.php';

//get variables from form
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];
$store = $_REQUEST['store'];
$type = $_REQUEST['type'];


//grabbing session variable and the current date
//$user = $_SESSION['user'];
$date = date('Y-m-d');
$current_year = date('Y');

//incomplete queries to be executed


$partial_q = "select categories.category_name as name, count(sales.sale_id) as num_sold, sum(sales.item_price) as total 
	from categories, sales where sales.category=categories.category_id";
	
$partial_q_2 = "select categories.category_name as name, count(repair_sales.repair_id) as num_sold, sum(repair_sales.cost) as total 
	from categories, repair_sales where repair_sales.category=categories.category_id";




if ($store != 'all') {
	$partial_q = $partial_q . " and sales.store='$store'";
	$partial_q_2 = $partial_q_2 . " and repair_sales.store='$store'";
	}
		
$to_print = "";		
//adding onto query based on user input
if(isset($month)) {
if ($month == "default" and $year == "default") {
	$query = $partial_q . " and sales.year='$current_year'";
	$query2 = $partial_q_2 . " and repair_sales.year='$current_year'";
	$to_print = "$current_year";
}
elseif ($month != "default" and $year == "default") {
	$query = $partial_q . " and sales.month='$month' and sales.year='$current_year'";
	$query2 = $partial_q_2 . " and repair_sales.month='$month' and repair_sales.year='$current_year'";
	$to_print = "$month" . ", " . "$current_year";
}
elseif ($month != "default" and $year != "default") {
	$query = $partial_q . " and sales.month='$month' and sales.year='$year'";
	$query2 = $partial_q_2 . " and repair_sales.month='$month' and repair_sales.year='$year'";
	$to_print = "$month" . ", " . "$year";
}
elseif ($month == "default" and $year != "default") {
	$query = $partial_q . " and sales.year='$year'";
	$query2 = $partial_q_2 . " and repair_sales.year='$year'";
	$to_print = "$year";
}
else {
	die("There is an error");
}
}

$query = $query . " group by categories.category_name order by total desc;";
$query2 = $query2 . " group by categories.category_name order by total desc;";


//$query = "select categories.category_name as name, count(sales.sale_id) as num_sold, sum(sales.item_price) as total 
//from categories, sales, products where sales.sku=products.sku and products.category=categories.category_id group by categories.category_name order by total;";

$array = mysqli_query($conn, $query);
$array2 = mysqli_query($conn, $query2);

if ($type == 'repairs') {
	$array = $array2;
}

if ($type == 'all') {
	$items = array();
	while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
		$category = $row['name'];
		$num_sold = $row['num_sold'];
		$items[$category] = $num_sold;
	}
	while ($row = mysqli_fetch_array($array2, MYSQLI_ASSOC)){
		$category = $row['name'];
		$num_sold = $row['num_sold'];
		$items[$category] = $items[$category] + $num_sold;
	}
	
}
	

//echo '<div id="title"><h2>Category Performance</h2></div><br>';

echo '<div id="piechart">';

echo '<script type="text/javascript" src="../javascript/pie_chart.js"></script>';

echo '<script type="text/javascript">';
// Load google charts
echo "google.charts.load('current', {'packages':['corechart']});";
echo 'google.charts.setOnLoadCallback(drawChart);';

// Draw the chart and set the chart values
echo 'function drawChart() {
  var data = google.visualization.arrayToDataTable([';
echo "['Task', 'Items Sold'],";

if ($type != 'all') {
	while ($row = mysqli_fetch_array($array, MYSQLI_ASSOC)){
		$category = $row['name'];
		$num_sold = $row['num_sold'];
		$total = $row['total'];
		echo "['$category', $num_sold],";
	}
}
else {
	foreach($items as $category => $num_sold) {
		echo "['$category', $num_sold],";
	}
}

echo ']);';
echo   "var options = {'title':'Category Sales Breakdown', 'width':1000, 'height':700};";
echo  	"var chart = new google.visualization.PieChart(document.getElementById('piechart'));";
echo   "chart.draw(data, options);";
echo "}";
echo "</script>";
?>
</div>
</body>

</html>