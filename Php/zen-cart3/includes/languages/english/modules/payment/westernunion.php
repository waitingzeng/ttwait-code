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
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_RECEIVER', 'Receiver ');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_SENDER', 'Sender ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_MCTN', 'MTCN : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_AMOUNT', 'Amount : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_CURRENCY', 'Currency : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME', 'First Name : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME', 'Last Name : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS', 'Address : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP', 'Zip Code : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY', 'City : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY', 'Country : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE', 'Phone : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_QUESTION', 'Question : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_ANSWER', 'Answer : ');
  
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME', 'First Name');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME', 'Last Name');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS', 'Address');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP', 'Zip Code');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY', 'City');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY', 'Country');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE', 'Phone');

  define('MODULE_PAYMENT_WESTERNUNION_TEXT_CONFIG_1_1','Enable Western Union Order Module');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_CONFIG_1_2','Do you want to accept Western Union Order payments?');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_CONFIG_2_1','Sort order of display.');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_CONFIG_2_2','Sort order of display. Lowest is displayed first.'); 
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_CONFIG_3_1','Set Order Status');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_CONFIG_3_2','Set the status of orders made with this payment module to this value');
  
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_TITLE', 'Western Union Order');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_DESCRIPTION', 'If you pay with WU,Please pay the money to:<br><br>' .  '<b>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME .'</b>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . '<br>' .  '<b>'.MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME . '</b>' .   MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . '<br>' .  '<b>'.MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS . '</b>' .MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . '<br>'  .   '<b>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP . '</b>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . '<br>'  .  '<b>'.  MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY . '</b>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . '<br>'  .   '<b>After you pay by western union, please kindly let us know the following information: <br/><font color="red">first name and last name you write on the bank receipt, and exact amount you make, and MTCN(money transfer control number)</font></b>');
  
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_EMAIL_FOOTER', "If you pay with WU,Please pay the money to:\n\n" . MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . " - " . MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME . MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . " - "  . MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . " - "  . MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . " - "  . MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY . MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . "\n\n" . '<b>after you pay by western union, please kindly let us know the following information: first name and last name you write on the bank receipt, and exact amount you make, and MTCN(money transfer control number)</b>' . "\n\n" .  '<b>Your order will not be shipped until we receive the MTCN payment number provided by Western Union Money Transfer.</b>');

  define('MODULE_PAYMENT_WESTERNUNION_MARK_BUTTON_IMG', DIR_WS_MODULES . 'payment/westernunion/westernunion.gif');
  define('MODULE_PAYMENT_WESTERNUNION_MARK_BUTTON_ALT', 'Checkout with Western Union');
  define('MODULE_PAYMENT_WESTERNUNION_ACCEPTANCE_MARK_TEXT', 'Send Money with Western Union');

  define('MODULE_PAYMENT_WESTERNUNION_TEXT_CATALOG_LOGO', '<img src="' . MODULE_PAYMENT_WESTERNUNION_MARK_BUTTON_IMG . '" alt="' . MODULE_PAYMENT_WESTERNUNION_MARK_BUTTON_ALT . '" title="' . MODULE_PAYMENT_WESTERNUNION_MARK_BUTTON_ALT . '" /> &nbsp;' .  '<span class="smallText">' . MODULE_PAYMENT_WESTERNUNION_ACCEPTANCE_MARK_TEXT . '</span>');

?>