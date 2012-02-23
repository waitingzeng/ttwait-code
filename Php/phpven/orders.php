<?php
	require('includes/top.php');
	require('includes/modifier.php');
	$username = checkLogin("orders.asp");
	
	$zt = isset($_REQUEST["zt"])?intval($_REQUEST['zt']):-1;
	
	$pindex = intval($_REQUEST['pindex']);
	if($pindex == 0)$pindex=1;
	$where = "sub_name='$username'";
	if($zt != -1)$where = $where." and sub_zt=$zt";
	$p = pagination('sub', '*', $where, $pindex, 30, "order by sub_id desc");
	$tpl->assign_by_ref('p', $p);
	$tpl->assign('zt', $zt);
	
	$orderstate = array('Invalid','New','Paying','Payed','In Transit','Finished');
	$tpl->assign_by_ref('orderstate', $orderstate);
	
	initHeaderAndFooter();
	$tpl->display('orders.html');
?>