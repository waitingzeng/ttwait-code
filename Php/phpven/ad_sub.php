<?php
	require('includes/ad_top.php');
	require('includes/modifier.php');
	$zt = !isset($_REQUEST['zt'])?-1 : intval($_REQUEST['zt']);
	$sub_number = trim($_REQUEST["sub_number"]);
	$user_name = trim($_REQUEST["user_name"]);
	$where = "sub_name like '%$user_name%' and sub_number like '%$sub_number%'";
	if($zt != -1)
		$where = "sub_zt=$zt and $where";
	$pindex = intval($_REQUEST["page"]);
	$p = pagination('sub', '*', $where, $pindex, 30, 'order by sub_id desc');
	$tpl->assign_by_ref('p', $p);
	$tpl->assign('zt', $zt);
	$tpl->assign('sub_number', $sub_number);
	$tpl->assign('user_name', $user_name);
	
	$orderstate = array(__('无效订单'), __('未 处 理'),__('已 付 款'),__('已 收 款'),__('已 发 货'),__('已 收 货'));
	$tpl->assign_by_ref('orderstate', $orderstate);
	$tpl->display('ad_sub.html');
?>