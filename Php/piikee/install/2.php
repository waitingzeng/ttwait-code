<?php session_start();?>
<?php
if(!$_POST['step']== '3'){
echo "<script>alert('�밴���谲װ��');</script>";
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
<title>��л��ѡ�� PIIKEE�Ŀ;��Ĺ���ϵͳ</title>
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
              <td width="110" class="STYLE1"><div align="left">��д��վ��Ϣ:</div></td>
              <td width="580">
                <p>&nbsp;</p>
                <p>&nbsp;</p></td>
            </tr>
            <tr>
              <td><p class="STYLE1">��վ���ƣ�</p></td>
              <td>
                <label>
                  <input name="sitename" id="sitename" type="text" size="30" />
                  </label>
              </td>
            </tr>
            <tr>
              <td><p align="left" class="STYLE1">��վ���⣺</p></td>
              <td>
                <label>
                  <input name="sitetitle" id="sitetitle" type="text" size="30" />
                  </label>
              </td>
            </tr>
            <tr>
              <td><p align="left" class="STYLE1">����Ա�˺ţ�</p></td>
              <td>
                <label>
                  <input name="adminac" id="adminac" type="text" size="30" />
                  </label>
              </td>
            </tr>
            <tr>
              <td><p align="left" class="STYLE1">����Ա���룺</p></td>
              <td>
                <label>
                  <input name="adminpa" id="adminpa" type="text" size="30" />
                  </label>
              </td>
            </tr>
			 <tr>
              <td><p align="left" class="STYLE1">�ظ����룺</p></td>
              <td>
                <label>
                  <input name="readminpa" id="readminpa" type="text" size="30" />
                  </label>
              </td>
            </tr>
			 <tr>
              <td><p align="left" class="STYLE1">����Ա���䣺</p></td>
              <td>
                <label>
                  <input name="adminem" id="adminem" type="text" size="30" />
                  </label>
              </td>
            </tr>
			 <tr>
              <td><p align="left" class="STYLE1">��ϵ��ʽ��</p></td>
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
	
	if(!$("sitename")) str+="��վ������Ϊ��\n";
	if(!$("sitetitle")) str+="��վ���ⲻ��Ϊ��\n";
	if(!$("adminac")) str+="����Ա�ʺŲ���Ϊ��\n";
	if(!$("adminpa")) str+="����Ա���벻��Ϊ��\n";
	if(!$("adminem")) str+="����Ա���䲻��Ϊ��\n";
	if(!$("adminco")) str+="��ϵ��ʽ����Ϊ��\n";
	if(pa1 != pa2) str+="�������벻һ��\n";
	if(str!="") alert(str);
	else document.form1.submit();
	}
</script>

</body>
</html>
