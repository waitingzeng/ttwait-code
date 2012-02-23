<?php 
	require('includes/top.php');
	$username = checkLogin('userinfo.asp');
	$sql = "select * from user where username='$username'";
	$user = $db->getRow($sql);
	if($user){
		$tpl->assign_by_ref('user', $user);
		$ordercount = $db->count('sub', "sub_name='$username'");
		$tpl->assign('ordercount', $ordercount);
	}
	initHeaderAndFooter();
	$tpl->display('userinfo.html');
?>