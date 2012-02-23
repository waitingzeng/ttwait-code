<?php
	require('includes/ad_top.php');
	
	function checkEmpty($name, $msg=false){
		$item = trim($_REQUEST[$name]);
		if(!$item && $msg){
			$GLOBALS['errmsg'][] = $msg;
		}
		return $item;
	}
	
	$id = intval($_REQUEST['id']);
	if($id <= 0)die('ERROR');
	$action = trim($_REQUEST['action']);
	$errmsg = array();
	if($action == "change"){
		$user_mail = checkEmpty('user_mail', '<li>用户E-mail不能为空</li>');
		$country = checkEmpty('country', '<li>用户国家不能为空</li>');
		//$user_adds = checkEmpty('user_adds', '<li>用户地址不能为空</li>');
		$user_adds = $_REQUEST['user_adds'];
		//$user_postcode = checkEmpty('user_postcode','<li>邮政编码不能为空</li>');
		$user_postcode = $_REQUEST['user_postcode'];
		//$user_tel = checkEmpty('user_tel');
		$user_tel = $_REQUEST['user_tel'];
		//$user_namec = checkEmpty('user_namec','<li>用户真实姓名不能为空</li>');
		$user_namec = $_REQUEST['user_namec'];
		$user_buymoney = intval($_REQUEST['jifen']);
		//if($user_buymoney == 0)$errmsg[] = '<li>请输入用户积分值</li>';
   		if(count($errmsg) == 0){
			$userpass = trim($_REQUEST['userpass']);
			$data = array(
				'jifen' => $user_buymoney,
				'usermail' => $user_mail,
				'user_adds' => $user_adds,
				'user_postcode' => $user_postcode,
				'usertel' => $user_tel,
				'user_namec' => $user_namec,
				'country' => $country,
			);
			if(strlen($userpass) != 0){
				$data['userpass'] = md5($userpass);
			}
			$db->autoExecute('user', $data, 'UPDATE', "id=$id");
			$errmsg[] = 'Modify Succes!';
		}
	}
	$sql = "select * from user where id=$id";
	$tpl->assign_by_ref('user', $db->getRow($sql));
	$tpl->assign_by_ref('usertype', $db->getAll('select usertype_id, usertype_name from usertype'));
	$tpl->assign_by_ref('errmsg', join($errmsg, '<br/>'));
	$tpl->display('ad_modify.html');
?>