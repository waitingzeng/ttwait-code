<?php
	require('includes/const.php');
	require('includes/util.php');
	require('includes/ad_util.php');
	checkAdminLogin();
	
	require('includes/db.php');
	require('includes/base.php');
	require('includes/function.php');
	
	if(defined('LANGUAGE')){
		require_once(LANGUAGE);
	}
	$tpl->template_dir = AD_TEMPLATE;
	$tpl->assign('ServerPath', SERVERPATH);
	$tpl->assign('pic_url', PIC_URL);
	header('Cache-Control: no-cache');
?>