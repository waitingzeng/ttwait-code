<?php
	require('includes/const.php');
	require('includes/db.php');
	require('includes/base.php');
	require('includes/function.php');
	require('includes/util.php');
	$username = checkLogin("orders.asp");
	
	if(empty($_REQUEST['sub_id']))die('ERROR');
	
	$action = trim($_REQUEST["action"]);
	$sub_id = trim($_REQUEST["sub_id"]);
	$alert = '';
	if($action == "zt"){
		if(!isset($_REQUEST['sub_zt']))die('ERROR');
		$zt = intval($_REQUEST["sub_zt"]);
		$sql = "update sub set sub_zt=$zt where sub_name='$username' and sub_id=$sub_id";
		$db->query($sql);
		$alert = alert("Sub State Change Success");
	}elseif($action == "del"){
		$sql = "delete from basket where user_name='$username' and sub_number=(select sub_number from sub where sub_zt=0 and sub_id=$sub_id)";
		$db->query($sql);
		$sql = "delete from sub where sub_zt=0 and sub_id=$sub_id";
		$db->query($sql);
	}
	$sql = "select * from sub where sub_name='$username' and sub_id=$sub_id";
	$sub = $db->getRow($sql);
	$tpl->assign_by_ref('sub', $sub);
	$promo = false;
	if($sub['promo']){
		$code = $sub['promo'];
		$sql = "select * from promo where code='$code'";
		$promo = $db->getRow($sql);
	}
	$sql = "select * from basket where user_name='$username' and sub_number='".$sub['sub_number']."'";
	$tpl->assign_by_ref('basketlist', $db->getAll($sql));

	$pay = $db->getRow("select * from pay where pay_id=".$sub['sub_pay']);
	$ps = $db->getRow("select * from ps where ps_id=".$sub['sub_ps']);
	$tpl->assign_by_ref('pay', $pay);
	$tpl->assign_by_ref('ps', $ps);
	$tpl->assign_by_ref('payonline', getPayOnline());
	$tpl->assign_by_ref('promo', $promo);
	
	$orderstate = array('Invalid','New','Paying','Payed','In Transit','Finished');
	$tpl->assign_by_ref('orderstate', $orderstate);
	$tpl->assign('pic_url', PIC_URL);
	$tpl->display('submore.html');
	echo $alert;
?>