<?php
	require('includes/ad_top.php');
	
	$id = intval($_REQUEST['id']);
	$action = trim($_REQUEST['action']);
	
	if($action == "save"){
		$data = makePOST();
		if($id <= 0){
			$db->autoExecute('book', $data);
		}else {
			$db->autoExecute('book', $data, 'UPDATE', "id=$id");
		}
		alert("Save Success", "ad_booktype.asp?typeid=".$data['typeid']);
	}
	$sql = "select * from book where id=$id";
	$tpl->assign_by_ref('book', $db->getRow($sql));
	$tpl->assign_by_ref('typelist', $db->getAll('select * from type'));

	$tpl->display('ad_bookzj.html');
?>