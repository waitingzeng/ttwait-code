<?php

require_once(dirname(__FILE__)."/alipay_config.php");

require_once(dirname(__FILE__)."/alipay_service.php");



$price = $_POST["v_amount"];

$OrdersId = $_POST["remark1"]."|".$_POST["remark2"]."|".date(Ymdhms);

$title = $_POST["p5_Pid"];



$parameter = array(

"service" => "create_direct_pay_by_user", //�������ͣ�����ʵ�ｻ�ף�trade_create_by_buyer����Ҫ��д������

"partner" => $partner,                                               //�����̻���

"return_url" => $return_url,  //ͬ������

"notify_url" => $notify_url,  //�첽����

"_input_charset" => $_input_charset,           //�ַ�����Ĭ��ΪGBK

"subject" => $title,                           //��Ʒ���ƣ�����

"body" => "",                              //��Ʒ����������

"out_trade_no" => $OrdersId,                      //��Ʒ�ⲿ���׺ţ�����,ÿ�β��Զ����޸�

"logistics_fee" => '0.00',//�������ͷ���

"logistics_payment"=>'BUYER_PAY',              // �������ͷ��ø��ʽ��SELLER_PAY(����֧��)��BUYER_PAY(���֧��)��BUYER_PAY_AFTER_RECEIVE(��������)

"logistics_type"=>'EXPRESS',                   // �������ͷ�ʽ��POST(ƽ��)��EMS(EMS)��EXPRESS(�������)



"price" => $price,           //��Ʒ���ۣ�����

"payment_type"=>"1",                           // Ĭ��Ϊ1,����Ҫ�޸�

"quantity" => "1",                                 //��Ʒ����������

"show_url" => $show_url,            //��Ʒ�����վ

"seller_email" => $seller_email                //�������䣬����

);



$alipay = new alipay_service($parameter,$security_code,$sign_type);

$link	= $alipay->create_url();



echo '<html>

<head>

	<title>ת��֧����֧��ҳ��</title>

</head>

<body onLoad="document.alipay.submit();">

	<form name="alipay" action="'.$link.'" method="post">

	</form>

</body>

</html>';

exit;