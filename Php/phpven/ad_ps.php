<?php
	require('includes/ad_top.php');
	
	$ps_id = intval($_REQUEST['ps_id']);
	$action = trim($_REQUEST['action']);
	if($action == "add"){
		$data = makePOST();
		$db->autoExecute('ps', $data);
	}elseif($action == "edit"){
		$data = makePOST();
		$db->autoExecute('ps', $data, 'UPDATE', "ps_id=$ps_id");
	}elseif($action == "del"){
		$db->query("delete from ps where ps_id=$ps_id");
	}
	$tpl->assign_by_ref('pslist', getPS());
	$tpl->display('ad_ps.html');
?>