<?php
	$num = rand(0, 20);
	$path = pathinfo(__FILE__);
	$path = $path['dirname'];
	$path = $path.'/artist/'.$num.'.jpg';
	echo $path;
	header('Content-Type', 'image/jpeg');
	$fp = fopen($path, 'rb');
	while (!feof($fp)) {
		$result = fread($fp, 1024);
		echo $result;
	}
	fclose($fp);
?>