<?php
	require('includes/ad_top.php');
	
	$sql = "select * from type";
	$types = $db->getAll($sql);
	$tpl->assign_by_ref('types', $types);
	$tpl->display('ad_left.html');
?>