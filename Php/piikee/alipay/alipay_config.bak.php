<?php
/*$partner         = "2088102144925385";        //�������ID
$security_code   = "z15jdf8rxl55bcfomefgxq071wzl2tlx";        //��ȫ������
$seller_email    = "wisheo@126.com";        //����֧�����ʻ�
*/
$alipay=array(
'partner'         => "~partner~",        //�������ID
'security_code'   => "~security_code~",        //��ȫ������
'seller_email'    => "~seller_email~"        //����֧�����ʻ�
);
$partner         = "~partner~";        //�������ID
$security_code   = "~security_code~";        //��ȫ������
$seller_email    = "~seller_email~";        //����֧�����ʻ�

$_input_charset = "utf-8"; //�ַ������ʽ  Ŀǰ֧�� GBK �� utf-8
$sign_type 			= "MD5"; //���ܷ�ʽ  ϵͳĬ��(��Ҫ�޸�)
$transport			= "http";//����ģʽ,����Ը����Լ��ķ������Ƿ�֧��ssl���ʶ�ѡ��http�Լ�https����ģʽ(ϵͳĬ��,��Ҫ�޸�)
$notify_url      = ""; //���׹����з�����֪ͨ��ҳ�� Ҫ�� http://��ʽ������·��
$return_url      = "http://".$_SERVER['HTTP_HOST']."/payment_done.php?me=alipay"; //��������ת��ҳ�� Ҫ�� http://��ʽ������·��

$show_url   		=	""  //����վ��Ʒ��չʾ��ַ,����Ϊ��
?>