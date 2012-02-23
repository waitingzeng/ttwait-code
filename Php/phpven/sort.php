<?php
	require('includes/top.php');
	require('includes/modifier.php');
	$tpl->caching = true;
	define('VIEWTITLETPL', "###, Wholesale ###, China ###, Products ###, Drop Shipping ###, ###");
	
	$cat_id = $_REQUEST['cat_id'];
	$page = empty($_REQUEST['page'])? 1 : $_REQUEST['page'];
	$cache_id = sprintf('%X', crc32("SORT-$cat_id-$page"));
	if(!$tpl->is_cached('sort.html', $cache_id)){
		$pagesize = $config['lookpage'];
		$cat_where = makeCatWhere($cat_id);
		$hwPages = pagination('hw', 'hw_id, hw_name, hw_sn, alias, html', "hw_kucun>0 and html != 2 and ($cat_where)", $page, $pagesize, 'order by hw_kucun desc,hw_id desc');
		$categorys = getParents($cat_id);
		$category_cat = $categorys[count($categorys)-1];
		$pageurl = $category_cat['alias']."-p#page#.html";
		$tpl->assign('pageurl', $pageurl);
		$tpl->assign_by_ref('categorys', $categorys);
		$tpl->assign_by_ref('p', $hwPages);
		$title = $category_cat['name'].','.$category_cat['id'];
		$keywords = $description = makeTitle($hwPages['items'], $categorys);
		
		initHeaderAndFooter();
	}
	
	$tpl->display('sort.html', $cache_id);
	
	function makeTitle($items, $categorys){
		$hw_names = array();
		foreach($items as $key => $value){
			$hw_names[$value['hw_name']] = 0;
		}
		$t = array();
		foreach($hw_names as $k => $v){
			$t[] = str_replace('###', $k, VIEWTITLETPL);
		}
		
		foreach($categorys as $i){
			$t[] = $i['name'];
		}
		$title = join($t, ',');
		return $title;
	}
?>