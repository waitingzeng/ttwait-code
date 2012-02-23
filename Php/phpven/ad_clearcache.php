<?php
	require('includes/const.php');
	require('includes/ad_util.php');
	
	checkAdminLogin();
	
	require('includes/base.php');
	$tpl->clear_all_cache();
	echo 'Clear Cache Success';
?>