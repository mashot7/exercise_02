<?php
$dir_path = '../uploads/';
include('getimages.php');

if (isset($_POST['submit'])) {
	if(!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
		echo 'No upload<br>';
		echo '<a class="btn btn-primary" href="../">Back to Main page.</a>';
		exit();
	}

	$file_type = $_FILES['file']['type']; //returns the mimetype

	$allowed = array("image/jpeg", "image/gif", "image/png");
	if(!in_array($file_type, $allowed)) {
		$error_message = 'Only jpg, gif, and png files are allowed.<br>';

	
		echo $error_message;
		echo '<a class="btn btn-primary" href="../">Back to Main page.</a>';
	
		exit();
	
	}
	
	$k = 0;
	$file = $_FILES['file'];
	$fileName = $file['name'];
	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	// If name of file is execist, rename it
	$pos = strpos($fileName, '.' . $fileActualExt);
	$tmp  =  substr($fileName, 0, $pos);
	while(in_array_r($tmp, $newarray)) {
		$pos = strpos($fileName, '.' . $fileActualExt);
		$tmp  =  substr($fileName, 0, $pos);
		$tmp = $tmp . '(' . ++$k . ')';
	}
	$fileName = $tmp . '.' . $fileActualExt;
	// end of rename

	$fileTmpName = $file['tmp_name'];
	$fileSize = $file['size'];
	$fileError = $file['error'];


	if ($fileError === 0) {
		if ($fileSize < 100 * (1024 * 1024)) {
			$fileNameNew = uniqid('', true) . '.' . $fileActualExt;
			$fileDestination = $dir_path . $fileName;
			move_uploaded_file($fileTmpName, $fileDestination);
			header('Location: ../index.php');
		} else {
			echo "Your file is too big!";
		}
	} else {
		echo "There was an error uploading your file!";
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