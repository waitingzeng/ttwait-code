<?php
	require('includes/top.php');
	$username = checkLogin('buy.asp');
	
	$action = $_REQUEST['action'];
	if($action){
		$basket_id = intval($_REQUEST['basket_id']);
		if($basket_id == 0)
			alert("ERROR", -1);
		switch ($action) {
			case "change":
				$ct = intval($_REQUEST['count']);
				if($ct == 0)
					break;
				$sql = "update basket set basket_count=$ct where basket_id=$basket_id and user_name='$username' and sub_number is null";
				$db->query($sql);
				modifyPrice($username);
				break;
			case "del":
				$sql="delete from basket where user_name='$username' and basket_id=$basket_id and sub_number is null";
				$db->query($sql);
				modifyPrice($username);
			default:
				break;
		}
	}
	$sql = "select basket.*, hw.alias from basket,hw where user_name='$username' and sub_number is null and basket.hw_id=hw.hw_id";
	$result = $db->getAll($sql);
	$tpl->assign_by_ref('basketlist', $result);	
	
	initHeaderAndFooter();
	
	$tpl->display('buy.html');
?>