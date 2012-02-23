<?php
	require('includes/ad_top.php');
	require('includes/modifier.php');
	
	$action = trim($_REQUEST['action']);
	if($action == "modi"){
		$basket_id = intval($_REQUEST['basket_id']);
		if($basket_id == 0) die('ERROR');
		$sub_number1 = trim($_REQUEST['sub_number1']);
		$sql = "update basket set sub_number='$sub_number1' where basket_id=$basket_id";
		$db->query($sql);
	}
	$user_name = trim($_REQUEST['user_name']);
	$where = "sub_number is null and user_name like '%$user_name%'";
	$pindex = intval($_REQUEST['page']);
	$p = pagination('basket', '*', $where, $pindex, 40, 'order by basket_id desc');
	$tpl->assign_by_ref('p', $p);
	$tpl->assign('user_name', $user_name);
	$tpl->display('ad_basket.html');
?>