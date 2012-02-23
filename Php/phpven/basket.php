<?php
	require('includes/sql.php');
	require('includes/const.php');
	require('includes/db.php');
	require('includes/function.php');
	require('includes/util.php');
	
	$hw_id = intval($_REQUEST['hw_id']);
	if($hw_id <= 0){
		die('ERROR');
	}
	$sql = "select hw_sn, hw_name, hw_kucun, sizelist,html,alias from hw where hw_id=$hw_id";
	$hw = $db->getRow($sql);
	if($hw == 0){
		die('ERROR');
	}
	$url = SERVERPATH.$hw['alias'].".html";
	if($hw['hw_kucun'] == 0){
		alert("Out Of Stock!", $url);
	}
	$username = checkLogin($url);
	$error = true;
	$kxa = split('/', $hw['sizelist']);
	$i = 0;
	while ($i<count($kxa)) {
		$kxa_i = $kxa[$i];
		$kxa_j = str_replace('.', '_', $kxa_i);
		if(get_magic_quotes_gpc()){
			$kxa_j = addslashes($kxa_j);
		}
		$qua = $_POST["quantity$kxa_j"];
		$qua = intval($qua);
		if($qua > 0){
			$error = false;
			$where="hw_id=$hw_id and hw_size='$kxa_i' and user_name='$username' and basket_check=0";
			$ct = $db->count('basket', $where);
			if($ct == 0){
				$data = array(
					'hw_id' => $hw_id,
					'user_name' => $username,
					'basket_count' => $qua,
					'hw_name' => $hw['hw_name'],
					'hw_sn' => $hw['hw_sn'],
					'hw_size' => addslashes($kxa_i),
					'hw_jifen' => 0,
					'basket_check' => 0,
					'basket_date' => getTime(),
				);
				$db->autoExecute('basket', $data);
			}else{
				$db->query("update basket set basket_count=basket_count+$qua where $where");
			}
		}
		$i+=1;
	}
	if($error)
		alert('Please fill how many do you want to buy', -1);
	else{
		modifyPrice($username);
		redirect('buy.asp');
	}
?>