<style type="text/css">
*{
font-size:12px;
}
.orange{
COLOR: #ff4600
}
.f14B{
font-size:14px;
font-weight:800}
</style>
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="8" colspan="3" align="center"></td>
  </tr>
  <tr>
    <td width="27%" rowspan="2" align="center" class="f14B">IP地址或域名</td>
    <td height="30" colspan="2">
	<div style="float:left;width:85px;">您当前的IP是:</div>
	<div style="float:left" id="locaIp">&nbsp;</div>
	<div style="clear:left;"></div>
	<div id="queryIp" style="height:25px;line-height:25px;"></div>
	</td>
  </tr>
  <tr>
    <form id="ipform" name="ipform" method="post" action="javascript:void(0)">
      <td width="39%" height="33"><input name="ip_url" type="text" class="socss" id="ip_url" size="28" />      </td>
      <td width="34%"><input name="Submit" type="submit" class="btn" value=" 查 询 " onclick="getipdata('queryip','queryIp')"/></td>
    </form>
  </tr>
  <tr>
    <td height="10" colspan="3" align="center"></td>
  </tr>
</table>
<script language="javascript">
function myObjRequest(){
	var myhttp=null;
	try {
		myhttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(ie) {
			    try{
					myhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch(huohu){
					myhttp = new XMLHttpRequest();
					}
			}
	return myhttp;
}

function getipdata(action,divname){
  var ip_url=document.getElementById("ip_url").value;
  var url="getip.php?action="+action+"&ip_url="+ip_url;
  //alert(url);
  var myObj=myObjRequest();
  myObj.open("GET",url,true);
  myObj.onreadystatechange=function(){
    if (myObj.readyState==4){
	  //alert(myObj.readyState);
	  if (myObj.status==200){ //读取的数据正确
	     document.getElementById(divname).innerHTML=myObj.responseText;
	  }
	  else {
	     document.getElementById(divname).innerHTML="获取本地IP出错,请刷新本页或联系管理员!";
	  }
	}
	else{
	  document.getElementById(divname).innerHTML="<div align='center'><img src=loading.gif></div>";
	}
  }
  myObj.send(null)
  }
getipdata("getip","locaIp");
</script>