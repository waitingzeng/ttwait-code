<?php
	require('includes/top.php');
	noCache();
	$action = trim($_REQUEST['action']);
	$step = 0;
	$error = 0;
	$user_name= trim($_POST['user_name']);
	$question= trim($_POST['question']);
	$answer = trim($_POST['answer']);
	if($action == 'repass1'){
		$step = 1;
		if(!$user_name)
			$error = 1;
		else{
			$sql="select * from user where username='$user_name'";
			$user = $db->getRow($sql);
			if($user == 0)
				$error = 2;
			else{
				if(!$user['question'] || $user['answer'])
					$error = 3;
				else{
					$tpl->assign_by_ref('user', $user);
					$_SESSION['action'] = 'repass2';
				}	
			}
		}
	}elseif($action == "repass2"){
		$step = 2;	
		$sql="select * from user where username='$user_name' and question='$question' and answer='$answer'";
		$user = $db->getRow($sql);
		if($user == 0)
			$error=1;
		else{
			$tpl->assign_by_ref('user', $user);
			$_SESSION['action'] = 'repass3';
		}
	}else if(action == "repass3"){
		$step = 3;
		$pass1 = trim($_POST['pass1']);
		$pass2 = trim($_POST['pass2']);
		if($pass1 != $pass2)
			$error = 1;
		else{
			$sql="select * from user where username='$user_name'";
			$user = $db->getRow($sql);
			if($user == 0)
				$error = 2;
				
			$sql = "update user set userpass='$newpass' where username='$user_name'";
			$db->query($sql);
			$tpl->assign_by_ref('user', $user);
			unset($_SESSION['action']);
		}
	}
	$tpl->assign('step', $step);
	$tpl->assign('error', $error);
	
	initHeaderAndFooter();
	$tpl->display('repass.html');
?>