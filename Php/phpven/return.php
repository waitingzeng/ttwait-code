<?php
	$email = trim($_REQUEST['email']);
	$delete = trim($_REQUEST['delete']);
	$root = $_SERVER['DOCUMENT_ROOT'];
	
	if(!empty($email)){
		$fp = fopen("$root/return.txt",'a');
		fwrite($fp, "$email\n");
		fclose($fp);
	}
	if(!empty($delete)){
		if(unlink("$root/return.txt")){
			die('delete success');
		}
	}
?>
<p><b><?php echo $email?></b></p>
<p>Your email address in our mailing list had been delete<br>
We interrupt your great regret that!
</p>