<?php
	require('includes/ad_top.php');
	require('includes/modifier.php');
	
	$action = trim($_REQUEST['action']);
	if($action == "del"){
		$news_id = intval($_REQUEST['guest_id']);
		if(!$news_id)die('ERROR');
		if($db->query("delete from guest where guest_id=$news_id"))
			alert("Del Success");
	}
	$pindex = intval($_REQUEST['page']);
	$p = pagination('guest', 'guest_id, email, body', '', $pindex, 20, 'order by guest_id desc');
	$db->query("update guest set title='1' where title='0'");
	$tpl->assign_by_ref('p', $p);
	$tpl->display('ad_guest.html');
?>