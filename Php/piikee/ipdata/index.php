<?php
//*
//�ļ�ͷ [��һ��������ƫ���� (4byte)] + [���һ��������ƫ�Ƶ�ַ (4byte)]     8�ֽ�
//��¼�� [����ip (4byte)] + [����1] + [����2]                                4�ֽ�+������
//������ [��ʼip (4byte)] + [ָ���¼����ƫ�Ƶ�ַ (3byte)]                   7�ֽ�
//ע��:ʹ��֮ǰ��ȥ�������ش���IP���ݿ�,������Ϊ "CoralWry.dat" �ŵ���ǰĿ¼�¼���.
//*
class ipLocation {
var $fp;
var $firstip;  //��һ��ip������ƫ�Ƶ�ַ
var $lastip;   //���һ��ip������ƫ�Ƶ�ַ
var $totalip;  //��ip��
//*
//���캯��,��ʼ��һЩ����
//$datfile ��ֵΪ����IP���ݿ������,�������޸�.
//*
function ipLocation(){
  $datfile = $GLOBALS['ROOT_PATH'] . "ipdata/CoralWry.dat";
  $this->fp=fopen($datfile,'rb');   //���Ʒ�ʽ��
  $this->firstip = $this->get4b(); //��һ��ip�����ľ���ƫ�Ƶ�ַ
  $this->lastip = $this->get4b();  //���һ��ip�����ľ���ƫ�Ƶ�ַ
  $this->totalip =($this->lastip - $this->firstip)/7 ; //ip���� �������Ƕ�����7���ֽ�,�ڴ�Ҫ����7,
  register_shutdown_function(array($this,"closefp"));  //Ϊ�˼���php5���°汾,����û������������,�Զ��ر�ip��.
}
//*
//�ر�ip��
//*
function closefp(){
fclose($this->fp);
}
//*
//��ȡ4���ֽڲ�����ѹ��long�ĳ�ģʽ
//*
function get4b(){
  $str=unpack("V",fread($this->fp,4));
  return $str[1];
}
//*
//��ȡ�ض����˵�ƫ�Ƶ�ַ
//*
function getoffset(){
  $str=unpack("V",fread($this->fp,3).chr(0));
  return $str[1];
}
//*
//��ȡip����ϸ��ַ��Ϣ
//*
function getstr(){
	$str = "";
  $split=fread($this->fp,1);
  while (ord($split)!=0) {
    $str .=$split;
	$split=fread($this->fp,1);
  }
  return $str;
}
//*
//��ipͨ��ip2longת��ipv4�Ļ�������ַ,�ٽ���ѹ����big-endian�ֽ���
//�������������ڵ�ip��ַ���Ƚ�
//*
function iptoint($ip){
  return pack("N",intval(ip2long($ip)));
}
//*
//��ȡ�ͻ���ip��ַ
//ע��:�������Ҫ��ip��¼����������,����д��ʱ�ȼ��һ��ip�������Ƿ�ȫ.
//*
function getIP() {
        if (getenv('HTTP_CLIENT_IP')) {
				$ip = getenv('HTTP_CLIENT_IP'); 
		}
		elseif (getenv('HTTP_X_FORWARDED_FOR')) { //��ȡ�ͻ����ô�������������ʱ����ʵip ��ַ
				$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_X_FORWARDED')) { 
				$ip = getenv('HTTP_X_FORWARDED');
		}
		elseif (getenv('HTTP_FORWARDED_FOR')) {
				$ip = getenv('HTTP_FORWARDED_FOR'); 
		}
		elseif (getenv('HTTP_FORWARDED')) {
				$ip = getenv('HTTP_FORWARDED');
		}
		else { 
				$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
}
//*
//��ȡ��ַ��Ϣ
//*
function readaddress(){
  $now_offset=ftell($this->fp); //�õ���ǰ��ָ��λַ
  $flag=$this->getflag();
  switch (ord($flag)){
         case 0:
		     $address="";
		 break;
		 case 1:
		 case 2:
		     fseek($this->fp,$this->getoffset());
			 $address=$this->getstr();
		 break;
		 default:
		     fseek($this->fp,$now_offset);
		     $address=$this->getstr();
		 break;
  }
  return $address;
}
//*
//��ȡ��־1��2
//����ȷ����ַ�Ƿ��ض�����.
//*
function getflag(){
  return fread($this->fp,1);
}
//*
//�ö��ֲ��ҷ���������������ip
//*
function searchip($ip){
  $ip=gethostbyname($ip);     //������ת��ip
  $ip_offset["ip"]=$ip;
  $ip=$this->iptoint($ip);    //��ipת���ɳ�����
  $firstip=0;                 //�������ϱ߽�
  $lastip=$this->totalip;     //�������±߽�
  $ipoffset=$this->lastip;    //��ʼ��Ϊ���һ��ip��ַ��ƫ�Ƶ�ַ
  while ($firstip <= $lastip){
    $i=floor(($firstip + $lastip) / 2);          //��������м��¼ floor�����������������С���������,˵���˾���������Ҳ��
	fseek($this->fp,$this->firstip + $i * 7);    //��λָ�뵽�м��¼
	$startip=strrev(fread($this->fp,4));         //��ȡ��ǰ�������ڵĿ�ʼip��ַ,������little-endian���ֽ���ת����big-endian���ֽ���
	if ($ip < $startip) {
	   $lastip=$i - 1;
	}
	else {
	   fseek($this->fp,$this->getoffset());
	   $endip=strrev(fread($this->fp,4));
	   if ($ip > $endip){
	      $firstip=$i + 1;
	   }
	   else {
	      $ip_offset["offset"]=$this->firstip + $i * 7;
	      break;
	   }
	}
  }
  return $ip_offset;
}
//*
//��ȡip��ַ��ϸ��Ϣ
//*
function getaddress($ip){
  $ip_offset=$this->searchip($ip);  //��ȡip ���������ڵľ��Ա��Ƶ�ַ
  $ipoffset=$ip_offset["offset"];
  $address["ip"]=$ip_offset["ip"];
  fseek($this->fp,$ipoffset);      //��λ��������
  $address["startip"]=long2ip($this->get4b()); //�������ڵĿ�ʼip ��ַ
  $address_offset=$this->getoffset();            //��ȡ��������ip��ip��¼���ڵ�ƫ�Ƶ�ַ
  fseek($this->fp,$address_offset);            //��λ����¼����
  $address["endip"]=long2ip($this->get4b());   //��¼���ڵĽ���ip ��ַ
  $flag=$this->getflag();                      //��ȡ��־�ֽ�
  switch (ord($flag)) {
         case 1:  //����1����2���ض���
		 $address_offset=$this->getoffset();   //��ȡ�ض����ַ
		 fseek($this->fp,$address_offset);     //��λָ�뵽�ض���ĵ�ַ
		 $flag=$this->getflag();               //��ȡ��־�ֽ�
		 switch (ord($flag)) {
		        case 2:  //����1��һ���ض���,
				fseek($this->fp,$this->getoffset());
				$address["area1"]=$this->getstr();
				fseek($this->fp,$address_offset+4);      //��4���ֽ�
				$address["area2"]=$this->readaddress();  //����2�п����ض���,�п���û��
				break;
				default: //����1,����2��û���ض���
				fseek($this->fp,$address_offset);        //��λָ�뵽�ض���ĵ�ַ
				$address["area1"]=$this->getstr();
				$address["area2"]=$this->readaddress();
				break;
		 }
		 break;
		 case 2: //����1�ض��� ����2û���ض���
		 $address1_offset=$this->getoffset();   //��ȡ�ض����ַ
		 fseek($this->fp,$address1_offset);  
		 $address["area1"]=$this->getstr();
		 fseek($this->fp,$address_offset+8);
		 $address["area2"]=$this->readaddress();
		 break;
		 default: //����1����2��û���ض���
		 fseek($this->fp,$address_offset+4);
		 $address["area1"]=$this->getstr();
		 $address["area2"]=$this->readaddress();
		 break;
  }
  //*����һЩ��������
  if (strpos($address["area1"],"CZ88.NET")!=false){
      $address["area1"]="δ֪";
  }
  if (strpos($address["area2"],"CZ88.NET")!=false){
      $address["area2"]=" ";
  }
  return $address;
 }

	function get_final_address($ip){
		if(empty($ip)) $ip = $this->getIP();
		$address = $this->getaddress($ip);
		$final_address = $address["area1"]." ".$address["area2"];
		return iconv("gbk","utf-8",$final_address);
	}

} 
//*ipLocation class end
//ȡ�ÿͻ���ip���жϵ�ַ
$GLOBALS['IP']=new ipLocation();
//�����ַ������Եõ��������ݿ�������ƥ�������  
/*$prince=explode("ʡ",$address["area1"]);
  if(!empty($prince[1]))
{
  $city=explode("��",$prince[1]);
  $yourcity=$city[0]."��";
}
  elseif(empty($prince[1]))
{
	       $city2=array();
	       $city2[]=strpos($address["area1"],"�Ϻ�");
	       $city2[]=strpos($address["area1"],"����");
		   $city2[]=strpos($address["area1"],"���");
		   $city2[]=strpos($address["area1"],"����");
	       $city4=array();
		   $city4[]="�Ϻ�";
		   $city4[]="����";
		   $city4[]="���";
		   $city4[]="����";
          for($j=0;$j<=3;$j++){
	         if($city2[$j]===0){
		  $city=$city4[$j];
          $yourcity=$city;
        }
	   }
	   if(empty($yourcity)){
	       $city1=array();
	       $city1[]=explode("���ɹ�",$address["area1"]);
	       $city1[]=explode("����",$address["area1"]);
		   $city1[]=explode("����",$address["area1"]);
		   $city1[]=explode("����",$address["area1"]);
		   $city1[]=explode("�½�",$address["area1"]);
          for($j=0;$j<=4;$j++){
	      if(!empty($city1[$j][1])){
		  $city3=$city1[$j][1];
            }
          }
	$city=explode("��",$city3);        
    $yourcity=$city[0];
        }
}
//if(!empty($yourcity)) echo $yourcity;
//if(empty($yourcity)) echo"��֪����ĵ�ַ��";
*/
?>