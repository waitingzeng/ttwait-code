<?php
	require('includes/top.php');
	initHeaderAndFooter();
	$action = trim($_REQUEST["action"]);
	if($action == "save"){
		$email = trim($_POST['email']);
		$body = trim($_POST['content']);
		$time = getTime();
		$data = array(
			'email' => $email,
			'body' => $body,
			'title' => '0',
			'submit_date' => $time,
		);
		$db->autoExecute('guest', $data);
		$tpl->assign('success', true);
	}
	$tpl->display('guestbook.html');
?>