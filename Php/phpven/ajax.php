<?php
	require('includes/const.php');
	require('includes/db.php');
	require('includes/function.php');
	require('includes/base.php');
	require('includes/util.php');
	
	function login(){
		$tpl = $GLOBALS['tpl'];
		$tpl->caching = false;
		$hadLogin = hadLogin();
		$tpl->assign('hadLogin', $hadLogin);
		if($hadLogin){
			$username = $_COOKIE['username'];
			$viewcount = $GLOBALS['db']->count('basket', "sub_number is null and user_name='$username'");
			$tpl->assign('username', $username);
			$tpl->assign('viewcount', $viewcount);
		}
		$tpl->assign('ServerPath', SERVERPATH);
		noCache();
		$tpl->display('log.html');
	}
	
	function insort(){
		if(empty($_REQUEST['cat_id'])){
			return;
		}
		$cat_id = $_REQUEST["cat_id"];
		if($cat_id <= 0)
			return;
		$sql = "select id, name, alias, depth from category where parent=$cat_id and html=0 order by name desc";
		$cat_list = $GLOBALS['db']->getAll($sql);
		require("includes/JSON.php");
		$json = new Services_JSON();
		echo $json->encode($cat_list);
	}
	
	function pinpai_cat(){
		if(empty($_REQUEST['pinpai'])){
			return;
		}
		$pinpai = $_REQUEST["pinpai"];
		$sql = "select id, name from category where depth=1 and id in (select parent from category where depth=2 and html=0 and name='$pinpai') order by name desc";
		$cat_list = $GLOBALS['db']->getAll($sql);
		require("includes/JSON.php");
		$json = new Services_JSON();
		echo $json->encode($cat_list);
	}
	
	function dy(){
		$result = array();
		if(empty($_REQUEST['email'])){
			$result['state'] = false;
			$result['msg'] = 'please fill the email!';
		}else{
			$email = $_REQUEST['email'];
			if(!isEmail($email)){
				$result['state'] = false;
				$result['msg'] = 'You fill in a wrong email address!';
			}else{
				global $db;
				if($db->count('email', "email='$email'") == 0){
					$data = array(
						'email' => $email,
						'date' => getTime()
					);
					$db->autoExecute('email', $data);
					$result['msg'] = 'new';
				}else{
					$result['msg'] = 'old';
				}
				$result['state'] = true;
			}
		}
		echo json_encode($result);
	}
	
	$ajax = array('log' => 'login', 'insort' => 'insort', 'pinpai_cat' => 'pinpai_cat', 'dy' => 'dy');
	
	if(!empty($_REQUEST['func'])){
		$ajax[$_REQUEST['func']]();
	}
?>