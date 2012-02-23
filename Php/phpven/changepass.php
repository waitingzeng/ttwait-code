<?php
	require('includes/top.php');
	$username = checkLogin('changepass.asp');
	
	$action = trim($_REQUEST["action"]);
	$errmsg = array();
	$alert = '';
	if($action == "modify"){
		$oldpass= trim($_POST['oldpass']);
		$pass1 = trim($_POST['pass1']);
		$pass2 = trim($_POST['pass2']);
			
		if(!strlen($pass1) || !strlen($pass2) || !$oldpass)
			$alert = alert("Please fill in password", -1);
		elseif($pass1 != $pass2)
			$alert = alert('Verify password is different from the previous one');
		elseif ($pass1 == $oldpass)
			$alert = alert('the new password is same as old, not change');
		else{
			$oldpass=md5($oldpass);
			$count = $db->count('user', "username='$username' and userpass='$oldpass'");
			if($count == 0)
				$alert = alert('Please confirm your password');
			else{
				$newpass = md5($pass1);
				$sql = "update user set userpass='$newpass' where username='$username'";
				$db->query($sql);
				$alert = alert('PassWord Change finished');
			}
		}
	}
	$tpl->assign('username', $username);
	initHeaderAndFooter();
	$tpl->display('changepass.html');
	echo $alert;
?>