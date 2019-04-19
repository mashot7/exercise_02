<?php
$extensions_array = array("jpg", "png", "jpeg");
$newarray = [];
$p = 0;
if (is_dir($dir_path)) {
	$files = scandir($dir_path);
	for($i = 0; $i < count($files); $i++) {
		if ($files[$i] != '.' && $files[$i] != '..') {
			// Get file info
			$file = pathinfo($files[$i]);
			$extension = $file['extension'];
			if (in_array($extension, $extensions_array)) {
				$newarray[++$p]['path'] =$files[$i];
				$newarray[$p]['extension'] = pathinfo($files[$i])['extension'];
				$pos = strpos($files[$i], $extension);
				$newarray[$p]['name']  =  substr($files[$i], 0, $pos - 1);
				$filename = $dir_path . $files[$i];
				$newarray[$p]['size']  = filesize($filename);
			}
		}
	}
}
$per_page = 5;
$count = count($newarray);
$pages = ceil($count/$per_page);
?>
