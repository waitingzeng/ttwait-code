<?php
/*$partner         = "2088102144925385";        //合作伙伴ID
$security_code   = "z15jdf8rxl55bcfomefgxq071wzl2tlx";        //安全检验码
$seller_email    = "wisheo@126.com";        //卖家支付宝帐户
*/
$alipay=array(
'partner'         => "~partner~",        //合作伙伴ID
'security_code'   => "~security_code~",        //安全检验码
'seller_email'    => "~seller_email~"        //卖家支付宝帐户
);
$partner         = "~partner~";        //合作伙伴ID
$security_code   = "~security_code~";        //安全检验码
$seller_email    = "~seller_email~";        //卖家支付宝帐户

$_input_charset = "utf-8"; //字符编码格式  目前支持 GBK 或 utf-8
$sign_type 			= "MD5"; //加密方式  系统默认(不要修改)
$transport			= "http";//访问模式,你可以根据自己的服务器是否支持ssl访问而选择http以及https访问模式(系统默认,不要修改)
$notify_url      = ""; //交易过程中服务器通知的页面 要用 http://格式的完整路径
$return_url      = "http://".$_SERVER['HTTP_HOST']."/payment_done.php?me=alipay"; //付完款后跳转的页面 要用 http://格式的完整路径

$show_url   		=	""  //你网站商品的展示地址,可以为空
?>