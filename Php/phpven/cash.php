<?php
	require('includes/top.php');
	$username = checkLogin('cash.asp');
	$action = trim($_REQUEST['action']);
	$promo = false;
	if($action == 'save'){
		$code = trim($_REQUEST['promocode']);
		if(strlen($code) != 0){
			$sql = "select * from promo where state=1 and code='$code'";
			$promo = $db->getRow($sql);
		}
	}
	
	$sql = "select basket.*,hw.alias from basket,hw where user_name='$username' and sub_number is null and basket.hw_id=hw.hw_id";
	$basketlist = $db->getAll($sql);
	$tpl->assign_by_ref('basketlist', $basketlist);	
	$sql="select * from user where username='$username'";
	$user = $db->getRow($sql);
	$tpl->assign_by_ref('user', $user);
	$tpl->assign_by_ref('payments', getPayments());
	$tpl->assign_by_ref('pss', getPS());
	$tpl->assign_by_ref('promo', $promo);
	initHeaderAndFooter();
	
	$tpl->display('cash.html');
?>