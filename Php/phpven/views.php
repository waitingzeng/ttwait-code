<?php 
	require('includes/top.php');
	require('includes/modifier.php');
	
	define('VIEWTITLETPL', "###, Wholesale ###, China ###, Products ###, Drop Shipping ###, ###");
	
	$hw_id = $_REQUEST['hw_id'];
	$hw = getHw($hw_id);
	$tpl->assign_by_ref('hw', $hw);

	$keywords = $description = $title = str_replace('###', $hw['hw_name'], VIEWTITLETPL).','.$hw['hw_id'];

	$tpl->assign_by_ref('categorys', getParents($hw['cat_id']));
	
	initHeaderAndFooter();
	
	$tpl->display('views.html');
	
	function getHw($hw_id){
		if(!$hw_id || $hw_id < 0)
			return null;
		$hw = $GLOBALS['db']->getRow("select * from hw where hw_id=$hw_id and html != 2");
		if(!$hw){
			return 0;
		}
		$qualist = $hw['qualist'];
		if(!$qualist) $qualist = DEFAULTQUALIST;
		$qualist = split('/', $qualist);
		$result = array();
		foreach ($qualist as $key=>$item){
			if($key == 0){
				$result[] = $item;
			}else{
				$result[] = ($qualist[$key-1]+1).'-'.$item;
			}
		}
		$result[] = '>'.$qualist[$key];
		$hw['qualist'] = $result;
		$hw['qualist_length'] = count($hw['qualist']);
		$hw['pricelist'] = split('/', $hw['pricelist']);
		$hw['sizelist'] = split('/', $hw['sizelist']);
		
		if(!$hw['hw_content2']){
			$title = str_replace('###', '<strong>'.$hw['hw_name'].'</strong>', VIEWTITLETPL);
			$hw['hw_content2'] = str_replace('##keyword##', $title, $GLOBALS['config']['defaulthwdetail']);
			$hw['hw_content2'] = str_replace('###', '<strong>'.$hw['hw_name'].'</strong>', $hw['hw_content2']);
		}
		return $hw;
	}
?>