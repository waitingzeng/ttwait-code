<?php
	require('includes/ad_top.php');
	
	$id = intval($_REQUEST['id']);
	$typeid = intval($_REQUEST['typeid']);
	$action = trim($_REQUEST['action']);
	if($action == "del"){
		$sql = "delete from book where id=$id";
		$db->query($sql);
		alert("Del Success");
	}
	$sql="select * from book where typeid=$typeid order by id desc";
	$tpl->assign_by_ref('booklist', $db->getAll($sql));
	$tpl->assign('typeid', $typeid);
	$tpl->display('ad_booktype.html');
?>