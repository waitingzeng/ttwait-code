<?
//****************************************	//MD5密钥要跟订单提交页相同，如Send.asp里的 key = "test" ,修改""号内 test 为您的密钥
											//如果您还没有设置MD5密钥请登陆我们为您提供商户后台，地址：https://merchant3.chinabank.com.cn/
	$key='234872304823434';							//登陆后在上面的导航栏里可能找到“B2C”，在二级导航栏里有“MD5密钥设置”
											//建议您设置一个16位以上的密钥或更高，密钥最多64位，但设置16位已经足够了
//****************************************

$v_oid     =trim($_POST['v_oid']);      
$v_pmode   =trim($_POST['v_pmode']);      
$v_pstatus =trim($_POST['v_pstatus']);      
$v_pstring =trim($_POST['v_pstring']);      
$v_amount  =trim($_POST['v_amount']);     
$v_moneytype  =trim($_POST['v_moneytype']);     
$remark1   =trim($_POST['remark1' ]);     
$remark2   =trim($_POST['remark2' ]);     
$v_md5str  =trim($_POST['v_md5str' ]);     
$uid = $remark1;//用户ID
$bid = $remark2;//点数卡ID
/**
 * 重新计算md5的值
 */
                           
$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key)); //拼凑加密串

	$mb_transaction_id=$v_oid;
	$paymentstatus = $v_pstatus;
	$md5sig = $v_md5str;
	$id = $bid;//点数卡ID
	$uid = $uid;//用户ID

if ($v_md5str==$md5string)
{
	if($paymentstatus==20)
	{
			if($id!="" and $id!=0)
			{
			 if($id!="WON111"){
			 	//充值买点卡
				$qrypay = "Insert into payment_detail (transaction_id,user_id,bidpack_id,temp_data) values('".$mb_transaction_id."|".$md5sig."','".$uid."','".$id."','".$_REQUEST."')";
				mysql_query($qrypay) or die(mysql_error());
				
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

							include("../../language/".$objlng["language_name"].".php");

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
				echo "ok";
			}
		 }
		 else if($id=="BUYNOW"){
		 	//BUYNOW
		 	  $stime=time();
		 	  $qrypay="update shops_orders set state=1,stime='$stime' where oid='$remark1' ";
				mysql_query($qrypay);
		 	  echo "ok";
		 }
		 else if($id=="WON111"){
		 	//中标后的付款
				$qrypay = "update won_auctions set payment_date=now() where auction_id='$remark1'";
				mysql_query($qrypay);
		 	  echo "ok";
		 }
		 
		}else{
			echo "error";
		}

}else{
	echo "error";
}
?>