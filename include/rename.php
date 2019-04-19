<?php

$dir_path = "../uploads/";
require_once('getimages.php');

if (isset($_POST['newName'])) {
	$page = $_GET['page'] - 1;
	$id = $_GET['id'];
	$j = $page * $per_page + $id + 1;
	$k = 0;
	$newName = $_POST['newName'] . '.' . $newarray[$j]['extension'];

	while(in_array_r($newName, $newarray)) {
		$newName = $_POST['newName'] . '(' . ++$k . ').' . $newarray[$j]['extension'];
	}
	
	if (!rename( $dir_path . $newarray[$j]['path'], $dir_path . $newName)) {
		echo "error";
	} else {
		echo "SUCCESS!";
		header("location: ../index.php");
	}
}

// "in_array()" Function for multidimensional array
function in_array_r($needle, $haystack, $strict = false) {
	foreach ($haystack as $item) {
		if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
			return true;
		}
	}
	return false;
}
?>