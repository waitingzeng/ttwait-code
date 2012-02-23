<?php
	require('includes/sql.php');
	require('includes/const.php');
	require('includes/db.php');
	
	$hw_id = intval($_REQUEST['hw_id']);
	$hw_sn = trim($_REQUEST['hw_sn']);
	$items = trim($_REQUEST['items']);
	if($hw_id <= 0 && empty($hw_sn))
		echo '';
	else{
		if($hw_id){
			if(empty($items)) $items='hw_sn';
			$sql = "select $items from hw where hw_id=$hw_id";
		}else
			$sql = "select $items from hw where hw_sn='$hw_sn'";

		$result = $db->getOne($sql);
		echo $result;
	}
?>