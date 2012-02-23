<?php
	$url = $_SERVER['REQUEST_URI'];
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: http://www.caataltd.com$url");
	exit();
?>