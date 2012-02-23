<?php 
	//引用数据库文件
	require('includes/cls_mysql.php');
	
	//连接本地数据库
	$db = new cls_mysql(DB_HOST, DB_USER_NAME, DB_USER_PASS, DB_DATABASE);
?>