<?php
	require('includes/sql.php');
	require('includes/const.php');
	require('includes/util.php');
	require('includes/ad_util.php');
	require('includes/db.php');
	require('includes/base.php');
	require('includes/function.php');
	
	$tpl->template_dir = AD_TEMPLATE;
	$tpl->assign('ServerPath', SERVERPATH);
	$tpl->assign('pic_url', PIC_URL);
	
	ad_login('ad_manage.asp', '');
?>