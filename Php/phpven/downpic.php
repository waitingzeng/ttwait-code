<?php
	require('includes/const.php');
	require('includes/db.php');
	
	$f = fopen(ROOT_PATH."/nofound.txt", "w");
	$all = $db->getAll("select hw_sn from hw where hw_kucun>0");
	foreach ($all as $item) {
		$hw_sn = $item['hw_sn'];
		$path = ROOT_PATH.'/pic/'.$hw_sn.'.jpg';
		if(!file_exists($path)){
			echo $hw_sn."<br/>";
			fwrite($f, $hw_sn."\r\n");
		}
	}
	echo 'finish';
	fclose($f);
	
?>