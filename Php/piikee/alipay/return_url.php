<?php
	define('IN_JP',true);
	define('NO_header',true);
	include("../config/init.php");	
	error_reporting(0);
	require_once(dirname(__FILE__)."/alipay_config.php");

	require_once(dirname(__FILE__)."/alipay_notify.php");

	

$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);

$verify_result = $alipay->return_verify();



//��ȡ֧�����ķ�������

$dingdan					= $_GET['out_trade_no'];		//��ȡ������

$total_fee				= $_GET['total_fee'];    		//��ȡ�ܼ۸�

 

$receive_name    	= $_GET['receive_name'];  	//��ȡ�ջ�������

$receive_address 	= $_GET['receive_address']; //��ȡ�ջ��˵�ַ

$receive_zip     	= $_GET['receive_zip'];  		//��ȡ�ջ����ʱ�

$receive_phone   	= $_GET['receive_phone']; 	//��ȡ�ջ��˵绰

$receive_mobile  	= $_GET['receive_mobile']; 	//��ȡ�ջ����ֻ�



$remarkArray = explode("|",$dingdan);

$remark1   =$remarkArray[0];      //��ע�ֶ�1

$remark2   =$remarkArray[1];      //��ע�ֶ�2

$uid = $remark1;//�û�ID

$bid = $remark2;//������ID



$mb_transaction_id=$dingdan;

$id = $bid;//������ID

$uid = $uid;//�û�ID

$v_amount = $total_fee;





if($verify_result) {

			//֧���ɹ�

			log_result($dingdan.":verify_success"); //����֤��������ļ�



			if($id!="" and $id!=0)

			{

			 if($id!="WON111"){

			 	//��ֵ��㿨

				$qrypay = "Insert into payment_detail (transaction_id,user_id,bidpack_id,temp_data) values('".$mb_transaction_id."','".$uid."','".$id."','".$_REQUEST."')";

				mysql_query($qrypay) or die("<script language=\"javascript\" type=\"text/javascript\">window.location.href='../myaccount.html';</script>");

				

				$qrysel1 = "select * from bidpack where id='$id'";

				$ressel1 = mysql_query($qrysel1);

				$obj1 = mysql_fetch_array($ressel1);

				

				$creditdesc = $lng_bidpackchar.$obj1["bidpack_name"]."&nbsp;".$obj1["bid_size"]."&nbsp;".$lng_bidsfor."&nbsp;".$Currency.$obj1["bid_price"];

				

				$qrysel = "select * from registration where id='$uid'";

				$rssel = mysql_query($qrysel);

				$obj = mysql_fetch_object($rssel);

				

				$qr = "select * from bid_account where user_id='".$uid."' and bid_flag='c' and recharge_type='re'";

				$rs = mysql_query($qr);

				$totalrecharge = mysql_num_rows($rs);

				if($totalrecharge=="0" && $obj->sponser!="0")

				{

					$qryaff = "select * from registration where id='".$obj->sponser."'";

					$resaff = mysql_query($qryaff);

					$objaff = mysql_fetch_object($resaff);

					$fbid = $objaff->final_bids;

		

					$qrybonus = "select * from auction_pause_management where id='2'";

					$resbonus = mysql_query($qrybonus);

					$objbonus = mysql_fetch_object($resbonus);

					$bonusbids = $objbonus->referral_bids;

					

					$finalbids = $fbid + $bonusbids;

		

					$updaff = "update registration set final_bids='".$finalbids."' where id='".$obj->sponser."'";

					mysql_query($updaff) or die(mysql_error());			

					

					$insaff = "Insert into bid_account (user_id, bidpack_buy_date, bid_count, bid_flag,recharge_type,referer_id,credit_description) values('".$obj->sponser."',NOW(),'$bonusbids','c','af','$uid','Refferal Bouns')";

					mysql_query($insaff) or die(mysql_error());

					$insertidaff = mysql_insert_id();

				}

				

					$qryins = "Insert into bid_account (user_id,bidpack_id,bidpack_buy_date,bid_count,bid_flag,recharge_type,credit_description) values('$uid','$id',NOW(),'".$obj1["bid_size"]."','c','re','".$creditdesc."')";

					mysql_query($qryins) or die(mysql_error());

					$insertid = mysql_insert_id();

					

					$qrylng = "select * from language";

					$reslng = mysql_query($qrylng);

					$totallng = mysql_num_rows($reslng);

					

					if($totallng>0)

					{

						while($objlng = mysql_fetch_array($reslng))

						{

							$prefix = $objlng["language_prefix"];



							include("../language/".$objlng["language_name"].".php");



							$creditdesc = $lng_bidpackchar.$obj1[$prefix."_bidpack_name"]."&nbsp;".$obj1["bid_size"]."&nbsp;".$lng_bidsfor."&nbsp;".$Currency.$obj1["bid_price"];;



							$creditdesc2 = $lng_bidreffbonus;



							$qryupd = "update bid_account set ".$prefix."_credit_description='".$creditdesc."' where id='".$insertid."'";

							mysql_query($qryupd) or die(mysql_error());

							

							if($insertidaff!="")

							{

								$qryupd2 = "update bid_account set ".$prefix."_credit_description='".$creditdesc2."' where id='".$insertidaff."'";

								mysql_query($qryupd2) or die(mysql_error());

							}

						}

					}

				//end bid_account

			

				if($obj->final_bids>0)

				{

					$bal = $obj->final_bids;

					$new = $obj1["bid_size"];

					$final = $bal + $new;

				}

				else

				{

					$final = $obj1["bid_size"];

				}

				

				$qryupd = "update registration set final_bids='$final' where id='$uid'";

				mysql_query($qryupd) or die(mysql_error());

				echo "֧���ɹ�,���:".$v_amount."Ԫ";

			}

		 }

		 else if($id=="BUYNOW"){

		 	//BUYNOW		 	  

		 	  $stime=date("Y-m-d H:i:s");

		 	  $qrypay="update shops_orders set state=1,stime='$stime' where oid='$remark1' ";

				mysql_query($qrypay) or die("<script language=\"javascript\" type=\"text/javascript\">window.location.href='../myauction.html';</script>");

		 	  echo "֧���ɹ�(oid=$remark1)";

		 }

		 else if($id=="WON111"){

		 	//�б��ĸ���

		 	  $pay_date=date("Y-m-d H:i:s");

				$qrypay = "update won_auctions set payment_date='$pay_date' where auction_id='$remark1'";

				mysql_query($qrypay) or die("<script language=\"javascript\" type=\"text/javascript\">window.location.href='../myaccount.html';</script>");

		 	  echo "֧���ɹ�(auction_id=$remark1)";

		 }

		 ?>

		<script language="javascript" type="text/javascript">

		  

			window.location.href='../../myaccount.html';

		</script>

		 <?		 		

	}

else  {

	$msg = "֧��ʧ��."; 

	log_result ($dingdan.":verify_failed");

	exit;

}

//��־��Ϣ,��֧���������Ĳ�����¼����

function  log_result($word) { 

	$fp = fopen("log.txt","a");	

	flock($fp, LOCK_EX) ;

	fwrite($fp,$word."��ִ�����ڣ�".strftime("%Y%m%d%H%I%S",time())."\t\n");

	flock($fp, LOCK_UN); 

	fclose($fp);

}	

?>