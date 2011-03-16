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
// $Id: westernunion.php,v 1.1 2008-03-20 Jack $
//
  define('MODULE_PAYMENT_BOCORDER_TEXT_NAME', 'Beneficiary\'s name : ');
  define('MODULE_PAYMENT_BOCORDER_TEXT_NO', 'A/C No. : ');
  define('MODULE_PAYMENT_BOCORDER_TEXT_ADDRESS', 'Beneficiary\'s address : ');
  define('MODULE_PAYMENT_BOCORDER_TEXT_SWIFTCODE', 'SWIFTCODE : ');
  define('MODULE_PAYMENT_BOCORDER_TEXT_REMARKS', 'Remittance Remarks : ');
  define('MODULE_PAYMENT_BOCORDER_TEXT_ZIP', 'Zip Code : ');

  define('MODULE_PAYMENT_BOCORDER_NAME', 'Beneficiary name');
  define('MODULE_PAYMENT_BOCORDER_NO', 'A/C No.');
  define('MODULE_PAYMENT_BOCORDER_ADDRESS', 'Beneficiary address');
  define('MODULE_PAYMENT_BOCORDER_SWIFTCODE', 'SWIFTCODE');
  define('MODULE_PAYMENT_BOCORDER_REMARKS', 'Remittance Remarks');
  define('MODULE_PAYMENT_BOCORDER_ZIP', 'Zip Code');

  define('MODULE_PAYMENT_BOCORDER_TEXT_CONFIG_1_1','Enable Bank Transfer Order Module');
  define('MODULE_PAYMENT_BOCORDER_TEXT_CONFIG_1_2','Do you want to accept Bank Of China Order payments?');
  define('MODULE_PAYMENT_BOCORDER_TEXT_CONFIG_2_1','Sort order of display.');
  define('MODULE_PAYMENT_BOCORDER_TEXT_CONFIG_2_2','Sort order of display. Lowest is displayed first.'); 
  define('MODULE_PAYMENT_BOCORDER_TEXT_CONFIG_3_1','Set Order Status');
  define('MODULE_PAYMENT_BOCORDER_TEXT_CONFIG_3_2','Set the status of orders made with this payment module to this value');
  
  define('MODULE_PAYMENT_BOCORDER_TEXT_TITLE', 'Bank Transfer Order');
  define('MODULE_PAYMENT_BOCORDER_TEXT_DESCRIPTION', 'If you pay with bank transfer,you can go to local bank to send the money to: 
:<br><br>' .  '<b>'. MODULE_PAYMENT_BOCORDER_TEXT_NAME .'</b>' . MODULE_PAYMENT_BOCORDER_NAME . '<br>' .  '<b>'.MODULE_PAYMENT_BOCORDER_TEXT_NO . '</b>' .   MODULE_PAYMENT_BOCORDER_NO . '<br>' .  '<b>'.MODULE_PAYMENT_BOCORDER_TEXT_ADDRESS . '</b>' .MODULE_PAYMENT_BOCORDER_ADDRESS . '<br>'  .   '<b>'. MODULE_PAYMENT_BOCORDER_TEXT_SWIFTCODE . '</b>'.   MODULE_PAYMENT_BOCORDER_SWIFTCODE . '<br>'  .  '<b>'. MODULE_PAYMENT_BOCORDER_TEXT_REMARKS . '</b>'.   MODULE_PAYMENT_BOCORDER_REMARKS . '<br>'  . '<b>'. MODULE_PAYMENT_BOCORDER_TEXT_ZIP . '</b>'.   MODULE_PAYMENT_BOCORDER_ZIP);
  
  define('MODULE_PAYMENT_BOCORDER_TEXT_EMAIL_FOOTER', 'If you pay with bank transfer,you can go to local bank to send the money to: 
:<br><br>' .  '<b>'. MODULE_PAYMENT_BOCORDER_TEXT_NAME .'</b>' . MODULE_PAYMENT_BOCORDER_NAME . '<br>' .  '<b>'.MODULE_PAYMENT_BOCORDER_TEXT_NO . '</b>' .   MODULE_PAYMENT_BOCORDER_NO . '<br>' .  '<b>'.MODULE_PAYMENT_BOCORDER_TEXT_ADDRESS . '</b>' .MODULE_PAYMENT_BOCORDER_ADDRESS . '<br>'  .   '<b>'. MODULE_PAYMENT_BOCORDER_TEXT_SWIFTCODE . '</b>'.   MODULE_PAYMENT_BOCORDER_SWIFTCODE . '<br>'  .  '<b>'. MODULE_PAYMENT_BOCORDER_TEXT_REMARKS . '</b>'.   MODULE_PAYMENT_BOCORDER_REMARKS . '<br>'  . '<b>'. MODULE_PAYMENT_BOCORDER_TEXT_ZIP . '</b>'.   MODULE_PAYMENT_BOCORDER_ZIP);

  define('MODULE_PAYMENT_BOCORDER_MARK_BUTTON_IMG', DIR_WS_MODULES . 'payment/banktransfer/bof.gif');
  define('MODULE_PAYMENT_BOCORDER_MARK_BUTTON_ALT', 'Checkout with Bank Transfer');
  define('MODULE_PAYMENT_BOCORDER_ACCEPTANCE_MARK_TEXT', 'Send Money with Bank Transfer');

  define('MODULE_PAYMENT_BOCORDER_TEXT_CATALOG_LOGO', '<img src="' . MODULE_PAYMENT_BOCORDER_MARK_BUTTON_IMG . '" alt="' . MODULE_PAYMENT_BOCORDER_MARK_BUTTON_ALT . '" title="' . MODULE_PAYMENT_BOCORDER_MARK_BUTTON_ALT . '" /> &nbsp;' .  '<span class="smallText">' . MODULE_PAYMENT_BOCORDER_ACCEPTANCE_MARK_TEXT . '</span>');

?>
