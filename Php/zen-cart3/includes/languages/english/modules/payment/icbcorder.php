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

  define('MODULE_PAYMENT_ICBCORDER_TEXT_TITLE', ' Bank Transfer');
  define('MODULE_PAYMENT_ICBCORDER_TEXT_DESCRIPTION', '<div align="left"><strong>If you pay with bank transfer,you can go to local bank to send the money to: </strong></div>
<div align="left"><strong>Beneficiary\'s name:&nbsp;&nbsp;<span style="color:red">Ceng Qingchuang</span></strong></div>
<div align="left"><strong>A/C No. : &nbsp;&nbsp;<span style="color:red">4776420-0188-122244-1</span></strong></div>
<div align="left"><strong>Beneficiary\'s address:&nbsp;&nbsp;<span style="color:red">Guangzhou xingangzhonglu, Guangzhou, China</span></strong></div>
<div align="left"><strong>SWIFTCODE:&nbsp;&nbsp;<span style="color:red">BKCHCNBJ400</span></strong></div>
<div align="left"><strong>Remittance Remarks:&nbsp; &nbsp;&nbsp;<span style="color:red">Bank of China,GUANGZHOU XIN GANG ZHONG ROAD SUB-BRANCH</span></strong></div>
<div align="left"><strong>PostCode:&nbsp;&nbsp;<span style="color:red">510000</span></strong></div>');
  
  define('MODULE_PAYMENT_ICBCORDER_TEXT_EMAIL_FOOTER', '<div align="left"><strong>If you pay with bank transfer,you can go to local bank to send the money to: </strong></div>
<div align="left"><strong>Beneficiary\'s name:&nbsp;&nbsp;<span style="color:red">Ceng Qingchuang</span></strong></div>
<div align="left"><strong>A/C No. : &nbsp;&nbsp;<span style="color:red">4776420-0188-122244-1</span></strong></div>
<div align="left"><strong>Beneficiary\'s address:&nbsp;&nbsp;<span style="color:red">Guangzhou xingangzhonglu, Guangzhou, China</span></strong></div>
<div align="left"><strong>SWIFTCODE:&nbsp;&nbsp;<span style="color:red">BKCHCNBJ400</span></strong></div>
<div align="left"><strong>Remittance Remarks:&nbsp; &nbsp;&nbsp;<span style="color:red">Bank of China,GUANGZHOU XIN GANG ZHONG ROAD SUB-BRANCH</span></strong></div>
<div align="left"><strong>PostCode:&nbsp;&nbsp;<span style="color:red">510000</span></strong></div>' . "\n\nMail your payment to:\n" . STORE_NAME_ADDRESS . "\n\n" . 'Your order will not ship until we receive payment.');
  
      define('MODULE_PAYMENT_ICBCORDER_MARK_BUTTON_IMG', DIR_WS_MODULES . 'payment/banktransfer/bof.gif');
  define('MODULE_PAYMENT_ICBCORDER_MARK_BUTTON_ALT', 'Checkout with Bank Transfer');
  define('MODULE_PAYMENT_ICBCORDER_ACCEPTANCE_MARK_TEXT', 'Send Money with Bank Transfer');

  define('MODULE_PAYMENT_ICBCORDER_TEXT_CATALOG_LOGO', '<img src="' . MODULE_PAYMENT_ICBCORDER_MARK_BUTTON_IMG . '" alt="' . MODULE_PAYMENT_ICBCORDER_MARK_BUTTON_ALT . '" width="150px" title="' . MODULE_PAYMENT_ICBCORDER_MARK_BUTTON_ALT . '" /> &nbsp;' .  '<span class="smallText">' . MODULE_PAYMENT_ICBCORDER_ACCEPTANCE_MARK_TEXT . '</span>');
?>
