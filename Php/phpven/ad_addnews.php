<?php
	require('includes/ad_top.php');
	
	$action = trim($_REQUEST['action']);
	$news_id = intval($_REQUEST['news_id']);
	$news = $db->getRow("select * from news where news_id=$news_id");
	if($action == "save"){
		$data = makePOST();
		if(empty($data['news_title']) || empty($data['news_content']))
			alert("Title and Content Can't be empty", -1);
		$data['news_date'] = getTime();
		if($news == 0){
			$db->autoExecute('news', $data);
		}else{
			$db->autoExecute('news', $data, 'UPDATE', "news_id=$news_id");
		}
		alert("Save News Success", "ad_delnews.asp");
	}
	$tpl->assign_by_ref('news', $news);
	$tpl->display('ad_addnews.html');
?>