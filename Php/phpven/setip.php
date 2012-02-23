<?php
	function getClientIP(){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		if(empty($ip))$ip = $_SERVER['REMOTE_ADDR'];
		return $ip;
	}
	$root = $_SERVER['DOCUMENT_ROOT'];
	$fp = fopen($root.'/ip.txt','w');
	$ip = getClientIP();
	fwrite($fp, $ip);
	fclose($fp);
	echo 'good:', $ip;
?>