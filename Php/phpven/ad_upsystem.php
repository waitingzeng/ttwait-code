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
	$sql = "select * from system";
	$config = $db->getRow($sql, true);
	$action = trim($_REQUEST['action']);
	if($action == 'change'){
		$data = makePOST();
		if($db->autoExecute('system', $data, 'UPDATE', 'id='.$config['id']))
			$config = $db->getRow($sql, true);
	}
	
	$tpl->assign_by_ref('config', $config);
	$tpl->display('ad_upsystem.html');
?>