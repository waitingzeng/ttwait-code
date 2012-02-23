<?php 
	
	function pagination_modifier($totalpage, $pindex, $pageurl){
		$page_key = '#page#';
		if($totalpage <= 1)
			return "";
		global $tpl;
		$caching = $tpl->caching;
		$tpl->caching = false;
		if($pindex > 1){
			$tpl->assign('pagePrev', str_replace($page_key, $pindex-1, $pageurl));
		}
		if($pindex < $totalpage){
			$tpl->assign('pageNext', str_replace($page_key, $pindex+1, $pageurl));
		}
		$pagelist = array();
		$i = $pindex - 5;
		$i = $i <= 0 ? 1 : $i;
		while ($i <= $totalpage && $i < $pindex + 5) {
			$pagelist[$i] = str_replace($page_key, $i, $pageurl);
			$i += 1;
		}
		
		$tpl->assign_by_ref('pagelist', $pagelist);
		$tpl->assign_by_ref('pageurl', $pageurl);
		$tpl->assign('pindex', $pindex);
		$tpl->assign('totalpage', $totalpage);
		$result = $tpl->fetch('pagination.html');
		$tpl->caching = $caching;
		return $result;
	}
	$tpl->register_modifier('pagination', 'pagination_modifier', false);
?>