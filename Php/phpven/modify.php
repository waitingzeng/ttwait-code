<?php
	require('includes/top.php');
	$username = checkLogin('modify.asp');
	
	$action = trim($_REQUEST['action']);
	$errmsg = array();
	$alert = '';
	if($action == 'modify'){
		$user_mail = trim($_POST['user_mail']);
		if(strlen($user_mail) == 0)
			$errmsg[] = '<br>Email can not be empty';
		elseif(!isEmail($user_mail))
			$errmsg[] = '<br>Email has mistake, please check';
		$user_country = trim($_POST['user_country']);
		if(strlen($user_country) == 0)
			$errmsg[] = '<br>Country can not be empty';
		$user_adds = trim($_POST['user_adds']);
		if(strlen($user_adds) == 0)
			$errmsg[] = '<br>Address can not be empty';	
		$user_postcode = trim($_POST['user_postcode']);
		if(strlen($user_postcode) == 0)
			$errmsg[] = '<br>Postcode can not be empty';
		$user_namec = trim($_POST['user_namec']);
		if(strlen($user_namec) == 0)
			$errmsg[] = '<br>Real name can not be empty';	
		if(count($errmsg) == 0){
			$data = array(
				'usermail'=> $user_mail,
				'country' => $user_country,
				'user_adds' =>$user_adds,
				'user_postcode' =>$user_postcode,
				'usertel' =>trim($_POST['user_tel']),
				'user_namec' =>$user_namec,
				'usermsn' => trim($_POST['usermsn']),
				'usergoogle' => trim($_POST['usergoogle']),
				'useryahoo' => trim($_POST['useryahoo']),
			);
			$db->autoExecute('user', $data, 'UPDATE', "username='$username'");
			
			$alert = alert('You had Update your information');
		}
	}
	$sql="select * from user where username='$username'";
	$user = $db->getRow($sql);
	$tpl->assign_by_ref('user', $user);
	$tpl->assign_by_ref('errmsg', join($errmsg));
	initHeaderAndFooter();
	$tpl->display('modify.html');
	echo $alert;
?>