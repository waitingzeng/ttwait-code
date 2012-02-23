<?php
	require('includes/ad_top.php');
	
	$action = trim($_REQUEST["action"]);
	$sub_id = intval($_REQUEST["sub_id"]);
	if($sub_id == 0)die('Error');
	if($action == "zt"){
		$zt = intval($_REQUEST["sub_zt"]);
		$sql = "update sub set sub_zt=$zt where sub_id=$sub_id";
		$db->query($sql);
		alert("Sub State Change Success", -1);
	}elseif($action == "del"){
		$sql = "delete from basket where sub_number=(select sub_number from sub where sub_id=$sub_id)";
		if($db->query($sql)){
			$sql = "delete from sub where sub_id=$sub_id";
			if($db->query($sql)){
				$db->commit();
				redirect('ad_sub.asp');
			}
		}
	}elseif($action == 'price'){
		$sub_number = trim($_REQUEST["sub_number"]);
		modifyPrice('', sub_number);
		alert('renew price success', -1);
	}
	$sql = "select * from sub where sub_id=$sub_id";
	$sub = $db->getRow($sql);
	
	if($sub != 0 ){
		$tpl->assign_by_ref('sub', $sub);
		$sql = "select * from basket where sub_number='".$sub['sub_number']."'";
		$tpl->assign_by_ref('basketlist', $db->getAll($sql));
		$pay = $db->getRow("select * from pay where pay_id=".$sub['sub_pay']);
		$ps = $db->getRow("select * from ps where ps_id=".$sub['sub_ps']);
		$tpl->assign_by_ref('pay', $pay);
		$tpl->assign_by_ref('ps', $ps);
		$promo = false;
		if($sub['promo']){
			$code = $sub['promo'];
			$sql = "select * from promo where code='$code'";
			$promo = $db->getRow($sql);
		}
		$tpl->assign_by_ref('promo', $promo);
	}
	$orderstate = array(__('无效订单'), __('未 处 理'),__('已 付 款'),__('已 收 款'),__('已 发 货'),__('已 收 货'));
	$tpl->assign_by_ref('orderstate', $orderstate);
	$tpl->display('ad_submore.html');

?>