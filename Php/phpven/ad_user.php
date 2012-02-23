<?php
	require('includes/ad_top.php');
	require('includes/modifier.php');
	
	$action = trim($_REQUEST['action']);
	if($action == "del"){
		$user_id = intval($_REQUEST['user_id']);
		if($user_id == 0) die('ERROR');
		$sql = "delete from user where id=$user_id";
		if($db->query($sql))
			alert("Del User Success");
	}
	$searchKey = trim($_REQUEST['searchKey']);
	$searchType = trim($_REQUEST['searchType']);
	$where = '';
	if(strlen($searchKey) != 0)
		$where = "$searchType like '%$searchKey%'";
	$pindex = intval($_REQUEST['page']);
	$p = pagination('user','*', $where, $pindex, 30, 'order by id desc');
	$tpl->assign_by_ref('p', $p);
	$usertype = $db->getAll('select usertype_id,usertype_name from usertype');
	$usertypes = array('' => 'Common');
	if($usertype != 0) {
		foreach ($usertype as $value){
			$usertypes[$value['usertype_id']] = $value['usertype_name'];
		}
	}
	$tpl->assign_by_ref('usertype', $usertypes);
	$tpl->display('ad_user.html');
?>