<?php
	function checkAdminLogin($redir=true){
		if(!empty($_COOKIE['admin_name'])){
			$username = $_COOKIE['admin_name'];
			$userquiz = $_COOKIE['adminquiz'];
			if($userquiz == md5($username.COOKIES_QUIZ))
				return 1;
		}
		if($redir)
			redirect('ad_login.asp');
		else 
			return 0;
	}
	
	function setAdminCookies($username=''){
		if($username){
			setcookie('admin_name', $username);
			$userquiz = md5($username.COOKIES_QUIZ);
			setcookie('adminquiz', $userquiz);
		}else{
			setcookie('admin_name', '');
			setcookie('adminquiz', '');
		}
	}
	
	function makePOST(){
		$data = array();
		foreach ($_POST as $key=>$value) {
			$v = trim($value);
			if(!get_magic_quotes_gpc()){
				$v = addslashes($v);
			}
			$data[$key] =  $v;
		}
		return $data;
	}

	function __($text){
		if(isset($LANGUAGE[$text])){
			return $LANGUAGE[$text];
		}else{
			return $text;
		}
	}
	
	function ad_login($url, $l){
		if(checkAdminLogin(false)){
			redirect($url);
		}
		$action = trim($_REQUEST["action"]);
		$errmsg = array();
		if($action == "login"){
			$data = makePOST();
			$admin_name = $data['admin_name'];
			$admin_pass = $data['admin_pass'];
			if(strlen($admin_name) == 0)$errmsg = __('请输入用户名');
			elseif(strlen($admin_pass) == 0)$errmsg = __("请输入密码");
			elseif(stripos($admin_name, "'") || stripos($admin_pass, "'"))$errmsg[] = __("请不要非法操作");
			else{
				$where = "admin_name='$admin_name' and admin_pass='".md5($admin_pass)."'";
				$count = $GLOBALS['db']->count('admin', $where);
				if($count == 0) alert(__("用户名或密码错误"));
				else{
					$sql = "update admin set lastip='". getClientIP()."', lasttime='".getTime()."', landtimes=landtimes+1 where admin_name='$admin_name'";
					$GLOBALS['db']->query($sql);
					setAdminCookies($admin_name);
					redirect($url);
				}
			}
		}
		$tpl = $GLOBALS['tpl'];
		$tpl->assign_by_ref('errmsg', join($errmsg, '<br/>'));
		$tpl->assign('l', $l);
		$tpl->display('ad_login.html');
	}
?>