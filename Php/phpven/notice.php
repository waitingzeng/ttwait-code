<?php
	require('includes/top.php');
	
	$id = intval($_REQUEST["id"]);
	if($id > 0){
		$sql = "select * from pub where id=$id";
		$pub = $db->getRow($pub);
		if($pub){
			$tpl->assign_by_ref('pub', $pub);
		}
	}
	$tpl->display('notice.html');
?>