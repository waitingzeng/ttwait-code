<?php
	require_once('data.php');
	$macid = $_REQUEST['macid'];
	if(in_array($macid, $data)){
		$a = time();
		$data = md5($macid.$a);
		$data = md5('ttwait'.$data);
		print $a.'|'.$data;
		exit();
	}
?>