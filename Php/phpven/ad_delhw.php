<?php
	require('includes/ad_top.php');
	require('includes/modifier.php');
	
	$action = trim($_REQUEST["action"]);
	if($action == 'Delete'){
		$chk_hw_id=$_REQUEST["chk_hw_id"];
		$sql = "delete from hw where hw_id in ($chk_hw_id)";
		$db->query($sql);
		alert("Delete Product Success");
	}elseif($action == 'Set OOS'){
		$chk_hw_id = trim($_REQUEST["chk_hw_id"]);
		$sql = "update hw set hw_kucun=0 where hw_id in ($chk_hw_id)";
		$db->query($sql);
		alert("Set Product OOS Success");
	}
	$cat_id = intval($_REQUEST["cat_id"]);
	$searchType = trim($_REQUEST["searchType"]);
	$key = trim($_REQUEST["searchKey"]);
	$quehou = trim($_REQUEST["quehuo"]);
	if($cat_id > 0)
		$where = "hw_kucun>0 and cat_id in (select id from category where parentpath like '%,$cat_id,%')";
	elseif(strlen($key) != 0)
		$where = "$searchType like '%$key%'";
	elseif($quehou == "yes")
		$where = "hw_kucun<=0";
	else
		$where = '';
	$pindex = intval($_REQUEST["page"]);

	$p = pagination('hw', '*', $where, $pindex, 30, 'order by hw_id desc');
	$tpl->assign_by_ref('p', $p);
	$tpl->assign('searchType', $searchType);
	$tpl->assign('key', $key);
	$tpl->assign('cat_id', $cat_id);
	$tpl->assign('quehou', $quehou);
	$tpl->display('ad_delhw.html');
?>