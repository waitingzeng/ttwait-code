<?php
if(!$_POST['step']== '2'){
echo "<script>alert('对不起，您还没同意本程序服务条款，必须同意后方可安装');</script>";
echo "<script>javascript:window.location.href='./index.php';</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>感谢您选择 PIIKEE拍客竞拍管理系统</title>
<style type="text/css">
*{ margin-top:0px;}
.STYLE1 {font-size: 14px}
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="2.php">
<input type="hidden" name="action" value="session" />
<input type="hidden" name="step" value="3" />
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
        <td><br>
          <table width="700" border="0" align="center">
            <tr>
              <td width="110" class="STYLE1"><div align="left">填写数据库信息:</div></td>
              <td width="580">
                <p>&nbsp;</p>
                <p>&nbsp;</p></td>
            </tr>
            <tr>
              <td><p class="STYLE1">主机名： </p></td>
              <td>
                <label>
                  <input name="dbhost" type="text" id="dbhost" value="localhost" />
                  </label>
              </td>
            </tr>
            <tr>
              <td><p align="left" class="STYLE1">用户名： </p></td>
              <td>
                <label>
                  <input name="dbuser" type="text" id="dbuser" />
                  </label>
              </td>
            </tr>
            <tr>
              <td><p align="left" class="STYLE1">密&nbsp; 码：</p></td>
              <td>
                <label>
                  <input name="dbpwd" type="text" id="dbpwd" />
                  </label>
              </td>
            </tr>
            <tr>
              <td><p align="left" class="STYLE1">数据库名： </p></td>
              <td>
                <label>
                  <input name="dbname" type="text" id="dbname" />
                  </label>
              </td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="images/5.jpg" width="853" height="16" /></td>
  </tr>
</table>
<table width="853" border="0" align="center">
  <tr>
    <td><div align="center"><br><br><a href="index.php"><img src="images/7.jpg" border="0" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:checksub()"><img src="images/6.jpg" width="118" height="37" border="0" /></a></div></td>
  </tr>
</table>
</form>
<script type="text/javascript">
	function $(id){
	return document.getElementById(id).value;
	}
	function checksub(){
	var str="";
	if(!$("dbhost")) str+="主机名不能为空\n";
	if(!$("dbuser")) str+="用户名不能为空\n";
	if(!$("dbpwd")) str+="密码不能为空\n";
	if(!$("dbname")) str+="数据库不能为空\n";
	if(str!="") alert(str);
	else document.form1.submit();
	}
</script>
</body>
</html>
