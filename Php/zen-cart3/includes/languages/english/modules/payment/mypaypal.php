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
// | Simplified Chinese version   http://www.zen-cart.cn                  |
// +----------------------------------------------------------------------+
// $Id: icbcorder.php 001 2005-09-10 jack $
//

  define('MODULE_PAYMENT_MYPAYPAL_TEXT_TITLE', 'PayPal');
  if(MODULE_PAYMENT_MYPAYPAL_PAYTO){
  	define('MODULE_PAYMENT_MYPAYPAL_TEXT_DESCRIPTION', '<div><strong>Thanks for choosing with Paypal as your payment. With paypal payment, you need to pay 20% extra for paypal fee. Because we need to pay expensive paypal charges. Our paypal account is <span style="color:red">'.MODULE_PAYMENT_MYPAYPAL_PAYTO.'</span>. When you pay, pls write the order number in paypal payment. If you have any question, pls contact us.
</strong></div>
<div><strong>Email:&nbsp;&nbsp;&nbsp;<a href="mailto:'.STORE_OWNER_EMAIL_ADDRESS.'">'.STORE_OWNER_EMAIL_ADDRESS.'</a></strong></div>
<div><strong>Msn:&nbsp;<a href="msnim:add?contack='.MSN.'">'.MSN.'</a></strong></div>');
  }else {
  	define('MODULE_PAYMENT_MYPAYPAL_TEXT_DESCRIPTION', '<div><strong>Thanks for choosing with Paypal as your payment. With paypal payment, you need to pay 20% extra for paypal fee. Because we need to pay expensive paypal charges. you can cantact us to get Our paypal account . When you pay, pls write the order number in paypal payment. If you have any question, pls contact us.
</strong></div>
<div><strong>Email:&nbsp;&nbsp;&nbsp;<a href="mailto:'.STORE_OWNER_EMAIL_ADDRESS.'">'.STORE_OWNER_EMAIL_ADDRESS.'</a></strong></div>
<div><strong>Msn:&nbsp;<a href="msnim:add?contack='.MSN.'">'.MSN.'</a></strong></div>');
  }
  define('MODULE_PAYMENT_ICBCORDER_TEXT_EMAIL_FOOTER', "Please make your check or money order payable to:" . "\n\n" . MODULE_PAYMENT_MYPAYPAL_PAYTO . "\n\nMail your payment to:\n" . STORE_NAME_ADDRESS . "\n\n" . 'Your order will not ship until we receive payment.');
  
    define('MODULE_PAYMENT_MYPAYPAL_MARK_BUTTON_IMG', DIR_WS_MODULES . 'payment/paypal/checkout.gif');
  define('MODULE_PAYMENT_MYPAYPAL_MARK_BUTTON_ALT', 'Checkout with PayPal');
  define('MODULE_PAYMENT_MYPAYPAL_ACCEPTANCE_MARK_TEXT', 'You need to pay 20% extra if you pay with paypal');

  define('MODULE_PAYMENT_MYPAYPAL_TEXT_CATALOG_LOGO', '<img src="' . MODULE_PAYMENT_MYPAYPAL_MARK_BUTTON_IMG . '" alt="' . MODULE_PAYMENT_MYPAYPAL_MARK_BUTTON_ALT . '" title="' . MODULE_PAYMENT_MYPAYPAL_MARK_BUTTON_ALT . '" /> &nbsp;' .  '<span class="smallText">' . MODULE_PAYMENT_MYPAYPAL_ACCEPTANCE_MARK_TEXT . '</span>');
?>
