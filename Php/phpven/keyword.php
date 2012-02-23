<?php
	require('includes/const.php');
	require('includes/db.php');
	
	$sql = "select distinct name from category order by name";
	$all = $db->getAll($sql);
	$l = array();
	foreach ($all as $v) {
		$l[] = $v['name'];
	}
	$result = join("\r\n", $l);
	header('content-type:application/octet-stream');
	header('Content-Disposition:attachment; filename=keyword.txt');
	echo $result;
?>