<?php
	require('includes/top.php');
	$cat_where = makeCatWhere(1158);
	$sql = "select hw_id, hw_name, hw_sn, hw.html,hw.alias, category.alias as cat_alias from hw, category where hw_kucun>0 and ($cat_where) order by rand() limit 0, ".INDEXTEJIANUM;
	$tejia = $db->getAll($sql);
	if(!$config['indexcode']){
		$where = '';
	}else{
		$indexcode = explode(',', $config['indexcode']);
		$a = array();
		foreach ($indexcode as $value) {
			$a[] = "code='$value'";
		}
		$a = join(' or ', $a);
		$where = "and cat_id in (select distinct id from category where depth=3 and parent in (select id from category where $a))";
	}
	#$where = INDEXSQL;
	$sql = "select hw_id, hw_name, hw_sn, alias, html from hw where html != 2 and hw_kucun>0 $where order by rand() limit 0, 30";
	$hwlist = $db->getAll($sql);
	$tpl->assign_by_ref('tejia', $tejia);
	$tpl->assign_by_ref('hwlist', $hwlist);
	
	initHeaderAndFooter();
	$result = $tpl->fetch('index.html');
	$fp = @fopen(ROOT_PATH.'/index.html', 'w');
	fwrite($fp, $result);
	fclose($fp);
	echo $result;
?>