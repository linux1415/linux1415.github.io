<?php
include 'verify.php';
include 'database_connect.php';
$user = $_SESSION['member_id'];

if(isset($_GET['id'])){ 
	$resource_id = $_GET['id'];
}

//checking access for specific file
$query = "SELECT * from resource_permissions where resource_id = '$resource_id' and user_id = '$user';";
$array = mysqli_query($conn, $query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
if (count($row) < 1) {
	echo "Unauthorized";
	die();
}


$query = "SELECT path, type, title, category from resources where id = '$resource_id';";
$array = mysqli_query($conn, $query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
$path = $row['path'];
$type = $row['type'];
$title = $row['title'];
$category = $row['category'];

//checking access for file category
$query = "SELECT * from category_permissions where category_id = '$category' and user_id = '$user';";
$array = mysqli_query($conn, $query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
if (count($row) < 1) {
	echo "Unauthorized";
	die();
}

if ($type == 'pdf') {
	header("Content-type: application/pdf");
	header("Content-Disposition: inline; filename=$path");
	@readfile("resources/$path");
}
if ($type == 'png') {
	header('Content-type: image/png');
	header("Content-Disposition: inline; filename=$path");
	@readfile("resources/$path");
}	
if ($type == 'jpeg' || $type == 'jpg') {
	header('Content-type: image/jpeg');
	header("Content-Disposition: inline; filename=$path");
	@readfile("resources/$path");
}
if ($type == 'txt') {
	echo file_get_contents("resources/$path");
}

?>