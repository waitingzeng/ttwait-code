<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: jscript_main.php 5444 2006-12-29 06:45:56Z drbyte $
//
?>
<script language="javascript" type="text/javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=100,height=100,screenX=150,screenY=150,top=150,left=150')
}
function popupWindowPrice(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=600,height=400,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
<script>
var FRIENDLY_URLS='true';
var symbolLeft='<?php echo $currencies->display_symbol_left($_SESSION['currency']);?>';
var symbolRight='';
var min_quantity = <?php echo zen_get_products_quantity_order_min($_GET['products_id']);?>;

var discount = new Array();
<?php $jsPrice = $currencies->noSymbolDisplayPrice((zen_get_products_base_price($_GET['products_id']) == 0 ? zen_get_products_sample_price($_GET['products_id']) : zen_get_products_base_price($_GET['products_id'])),zen_get_tax_rate($_GET['products_id'])) ?>
discount[0] =["<?php echo zen_get_products_quantity_order_min($_GET['products_id']);?>", "<?php echo $jsPrice; ?>", "<?php echo zen_get_product_is_always_free_shipping((int)$_GET['products_id'])?1:0;?>", "0"];
var extraPrice = 0;
var originPrice = discount[0][1];
function stripPrice(s) {
	s = s.replace(/[\D]+\s/,"").replace(")","");;
	return s;
}
function str2Number(s){
	var str = s.replace(/[,]*/g, "");
	return str;
}
function number2Str(tempNum){
    var iniNum;
    var floatNum;
    tempNum = tempNum.toString();
    var decimalPosition = tempNum.indexOf(".");
    if(decimalPosition>0) {
        iniNum = tempNum.slice(0,decimalPosition)
        floatNum = tempNum.slice(decimalPosition)
    }else{
        iniNum = tempNum;
        floatNum = "";
    }
    var l = iniNum.length;
    var times = Math.ceil(l/3);
    for(i=1;i<times;i++) {
        iniNum = iniNum.slice(0,l-3*i) + ',' + iniNum.slice(l-3*i);
    }
    return(iniNum + floatNum);
}
function countPrice() {
	return Number(str2Number(originPrice)) + Number(extraPrice);
}
function changePrice() {
    if(!$('cart_quantity')) return;
	var qty = $('cart_quantity').value;
	var tmp ;
	var priceTmp;
	for(var i=discount.length-1;i>=0;i--){
		if(qty >= parseInt(discount[i][0])){
			if(parseInt(discount[i][2]) > 0){
				$('shipping_rule').innerHTML = ("+ " + discount[i][3] + "Free Shipping ");
			}
			else{
				$('shipping_rule').innerHTML = ("+ Shipping Cost");
			}
			originPrice = discount[i][1];
			break;
		}
	}
	$('products_price_unit').innerHTML = number2Str(countPrice().toFixed(2));
	$('products_price_all').innerHTML = symbolLeft + "&nbsp;" + number2Str((countPrice()*$('cart_quantity').value).toFixed(2));
}
function check_product(frm){
	if($('cart_quantity').value < min_quantity){
		alert('The Quantity you submitted is invalid.');
		return false;
	}
	return true;
}
var payment_option='<h2 class="blue">Payment methods available in <?php echo addcslashes(STORE_NAME,'\''); ?>:</h2><div class="margin_t">We make paying for your orders easy by providing a range of convenient payment options:</div><?php echo $paymentInfoString.addcslashes(PRODUCTS_INFO_POPUP_PAYMENT_METHODS,'\'');?><div>For more information on everything you need to know about paying for your order at <?php echo addcslashes(STORE_NAME,'\''); ?>, check out our <a target="_blank"  class="black b" href="faq_all.html?fcPath=6">How To Pay</a> help section.</div><div class="g_t_c margin_t"></div>';


var shipping_info='<h2 class="blue">Shipping & Delivery:</h2><div class="margin_t red">Worldwide shipping from LoveInTheBox.com is fast and safe. Simply choose your shipping method during Checkout.<br/>We offer two international shipping methods:</div><dl class="dl_dot pad_10px"><dt>Standard shipping:  Normally takes 7 to 10 days.</dt><dt>Express shipping:  Normally takes 2 to 4 days.</dt></dl><div>Total delivery time is the sum of the shipping time as well as the processing time, which includes selecting the product, checking quality and packing the product. Most products need an average of 6 - 7 business days to process. Tailor-made clothing and bridal wear needs 11 - 16 business days for processing, while other clothes, security systems, sports & outdoor items, cosplay, and health & beauty items need 8 - 12 business days to process.<br /><br />For more Shipping details click <a target="_blank" href="faq_info.html?faqs_id=1231&fcPath=6"><b>here</b></a>.<br />For more Delivery Time details click <a target="_blank" href="faq_info.html?faqs_id=1233&fcPath=6"><b>here</b></a>.</div>';

var costs='<h2 class="blue">How to calculate shipping costs at <?php echo addcslashes(STORE_NAME,'\''); ?>:</h2><dl class="dl_dot margin_t pad_10px"><dt class="on">Click <img src="http://i1.lbox.me/img/en/car_min.jpg"/> You will then be taken to the <strong>Shopping Cart</strong> page.</dt><dt>Scroll down to <strong>Estimate Shipping Costs</strong>. </dt><dt>Select your country in the drop-down menu. </dt><dt>Your estimated shipping cost will be displayed.</dt></dl><div class="margin_t">From here you can either buy the product by clicking <strong>Continue Checkout</strong> or go back to <strong><?php echo addcslashes(STORE_NAME,'\''); ?></strong> to continue shopping.</div>';

</script>
<style type="text/css">
.png {
behavior: url(<?php echo HTTP_SERVER.DIR_WS_CATALOG.DIR_WS_TEMPLATES.$template_dir.'/css/';
?>iepngfix.htc)
}
</style>
