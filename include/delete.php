<?php
$dir_path = "../uploads/";
require_once('getimages.php');
if(isset($_POST['delete'])) {
	$filePath = $dir_path . $_POST['delete'];
	if(!unlink($filePath)) {
		echo "error";
	} else {
		// echo "SUCCESS!";
		header("location: ../index.php");
	}
}