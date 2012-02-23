<?php
	require('includes/ad_top.php');
	require('includes/modifier.php');
	
	$action = trim($_REQUEST['action']);
	if($action == "del"){
		$news_id = intval($_REQUEST['news_id']);
		if($news_id)die('ERROR');
		if($db->query("delete from news where news_id=$news_id"))
			alert("Del Success");
	}
	$pindex = intval($_REQUEST['page']);
	$p = pagination('news', 'news_id, news_title', '', $pindex, 20, 'order by news_id desc');
	$tpl->assign_by_ref('p', $p);
	$tpl->display('ad_delnews.html');
?>