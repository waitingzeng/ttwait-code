<?php session_start();?>
<?php
if(!$_POST['step']== '3'){
echo "<script>alert('请按步骤安装！');</script>";
echo "<script>javascript:window.location.href='./index.php';</script>";
}
?>
<?php
if($_POST['action']=="session"){
 $_SESSION['db']="";
 foreach($_POST as $key => $v){
	$_SESSION['db'][$key]=$v;
 }
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
<form id="form1" name="form1" method="post" action="3.php">
<input type="hidden" name="step" value="4" />
<input type="hidden" name="action" value="save" />
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
              <td width="110" class="STYLE1"><div align="left">填写网站信息:</div></td>
              <td width="580">
                <p>&nbsp;</p>
                <p>&nbsp;</p></td>
            </tr>
            <tr>
              <td><p class="STYLE1">网站名称：</p></td>
              <td>
                <label>
                  <input name="sitename" id="sitename" type="text" size="30" />
                  </label>
              </td>
            </tr>
            <tr>
              <td><p align="left" class="STYLE1">网站标题：</p></td>
              <td>
                <label>
                  <input name="sitetitle" id="sitetitle" type="text" size="30" />
                  </label>
              </td>
            </tr>
            <tr>
              <td><p align="left" class="STYLE1">管理员账号：</p></td>
              <td>
                <label>
                  <input name="adminac" id="adminac" type="text" size="30" />
                  </label>
              </td>
            </tr>
            <tr>
              <td><p align="left" class="STYLE1">管理员密码：</p></td>
              <td>
                <label>
                  <input name="adminpa" id="adminpa" type="text" size="30" />
                  </label>
              </td>
            </tr>
			 <tr>
              <td><p align="left" class="STYLE1">重复密码：</p></td>
              <td>
                <label>
                  <input name="readminpa" id="readminpa" type="text" size="30" />
                  </label>
              </td>
            </tr>
			 <tr>
              <td><p align="left" class="STYLE1">管理员邮箱：</p></td>
              <td>
                <label>
                  <input name="adminem" id="adminem" type="text" size="30" />
                  </label>
              </td>
            </tr>
			 <tr>
              <td><p align="left" class="STYLE1">联系方式：</p></td>
              <td>
                <label>
                  <input name="adminco" id="adminco" type="text" size="30" />
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
    <td><div align="center"><br><br><a href="javascript:history.back()"><img src="images/7.jpg" border="0" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:checksub()"><img src="images/8.jpg" width="119" height="35" border="0" /></a></div></td>
  </tr>
</table>
</form>
<script type="text/javascript">
	function $(id){
	return document.getElementById(id).value;
	}
	function checksub(){
	var str="";
	var pa1=$("adminpa");
	var pa2=$("readminpa");
	
	if(!$("sitename")) str+="网站名不能为空\n";
	if(!$("sitetitle")) str+="网站标题不能为空\n";
	if(!$("adminac")) str+="管理员帐号不能为空\n";
	if(!$("adminpa")) str+="管理员密码不能为空\n";
	if(!$("adminem")) str+="管理员邮箱不能为空\n";
	if(!$("adminco")) str+="联系方式不能为空\n";
	if(pa1 != pa2) str+="两次密码不一致\n";
	if(str!="") alert(str);
	else document.form1.submit();
	}
</script>

</body>
</html>
