

<?
session_start();
global $mysqlhost, $mysqluser, $mysqlpwd, $mysqldb;
$mysqlhost="localhost"; //host name
$mysqluser="root";              //login name
$mysqlpwd="846266";              //password
$mysqldb="zencart2";        //name of database

include("mydb.php");
$d=new db($mysqlhost,$mysqluser,$mysqlpwd,$mysqldb);

/******����*/if(!$_POST['act']&&!$_SESSION['data_file']){/**********************/
$msgs[]="�������ڻָ��������ݵ�ͬʱ����ȫ������ԭ�����ݣ���ȷ���Ƿ���Ҫ�ָ����������������ʧ";
$msgs[]="���ݻָ�����ֻ�ָܻ���dShop�����������ļ����������������ʽ�����޷�ʶ��";
$msgs[]="�ӱ��ػָ�������Ҫ������֧���ļ��ϴ�����֤���ݳߴ�С�������ϴ������ޣ�����ֻ��ʹ�ôӷ������ָ�";
$msgs[]="�����ʹ���˷־��ݣ�ֻ���ֹ������ļ���1�����������ļ�����ϵͳ�Զ�����";
show_msg($msgs);
?>
<form action="" method="post" enctype="multipart/form-data" name="restore.php">
<table width="91%" border="0" cellpadding="0" cellspacing="1">
<tr align="center" class="header"><td colspan="2" align="center">���ݻָ�</td></tr>
<tr><td width="33%"><input type="radio" name="restorefrom" value="server" checked>
�ӷ������ļ��ָ� </td><td width="67%"><select name="serverfile">
    <option value="">-��ѡ��-</option>
<?
$handle=opendir('./backup');
while ($file = readdir($handle)) {
    if(eregi("^[0-9]{8,8}([0-9a-z_]+)(\.sql)$",$file)) echo "<option value='$file'>$file</option>";}
closedir($handle); 
?>
  </select> </td></tr>
<tr><td><input type="radio" name="restorefrom" value="localpc">       �ӱ����ļ��ָ�</td>
<td><input type="hidden" name="MAX_FILE_SIZE" value="1500000"><input type="file" name="myfile"></td></tr>
<tr><td colspan="2" align="center"> <input type="submit" name="act" value="�ָ�"></td>  </tr></table></form>


<?/**************************�������*/}/*************************************/
/****************************������*/if($_POST['act']=="�ָ�"){/**************/
/***************�������ָ�*/if($_POST['restorefrom']=="server"){/**************/
if(!$_POST['serverfile'])
	{$msgs[]="��ѡ��ӷ������ļ��ָ����ݣ���û��ָ�������ļ�";
	 show_msg($msgs); pageend();	}
if(!eregi("_v[0-9]+",$_POST['serverfile']))
	{$filename="./backup/".$_POST['serverfile'];
	if(import($filename)) $msgs[]="�����ļ�".$_POST['serverfile']."�ɹ��������ݿ�";
	else $msgs[]="�����ļ�".$_POST['serverfile']."����ʧ��";
	show_msg($msgs); pageend();		
	}
else
	{
	$filename="./backup/".$_POST['serverfile'];
	if(import($filename)) $msgs[]="�����ļ�".$_POST['serverfile']."�ɹ��������ݿ�";
	else {$msgs[]="�����ļ�".$_POST['serverfile']."����ʧ��";show_msg($msgs);pageend();}
	$voltmp=explode("_v",$_POST['serverfile']);
	$volname=$voltmp[0];
	$volnum=explode(".sq",$voltmp[1]);
	$volnum=intval($volnum[0])+1;
	$tmpfile=$volname."_v".$volnum.".sql";
	if(file_exists("./backup/".$tmpfile))
		{
		$msgs[]="������3���Ӻ��Զ���ʼ����˷־��ݵ���һ���ݣ��ļ�".$tmpfile."�������ֶ���ֹ��������У��������ݿ�ṹ����";
		$_SESSION['data_file']=$tmpfile;
		show_msg($msgs);
		sleep(3);
		echo "<script language='javascript'>"; 
		echo "location='restore.php';"; 
		echo "</script>"; 
		}
	else
		{
		$msgs[]="�˷־���ȫ������ɹ�";
		show_msg($msgs);
		}
	}
/**************�������ָ�����*/}/********************************************/
/*****************���ػָ�*/if($_POST['restorefrom']=="localpc"){/**************/
	switch ($_FILES['myfile']['error'])
	{
	case 1:
	case 2:
	$msgs[]="���ϴ����ļ����ڷ������޶�ֵ���ϴ�δ�ɹ�";
	break;
	case 3:
	$msgs[]="δ�ܴӱ��������ϴ������ļ�";
	break;
	case 4:
	$msgs[]="�ӱ����ϴ������ļ�ʧ��";
	break;
    case 0:
	break;
	}
	if($msgs){show_msg($msgs);pageend();}
$fname=date("Ymd",time())."_".sjs(5).".sql";
if (is_uploaded_file($_FILES['myfile']['tmp_name'])) {
    copy($_FILES['myfile']['tmp_name'], "./backup/".$fname);}

if (file_exists("./backup/".$fname)) 
	{
	$msgs[]="���ر����ļ��ϴ��ɹ�";
	if(import("./backup/".$fname)) {$msgs[]="���ر����ļ��ɹ��������ݿ�"; unlink("./backup/".$fname);}
	else $msgs[]="���ر����ļ��������ݿ�ʧ��";
	}
else ($msgs[]="�ӱ����ϴ������ļ�ʧ��");
show_msg($msgs);
/****���ػָ�����*****/}/****************************************************/
/****************************���������*/}/**********************************/
/*************************ʣ��־��ݻָ�**********************************/
if(!$_POST['act']&&$_SESSION['data_file'])
{
	$filename="./backup/".$_SESSION['data_file'];
	if(import($filename)) $msgs[]="�����ļ�".$_SESSION['data_file']."�ɹ��������ݿ�";
	else {$msgs[]="�����ļ�".$_SESSION['data_file']."����ʧ��";show_msg($msgs);pageend();}
	$voltmp=explode("_v",$_SESSION['data_file']);
	$volname=$voltmp[0];
	$volnum=explode(".sq",$voltmp[1]);
	$volnum=intval($volnum[0])+1;
	$tmpfile=$volname."_v".$volnum.".sql";
	if(file_exists("./backup/".$tmpfile))
		{
		$msgs[]="������3���Ӻ��Զ���ʼ����˷־��ݵ���һ���ݣ��ļ�".$tmpfile."�������ֶ���ֹ��������У��������ݿ�ṹ����";
		$_SESSION['data_file']=$tmpfile;
		show_msg($msgs);
		sleep(3);
		echo "<script language='javascript'>"; 
		echo "location='restore.php';"; 
		echo "</script>"; 
		}
	else
		{
		$msgs[]="�˷־���ȫ������ɹ�";
		unset($_SESSION['data_file']);
		show_msg($msgs);
		}
}
/**********************ʣ��־��ݻָ�����*******************************/
function import($fname)
{global $d;
$sqls=file($fname);
foreach($sqls as $sql)
	{
	str_replace("\r","",$sql);
	str_replace("\n","",$sql);
	if(!$d->query(trim($sql))) return false;
	}
return true;
}
function show_msg($msgs)
{
$title="��ʾ��";
echo "<table width='100%' border='1'  cellpadding='0' cellspacing='1'>";
echo "<tr><td>".$title."</td></tr>";
echo "<tr><td><br><ul>";
while (list($k,$v)=each($msgs))
	{
	echo "<li>".$v."</li>";
	}
echo "</ul></td></tr></table>";
}

function pageend()
{
exit();
}
?>
