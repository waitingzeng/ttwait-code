<?php
	require('includes/ad_top.php');
	
	$config = $db->getRow('select id, reg from system', true);
	$action = trim($_REQUEST['action']);
	if($action == "save"){
		$reg = $_REQUEST["reg"];
		$data = array(
			'reg' => $reg,
		);
		$db->autoExecute('system', $data, 'UPDATE', 'id='.$config['id']);
		$config = $data;
	}
	$tpl->assign_by_ref('reg', $config['reg']);
	$tpl->display('ad_xieyi.html');
?>