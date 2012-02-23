<?php
	require('includes/ad_top.php');
	
	$action = trim($_REQUEST["action"]);
	$errmsg = array();
	if($action == "addname"){
		$admin_name1 = trim($_REQUEST["admin_name1"]);
		$admin_pass1 = trim($_REQUEST["admin_pass1"]);
		if(strlen($admin_name1) == 0)$errmsg[] = __("管理员用户名不能为空");
		elseif(strlen($admin_pass1) == 0)$errmsg[] = __("管理员密码不能为空");
		else{
			$where = "admin_name='$admin_name1'";
			$count = $db->count('admin', $where);
			if($count != 0){
				$errmsg[] = __("管理员已经存在!");
			}else{	
				$data = array(
					'admin_name' => $admin_name1,
					'admin_pass' => md5($admin_pass1),
				);
				$db->autoExecute('admin', $data);
				$errmsg[] ="Add Success";
			}
		}
	}elseif($action=="mod"){
		$admin_id = intval($_REQUEST["admin_id"]);
		$admin_name = trim($_POST["admin_name"]);
		$admin_pass = trim($_POST["admin_pass"]);
		if($admin_id == 0)$errmsg[] = __("请不要非法操作");
		elseif(strlen($admin_name) == 0)$errmsg[] = __("管理员用户名不能为空");
		else{
			$data = array(
				'admin_name' => $admin_name,
			);
			if(strlen($admin_pass) != 0)
				$data['admin_pass'] = md5($admin_pass);
			$db->autoExecute('admin', $data, 'UPDATE', "admin_id=$admin_id");
			$errmsg[] = "Modify Success";
		}
	}elseif($action=="del"){
		$admin_id = intval($_REQUEST["admin_id"]);
		if($admin_id == 0)$errmsg[] = __("请不要非法操作");
		else{
			$sql = "delete from admin where admin_id=$admin_id";
			$db->query($sql);
		}
	}
	$sql = "select * from admin";
	$tpl->assign_by_ref('adminlist', $db->getAll($sql));
	$tpl->assign_by_ref('errmsg', join($errmsg,''));
	$tpl->display('ad_admin.html');
?>