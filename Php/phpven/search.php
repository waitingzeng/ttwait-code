<?php
	require('includes/top.php');	
	
	if(empty($_REQUEST["pinpai"]))die('ERROR');
	$pinpai = $_REQUEST["pinpai"];
	$category = intval($_REQUEST["category"]);
	if($category > 0){
		$sql = "select id,alias from category where depth=2 and name='$pinpai' and parentpath like '%,$category,%'";
		$cat = $db->getRow($sql);
		if($cat){
			redirect($cat['alias'].".html");
		}
	}
	require('includes/modifier.php');
	$pindex = intval($_REQUEST['page']);
	if($pindex==0)$pindex=1;
	$pagesize = $config['lookpage'];
	$where = "hw_kucun>0 and html != 2 and cat_id in (select id from category where depth=3 and parent in (select id from category where depth=2 and name='$pinpai'))";
	$p = pagination('hw', "hw_id, hw_name, hw_sn, alias", $where, $pindex, $pagesize, "order by hw_kucun desc, hw_sn desc");	
	$tpl->assign_by_ref('p', $p);
	$tpl->assign('pinpai', $pinpai);
	
	initHeaderAndFooter();
	$tpl->display('search.html');
?>