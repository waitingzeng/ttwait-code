<?php session_start();?>
<?php
if(!$_POST['step']== '4'){
echo "<script>alert('�밴���谲װ��');</script>";
echo "<script>javascript:window.location.href='./index.php';</script>";
}
?>
<?php	
if($_POST['action']=="save"){
	$httphost="http://".$_SERVER['HTTP_HOST'];
	$allpagetitle=$_POST['sitetitle'];
	$sitename=$_POST['sitename'];
	
	$dbhost=$_SESSION['db']['dbhost'];
	$dbname=$_SESSION['db']['dbname'];
	$dbuser=$_SESSION['db']['dbuser'];
	$dbpwd=$_SESSION['db']['dbpwd'];
	
	
  	$fp = fopen("config.inc.txt","r");
  	$configStr2 = fread($fp,filesize("config.inc.txt"));
  	fclose($fp);
	print_r($configStr2);
	
    $configStr2 = str_replace("~HTTP_HOST~",$httphost,$configStr2);
	$configStr2 = str_replace("~AllPageTitle~",$allpagetitle,$configStr2);
	$configStr2 = str_replace("~ADMIN_MAIN_SITE_NAME~",$sitename,$configStr2);
	
    $configStr2 = str_replace("~cfg_dbhost~",$dbhost,$configStr2);
	$configStr2 = str_replace("~cfg_dbname~",$dbname,$configStr2);
	$configStr2 = str_replace("~cfg_dbuser~",$dbuser,$configStr2);
	$configStr2 = str_replace("~cfg_dbpwd~",$dbpwd,$configStr2);

  //@chmod(ROOT.'/data',0777);
  	$fp1 = fopen("../config/config.inc.php","w") or die("<script>alert('д������ʧ�ܣ�����../configĿ¼�Ƿ��д�룡');history.go(-1);</script>");
  	fwrite($fp1,$configStr2);
  	fclose($fp1);
	
	//$of2 = fopen('../config/config.inc.php','w');//��������dir.txt
	//if($of2){
	//	 fwrite($of2,$configStr2);//��ִ���ļ��Ľ��д���ļ�
	//}
	//fclose($of2);
}
?>
<?
if($_POST['action']=="save"){
	$dbhost=$_SESSION['db']['dbhost'];
	$dbname=$_SESSION['db']['dbname'];
	$dbuser=$_SESSION['db']['dbuser'];
	$dbpwd=$_SESSION['db']['dbpwd'];

  	$fp2 = fopen("common.inc.txt","r");
  	$configStr1 = fread($fp2,filesize("common.inc.txt"));
  	fclose($fp2);
	print_r($configStr1);

    $configStr1 = str_replace("~cfg_dbhost~",$dbhost,$configStr1);
	$configStr1 = str_replace("~cfg_dbname~",$dbname,$configStr1);
	$configStr1 = str_replace("~cfg_dbuser~",$dbuser,$configStr1);
	$configStr1 = str_replace("~cfg_dbpwd~",$dbpwd,$configStr1);
	
  //@chmod(ROOT.'/data',0777);
  	$fp3 = fopen("../config/common.inc.php","w") or die("<script>alert('д������ʧ�ܣ�����../configĿ¼�Ƿ��д�룡');history.go(-1);</script>");
  	fwrite($fp3,$configStr1);
  	fclose($fp3);
	//$of = fopen('../config/common.inc.php','w');//��������dir.txt
	//if($of){
	//	 fwrite($of,$configStr1);//��ִ���ļ��Ľ��д���ļ�
	//}
	//fclose($of);

	require_once("../config/common.inc.php");
	require_once("./installdbclass.php");
	require_once("./sql.class.php");
	$er=install("../config/databakup.txt",$dbname);
	$er1=sqls("../config/datainsert6.txt");
	$adminquery = array(
	'username' => iconv("GBK","utf-8",$_POST['adminac']),
	'pass' => iconv("GBK","utf-8",$_POST['adminpa']),
	'email' => iconv("GBK","utf-8",$_POST['adminem']),
	'phoneno' => iconv("GBK","utf-8",$_POST['phoneno']),
	'type' => 1
	);
	$db->insert("auction_admin", $adminquery);
	
}
	if($er && $er1){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>��л��ѡ�� PIIKEE�Ŀ;��Ĺ���ϵͳ</title>
<style type="text/css">
*{ margin-top:0px;}
.STYLE1 {font-size: 14px}
</style>
</head>

<body>
<table width="853" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="images/1.jpg" width="853" height="58" /></td>
  </tr>
  <tr>
    <td><img src="images/2.jpg" width="853" height="40" /></td>
  </tr>
</table>
<table width="853" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="images/3.jpg" width="853" height="17" /></td>
  </tr>
  <tr>
    <td background="images/4.jpg"><table width="786" border="0" align="center">
      <tr>
        <td><div align="center"><br><br>
          ���Ѿ��ɹ���װ�Ŀͣ�PiiKee������ϵͳ����������Խ��������վ<br><br><br><br><a href="../index.php">������վǰ̨</a>    &nbsp;&nbsp;&nbsp; <a href="../siteadmin">������վ��̨</a><br><br><br></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="images/5.jpg" width="853" height="16" /></td>
  </tr>
</table>
</body>
</html>
<?php ;}else{?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>��л��ѡ�� PIIKEE�Ŀ;��Ĺ���ϵͳ</title>
<style type="text/css">
*{ margin-top:0px;}
.STYLE1 {font-size: 14px}
</style>
</head>

<body>
<table width="853" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="images/1.jpg" width="853" height="58" /></td>
  </tr>
  <tr>
    <td><img src="images/2.jpg" width="853" height="40" /></td>
  </tr>
</table>
<table width="853" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="images/3.jpg" width="853" height="17" /></td>
  </tr>
  <tr>
    <td background="images/4.jpg"><table width="786" border="0" align="center">
      <tr>
        <td><div align="center"><br><br>
          �Բ��𣬰�װʧ�ܣ��������ݿ����ӵ���Ϣ�Ƿ���ȷ��Ȼ�����°�װ<br><br><br><br><br><br><br></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="images/5.jpg" width="853" height="16" /></td>
  </tr>
</table>
</body>
</html>
<?php ;}?>