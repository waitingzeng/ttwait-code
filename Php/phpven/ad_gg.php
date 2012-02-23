<?php
	require('includes/ad_top.php');
	
	$id = intval($_REQUEST['id']);
	$action = trim($_REQUEST['action']);
	if($action == "add"){
		$data = makePOST();
		$data['date'] = getTime();
		$db->autoExecute('pub', $data);
	}elseif($action == "edit"){
		$data = makePOST();
		$db->autoExecute('pub', $data, 'UPDATE', "id=$id");
	}elseif($action == "del"){
		$db->query("delete from pub where id=$id");
	}
	$tpl->assign_by_ref('publist', getPubs());
	$tpl->display('ad_gg.html');
?>