<?php
	require('includes/ad_top.php');
	$id = intval($_REQUEST['id']);
	$action = trim($_REQUEST['action']);
	$typename = trim($_REQUEST['typename']);
	if($action == "add"){
		$sql = "insert into type (typename)values('$typename')";
		$db->query($sql);
	}elseif($action == "edit"){
		$sql="update type set typename='$typename' where id=$id";
		$db->query($sql);
	}elseif($action == "del"){
		$sql="delete from book where typeid=$id";
		$db->query($sql);
		$sql="delete from type where id=$id";
		$db->query($sql);
	}
	$typelist = $db->getAll('select * from type');
	$tpl->assign_by_ref('typelist', $typelist);
	$tpl->display('ad_type.html');;	
?>