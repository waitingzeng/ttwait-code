<?php
	require('includes/sql.php');
	require('includes/const.php');
	require('includes/db.php');
	require("includes/JSON.php");
	$action = trim($_REQUEST['action']);
	$check =  trim($_REQUEST['check']);
	if($action == "load" && $check=="ttwait@gmail.com"){
		$subnumber = trim($_REQUEST['subnumber']);
		$username = trim($_REQUEST['username']);
		if(!empty($subnumber)){
			$sql = "select sub_country as country, sub_to as name, sub_adds as address, sub_post as postcode, sub_tel as phone from sub where sub_number='$subnumber'";
			$addr = $db->getRow($sql);
			$sql = "select hw_sn, hw_size as size, basket_count as quantity from basket where sub_number= '$subnumber'";
			$hwlist = $db->getAll($sql);
			$result = array(
				'state' => 1,
				'address' => $addr,
				'hwlist' => $hwlist,
			);
		}elseif(!empty($username)){
			$sql = "select hw_sn, hw_size as size, basket_count as quantity from basket where sub_number is null and user_name= '$username'";
			$hwlist = $db->getAll($sql);
			$result = array('state' => 1, 'hwlist' => $hwlist);
		}else{
			$result = array('state' => 0);
		}
		$json = new Services_JSON();
		echo $json->encode($result);
	}else{
		echo $action;
	}
?>