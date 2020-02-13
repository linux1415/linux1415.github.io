<?php
include 'verify.php';
include 'database_connect.php';
$user = $_SESSION['member_id'];
if (!isset($_POST['file_title']) || !isset($_POST['category']) || !isset($_FILES["upload_file"])) {
	echo "<script>window.location.href = 'edit_resources.php';</script>";
	die();
}
$title = mysqli_real_escape_string($conn, trim($_POST['file_title']));
$category = $_POST['category'];

//checking access for category
$query = "SELECT * from edit_categories_permissions where category_id = '$category' and user_id = '$user';";
$array = mysqli_query($conn, $query);
$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
if (count($row) < 1) {
	echo "<script>window.location.href = 'edit_resources.php';</script>";
	die();
}

$now = new DateTime();
$now->setTimezone(new DateTimeZone('America/Chicago'));  
$date_time = $now->format('Y-m-d H:i:s');
$date = $now->format('Y-m-d');

$target_dir = "resources/";
$target_file = $target_dir . basename($_FILES["upload_file"]["name"]);
$file_name = basename($_FILES["upload_file"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
/*if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["upload_file"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}*/

// Check if file already exists
$print_errors = "";
if (file_exists($target_file)) {
	$print_errors .= 'File already exists.\r\n';
    $uploadOk = 0;
}
// Check file size
if ($_FILES["upload_file"]["size"] > 50000000) {
	$print_errors .= 'File is too large.\r\n';
    $uploadOk = 0;
}
// Allow certain file formats
$allowedfileExtensions = array('txt','pdf', 'png', 'jpeg', 'jpg');
if (!in_array($fileType, $allowedfileExtensions)) {
	$print_errors .= 'File type not allowed.\r\n';
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "<script>alert(\"$print_errors\");</script>";
	echo "<script>window.history.back();</script>";
	die();
} 
else {
    if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
        $success_file = "The file ". basename( $_FILES["upload_file"]["name"]). " has been uploaded.";
		$update = "insert into resources (category, title, path, type, author, creation_date) values ('$category', '$title', '$file_name', '$fileType', '$user', '$date');";
		mysqli_query($conn, $update);
		$query = "SELECT id from resources where path = '$file_name';";
		$array = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($array, MYSQLI_ASSOC);
		$insert_id = $row['id'];
		$update_permissions = "insert into resource_permissions (resource_id, user_id) values ('$insert_id', '$user');";
		mysqli_query($conn, $update_permissions);
		echo "<script>alert('$success_file')</script>";
    } 
	else {
		echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
		echo "<script>window.history.back();</script>";
		die();
    }
}
echo "<script>window.location.href = 'add_resource.php?id=$category';</script>";
?>