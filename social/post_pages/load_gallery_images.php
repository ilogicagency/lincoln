<?php
	$final = array();
	$images = array();
    $dir_handle = 'images/final/';
    // Loop through the files
    foreach(array_diff(scandir($dir_handle), array('.', '..')) as $file) {
			$images[] = $file;
    }
	natcasesort($images);
	foreach($images as $key => $val){
		$final[] = "https://www.ilogic.co.za/citroen/".$dir_handle.$val;
	}
	krsort($final);

	echo json_encode($final);
?>

