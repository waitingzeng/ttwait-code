<?php
	require('includes/ad_top.php');
	
	$action = trim($_REQUEST["action"]);
	$errmsg = array();
	if($action == "addname"){
		$code1 = trim($_REQUEST["code1"]);
		$type1 = trim($_REQUEST["type1"]);
		$num1 = trim($_REQUEST["num1"]);
		if(strlen($code1) == 0)$errmsg[] = __("优惠码不能为空");
		elseif(strlen($num1) == 0)$errmsg[] = __("数量不能为0");
		else{
			$where = "code='$code1'";
			$count = $db->count('promo', $where);
			if($count != 0){
				$errmsg[] = __("优惠码已经存在!");
			}else{	
				$data = array(
					'code' => $code1,
					'num' => $num1,
					'type' => $type1,
					'state' => 1,
				);
				$db->autoExecute('promo', $data);
				$errmsg[] ="Add Success";
			}
		}
	}elseif($action=="mod"){
		$id = intval($_REQUEST["id"]);
		$code = trim($_POST["code"]);
		$type = trim($_POST["type"]);
		$num = trim($_POST["num"]);
		$state = trim($_POST["state"]);
		if($id == 0)$errmsg[] = __("请不要非法操作");
		elseif(strlen($code) == 0)$errmsg[] = __("优惠码不能为空");
		else{
			$data = array(
				'code' => $code,
				'type' => $type,
				'num' => $num,
				'state' => $state,
			);
			$db->autoExecute('promo', $data, 'UPDATE', "id=$id");
			$errmsg[] = "Modify Success";
		}
	}elseif($action=="del"){
		$id = intval($_REQUEST["id"]);
		if($id == 0)$errmsg[] = __("请不要非法操作");
		else{
			$sql = "delete from promo where id=$id";
			$db->query($sql);
		}
	}
	$sql = "select * from promo";
	$tpl->assign_by_ref('promolist', $db->getAll($sql));
	$tpl->assign_by_ref('errmsg', join($errmsg,''));
	$tpl->display('ad_promo.html');
?>