<?php
	require_once('data.php');
	
	function saveData($data){
		$path = pathinfo(__FILE__);
		$path = $path['dirname'];
		$str = array();
		$str[] = "<?php\n";
		$str[] = '$data=array();'."\n";
		if(count($data) > 0){
			foreach ($data as $k=>$v){
				$str[] = '$data[] = '."'$v';\n";
			}
		}
		$str[] = '?>';
		$fp = fopen($path.'\data.php', 'w');
		fwrite($fp, join('', $str));
		fclose($fp);
	}
	
	$username = 'ttwait';
	$password = '846266';
	$hadLogin = false;
	if($_COOKIE['user'] == $username){
		$hadLogin = True;
	}
	$action = $_REQUEST['action'];
	if($action == 'login'){
		$_user = $_REQUEST['user'];
		$_pass = $_REQUEST['pass'];
		if($_user == $username && $_pass == $password){
			setcookie('user', $_user);
			$hadLogin = True;
		}
	}elseif ($action == 'del'){
		$macid = $_REQUEST['macid'];
		$data2 = array();
		foreach ($data as $k => $v){
			if($v == $macid){
				continue;
			}
			$data2[] = $v;
		}
		$data = $data2;
		saveData($data);
		echo 'del success';
	}elseif($action == 'add'){
		$macid = trim($_REQUEST['macid']);
		if($macid){
			if(in_array($macid, $data)){
				echo 'macid had esists';
			}else{
				$data[] = $macid;
				saveData($data);
				echo 'add success';
			}
		}else{
			echo 'macid must not empty';
		}
		
	}
	if(!$hadLogin):
?>
<form action="cheadmin.php?action=login" method="POST">
	<label for="user">UserName:</label><input type="input" name="user" size="20"><br/>
	<label for="pass">Password:</label><input type="password" name="pass" size="20"><br/>
	<input type="submit" name="submit" value="Submit"/>
</form>
<?php
	else:
?>
<form action="cheadmin.php?action=add" method="POST">
	<label for="user">Macid:</label><input type="input" name="macid" size="20"><br/>
	<input type="submit" name="submit" value="Submit"/>
</form>
<table>
	<tr>
		<td>Id</td>
		<td>macid</td>
		<td>oper</td>
	</tr>
	<?php foreach ($data as $k=>$v): ?>
	<tr>
		<td><?php echo $k; ?></td>
		<td><?php echo $v; ?></td>
		<td><a href="cheadmin.php?action=del&macid=<?php echo $v;?>">del</a></td>
	</tr>
	<?php endforeach;?>
</table>
<?php
	endif;
?>