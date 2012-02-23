<?php
	require('includes/sql.php');
	require('includes/const.php');
	require('includes/db.php');
	require("includes/JSON.php");
	$result = array('state' => 0);
	$oldcatid = $_REQUEST['catid'];
	$oldhwid = $_REQUEST['hwid'];
	if(is_numeric($oldid)){
		$sql = "select id, name, code, parent from category where id>$oldid";
		$list = $db->getAll($sql);
		$sql = "select "
		$result['category'] = $list;
		$result['state'] = 1;
	}
	$json = new Services_JSON();
	echo $json->encode($result);
?>