<?php
	require('includes/const.php');
	require('includes/ad_util.php');
	
	checkAdminLogin();
	require('includes/db.php');
	require('includes/base.php');
	
	function getAlias($name){
		$alias = preg_replace("/[\W_]+/i", '-', $name);
		if($alias[0] == '-'){
			$alias = substr($alias, 1);
		}
		if(substr($alias, -1, 1) == '-'){
			$alias = substr($alias, 0, -1);
		}
		return strtolower($alias);
	}
	$ul = 0;
	$all = isset($_REQUEST['all']);
	$db->begin();
	$sql = "select id, name, alias from category where depth=1";
	$bsorts = $db->getAll($sql);

	foreach ($bsorts as $bsort){
		$dir = getAlias($bsort['name']);
		$bid = $bsort['id'];
		if($all || empty($bsort['alias'])){
			$alias = "$dir/$dir-c$bid";
			$db->query("update category set alias='$alias' where id=$bid");
			$ul++;
		}
		$sql = "select id, name from category where depth>1 and parentpath like '%,$bid,%'";
		if(!$all) $sql .= ' and alias is null';
		$cat = $db->getAll($sql);
		foreach ($cat as $item){
			$a = getAlias($item['name']);
			$id = $item['id'];
			$alias = "$dir/$a-c$id";
			if($db->query("update category set alias='$alias' where id=$id"))
				$ul++;
		}
		if($all)
			$sql = "select hw_id, hw_name from hw where cat_id in (select id from category where parentpath like '%,$bid,%')";
		else
			$sql =  "select hw_id, hw_name from hw where alias is null and cat_id in (select id from category where parentpath like '%,$bid,%')";
		$hwlist = $db->getAll($sql);
		foreach ($hwlist as $hw){
			$a = getAlias($hw['hw_name']);
			$hw_id = $hw['hw_id'];
			$alias = "$dir/$a-h$hw_id";
			$sql = "update hw set alias='$alias' where hw_id=$hw_id";
			if($db->query($sql)){
				$ul++;
			}
		}
	}
	$sql = "select hw_id, hw_name from hw where alias is null";
	$hwlist = $db->getAll($sql);
	$dir = 'other';
	foreach ($hwlist as $hw) {
		$a = getAlias($hw['hw_name']);
		$hw_id = $hw['hw_id'];
		$alias = "$dir/$alias-h$hw_id";
		$sql = "update hw set alias='$alias' where hw_id=$hw_id";
		if($db->query($sql)){
			$ul++;
		}
	}
	$sql = 'update hw set html=0 where html=1 and hw_date < date_sub(now(), INTERVAL '.NEWDAYS.' DAY)';
	$db->query($sql);
	$db->commit();
	$tpl->clear_all_cache();
	echo "success:$ul";
?>