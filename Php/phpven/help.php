<?php
	require('includes/top.php');
	$id = intval($_REQUEST["id"]);
	$typeid = intval($_REQUEST['typeid']);
	
	$cache_id = getCacheId("help-$typeid-$id");
	if(!$tpl->is_cached('help.html', $cache_id)){
		$type = 0;
		if($id != 0 || $typeid != 0){
			if($id != 0){
				$sql = "select * from book where id=$id";
				$book = $db->getRow($sql);
				$tpl->assign_by_ref('p', $book);
				$type = 1;
			}else{
				if($typeid != 0){
					$sql = "select typename from type where id=$typeid";
					$typename = $db->getOne($sql);
					if($typename){
						$type = 2;
						$sql="select * from book where typeid=$typeid order by id desc";
						$bslist = $db->getAll($sql);
						$tpl->assign_by_ref('bslist', $bslist);
						$tpl->assign('typename', $typename);
					}
				}
			}
		}
		$tpl->assign('type', $type);
		initHeaderAndFooter();
	}
	$tpl->display('help.html', $cache_id);
?>