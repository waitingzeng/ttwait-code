<?php
	require('includes/ad_top.php');
	
	$id = intval($_REQUEST['id']);
	$action = trim($_REQUEST['action']);
	if($action == "add"){
		$data = makePOST();
		$db->autoExecute('venlink', $data);
	}elseif($action == "edit"){
		$data = makePOST();
		$db->autoExecute('venlink', $data, 'UPDATE', "id=$id");
	}elseif($action == "del"){
		$db->query("delete from venlink where id=$id");
	}
	$tpl->assign_by_ref('linklist', getLinks());
	$tpl->display('ad_links.html');
?>