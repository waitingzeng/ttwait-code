<?php
	require('includes/ad_top.php');
	
	$sql = "select count(*) from sub where sub_zt=1";
	$tpl->assign('newsubcount', $db->count('sub', 'sub_zt=1'));
	$tpl->assign('quhoucount', $db->count('hw', 'hw_kucun=0'));
	$tpl->assign('guestcount', $db->count('guest', "title='0'"));
	$tpl->display('ad_main.html');
?>