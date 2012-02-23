<?php
	require('includes/top.php');
	initHeaderAndFooter();
	$hadLogin = hadLogin();
	if($hadLogin){
		$tpl->assign('username', $_COOKIE['username']);
	}
	$tpl->assign('hadLogin', $hadLogin);
	$tpl->display('reg.html');
?>