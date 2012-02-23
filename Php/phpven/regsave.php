<?php
	require('includes/top.php');
	noCache();
	
	$errmsg = array();
	$user_name = trim($_POST['user_name']);
	if(!$user_name)$errmsg[]='<li>Please fill in your Username!</li>';
	$user_pass = trim($_POST['user_pass']);
	$user_pass2 = trim($_POST['user_pass2']);
	if(strlen($user_pass)<6 || strlen($user_pass2)<6)
		$errmsg[] = '<li>Your Password must be more than 6 characters!</li>';
	elseif($user_pass !== $user_pass2)
		$errmsg[] = '<li>Verify Password is different from The Previous One!</li>';

	$user_country = trim($_POST['user_country']);
	if(!$user_country)
		$errmsg[] ='<li>please fill your country!</li>';
	$user_mail = trim($_POST['user_mail']);
	if(!isEmail($user_mail))
		$errmsg[] ='<li>You fill in a wrong email address!</li>';
	$question = trim($_POST['question']);
	$answer = trim($_POST['answer']);
	$count = $db->count('user', "username='$user_name'");
	if($count != 0)
		$errmsg[] = '<li>Username Existed</li>';
		
	if(count($errmsg) == 0){
		$user_msn = trim($_POST['user_msn']);
		$user_google = trim($_POST['user_google']);
		$user_yahoo = trim($_POST['user_yahoo']);
		$ip = getClientIP();
		$time = getTime();
		$data = array(
			'username' => $user_name,
			'userpass' => md5($user_pass),
			'usermail' => $user_mail,
			'question' => $question,
			'answer' => $answer,
			'country' => $user_country,
			'usermsn' => $user_msn,
			'usergoogle' => $user_google,
			'useryahoo' => $user_yahoo,
			'user_regip' => $ip,
			'user_type' => '1',
			'landtime' => $time,
			'degree' => 1,
			'user_lastip' => $ip,
			'regtime' => $time,
			'jifen' => 0,
		);
		$db->autoExecute('user', $data);
		setLoginCookie($user_name);
		$tpl->assign('hadLogin', 1);
		$tpl->assign('username', $user_name);
		$tpl->assign('email', $user_mail);
	}else{
		$tpl->assign_by_ref('errmsg', join('<br/>', $errmsg));
		$tpl->assign('hadLogin', 0);
	}
	initHeaderAndFooter();
	$tpl->display('regsave.html');
?>