<?php
/*$partner         = "2088102144925385";        //�������ID
$security_code   = "z15jdf8rxl55bcfomefgxq071wzl2tlx";        //��ȫ������
$seller_email    = "wisheo@126.com";        //����֧�����ʻ�
*/
$alipay=array(
'partner'         => "208800296144687",        //�������ID
'security_code'   => "s69t92nr2m3pdtqmnprq45pghh0tx5u",        //��ȫ������
'seller_email'    => "25072956@qq.com"        //����֧�����ʻ�
);
$partner         = "208800296144687";        //�������ID
$security_code   = "s69t92nr2m3pdtqmnprq45pghh0tx5u";        //��ȫ������
$seller_email    = "25072956@qq.com";        //����֧�����ʻ�

$_input_charset = "utf-8"; //�ַ������ʽ  Ŀǰ֧�� GBK �� utf-8
$sign_type 			= "MD5"; //���ܷ�ʽ  ϵͳĬ��(��Ҫ�޸�)
$transport			= "http";//����ģʽ,����Ը����Լ��ķ������Ƿ�֧��ssl���ʶ�ѡ��http�Լ�https����ģʽ(ϵͳĬ��,��Ҫ�޸�)
$notify_url      = ""; //���׹����з�����֪ͨ��ҳ�� Ҫ�� http://��ʽ������·��
$return_url      = "http://".$_SERVER['HTTP_HOST']."/payment_done.php?me=alipay"; //��������ת��ҳ�� Ҫ�� http://��ʽ������·��

$show_url   		=	""  //����վ��Ʒ��չʾ��ַ,����Ϊ��
?>