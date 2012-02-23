<?php
	require('includes/ad_top.php');
	
	$action = trim($_REQUEST["action"]);
	$errmsg = array();
	$sql="select id, paypal, pay_paypal from payonline";
	$payonline = $db->getRow($sql, true);
	if($action == "change"){
		$pay_paypal = trim($_REQUEST['pay_paypal']);
		$paypal = intval($_REQUEST['paypal']);
		if($paypal == 1 && !isEmail($pay_paypal))
			$errmsg[] = __("请输入正确的paypal帐号");
		if(count($errmsg) == 0){
			$data = array(
				'paypal' => $paypal,
				'pay_paypal' => $pay_paypal,
			);
			if($db->autoExecute('payonline', $data, 'UPDATE', 'id='.$payonline['id'])){
				$errmsg[] = "Save Success";
				$payonline = $data;
			}
		}
	}
	$tpl->assign_by_ref('errmsg', join($errmsg, ''));
	$tpl->assign_by_ref('payonline', $payonline);
	$tpl->display('ad_payonline.html');
?>