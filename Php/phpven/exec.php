<?php
	require('includes/const.php');
	require('includes/util.php');
	require('includes/ad_util.php');
	
	checkAdminLogin();
	
	require('includes/db.php');
	function changeprice($matches){
		$str = $matches[0];
		$pricelist = $matches[1];
		$l = explode('/', $pricelist);
		$l1 = array();
		foreach ($l as $value) {
			$ll[] = ceil($value * PRICEUP);
		}
		return str_replace($pricelist, join($ll, '/'), $str);
	}
	$check = trim($_REQUEST['check']);
	$action = trim($_REQUEST['action']);
	if($check == "little_fox@163.com"){
		if($action == "syn"){
			$syn = $_REQUEST['syn'];
			if(get_magic_quotes_gpc()){
				$syn = stripcslashes($syn);
			}
			$syn = str_replace(';\r\n', ';\n', $syn);
			$arr = explode(';', $syn);
			$re_hw_insert = "/insert into hw.*'([^']*)'\)/i";
			$re_hw_update = "/update hw set.*pricelist='(.*?)'.*/i";
			$error = false;
			$js = false;
			//$db->begin();
			$q = 0;
			foreach ($arr as $value) {
				$value = trim($value);
				if(strlen($value) == 0)continue;
				if(defined('PRICEUP')){
					$value = preg_replace_callback($re_hw_insert, 'changeprice', $value);
					$value = preg_replace_callback($re_hw_update, 'changeprice', $value);
				}
				if(stripos($value, "parentpath=parentpath+format(id)+") !== false){
					$js = true;
					$q++;
					continue;	
				}
				$value = str_replace("insert into hw", "insert ignore into hw", $value);
				if($db->query($value)){
					$q++;
				}
				if(stripos($value, 'category') !== false){
					$js = true;
				}
			}
			if($js)$db->query("update category set parentpath=CONCAT(parentpath,id,',') where INSTR(parentpath,id)=0");
			//$db->commit();
			$sql = 'select hw_id from hw order by hw_id desc';
			$hw_id = $db->getOne($sql, true);
			$cat_id = $db->getOne('select id from category order by id desc', true);
			$str = count($arr).", $q, $hw_id, $cat_id";
			echo $str;
		}else{
	?>
	<form action="exec.asp?action=syn&check=little_fox@163.com" method="post">
	  <p>
	      <textarea cols="50" rows="10" name="syn"></textarea>
      </p>
	  <p>  
	    <input type="submit" name="submit" value="submit" />
        </p>
	</form>
	<?php
	}
	}else{
		echo "访问出错".$check;	
	}
?>