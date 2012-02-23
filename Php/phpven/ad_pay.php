<?php
	require('includes/ad_top.php');
	
	$pay_id = intval($_REQUEST['pay_id']);
	$action = trim($_REQUEST['action']);
	if($action == "add"){
		$data = makePOST();
		$db->autoExecute('pay', $data);
	}elseif($action == "edit"){
		$data = makePOST();
		$db->autoExecute('pay', $data, 'UPDATE', "pay_id=$pay_id");
	}elseif($action == "del"){
		$db->query("delete from pay where pay_id=$pay_id");
	}
	$tpl->assign_by_ref('paylist', getPayments());
	$tpl->display('ad_pay.html');
?>