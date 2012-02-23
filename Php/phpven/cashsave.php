<?php
	require('includes/top.php');
	$username = checkLogin("buy.asp");
		
	$sub_mail = trim($_REQUEST["sub_mail"]);
	$sub_frommail = trim($_REQUEST["sub_frommail"]);
	$sub_frompost = trim($_REQUEST["sub_frompost"]);
	$sub_post = trim($_REQUEST["sub_post"]);
	$promocode = trim($_REQUEST['promocode']);
	$promo = false;
	if(strlen($promocode) != 0){
		$sql = "select * from promo where state=1 and code='$promocode'";
		$promo = $db->getRow($sql);
	}
	if(!isEmail($sub_mail) || !isEmail($sub_frommail))
		alert("You fill in a wrong email address!", -1);
	if(strlen($sub_post) == 0)
		alert("You fill in a wrong sub zip post!", -1);
		
	$sql = "select count(basket_id) from basket where user_name='$username' and sub_number is null";
	$count = $db->getOne($sql);
	if($count != 0){
		$sub_number = date('YmdHis');
		$data = array(
			'sub_name' => $username,
			'sub_number' => $sub_number,
			'sub_date' => getTime(),
			'sub_zt' => '1',
			'sub_ps' => trim($_REQUEST['ps_id']),
			'sub_pay' => trim($_REQUEST['pay_id']),
			"sub_totime" => trim($_REQUEST["totime"]),
			"sub_fapiao" => trim($_REQUEST["fapiao"]),
			"sub_quehuo" => trim($_REQUEST["quehuo"]),
			"sub_other" => trim($_REQUEST["other"]),
			"sub_to" => trim($_REQUEST["sub_to"]),
			"sub_mail" => $sub_mail,
			"sub_tel" => trim($_REQUEST["sub_tel"]),
			"sub_adds" => trim($_REQUEST["sub_adds"]),
			"sub_post" => $sub_post,
			"sub_country" => trim($_REQUEST["sub_country"]),
			"sub_from" => trim($_REQUEST["sub_from"]),
			"sub_frommail" => $sub_frommail,
			"sub_fromtel" => trim($_REQUEST["sub_fromtel"]),
			"sub_fromadds" => trim($_REQUEST["sub_fromadds"]),
			"sub_frompost" => $sub_frompost,
			"sub_fromcountry" => trim($_REQUEST["sub_fromcountry"]),
			"sub_k" => 0,
			"sub_h" => 0,
		);
		if($promo)$data['promo'] = $promo['code'];
		$db->autoExecute('sub', $data);
		$tpl->assign_by_ref('sub', $data);
		$sql = "update basket set sub_number='$sub_number' , basket_check=1 where user_name='$username' and sub_number is null";
		$db->query($sql);
		$sql = "select basket.*,hw.alias from basket,hw where user_name='$username' and sub_number='$sub_number' and basket.hw_id=hw.hw_id";
		#$sql = "select basket.*,hw.alias from basket,hw where user_name='$username' and sub_number is null and basket.hw_id=hw.hw_id";
		$tpl->assign_by_ref('basketlist', $db->getAll($sql));
		$pay = $db->getRow("select * from pay where pay_id=".$data['sub_pay']);
		$ps = $db->getRow("select * from ps where ps_id=".$data['sub_ps']);
		$tpl->assign_by_ref('pay', $pay);
		$tpl->assign_by_ref('ps', $ps);
		$tpl->assign_by_ref('payonline', getPayOnline());
		$tpl->assign_by_ref('promo', $promo);
	}
	
	initHeaderAndFooter();
	return $tpl->display('cashsave.html');
?>