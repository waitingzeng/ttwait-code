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
  define('MODULE_PAYMENT_MONEYGRAM_TEXT_RECEIVER', 'Receiver ');
  define('MODULE_PAYMENT_MONEYGRAM_TEXT_SENDER', 'Sender ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_MCTN', 'MTCN : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_AMOUNT', 'Amount : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_CURRENCY', 'Currency : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_FIRST_NAME', 'First Name : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_LAST_NAME', 'Last Name : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_ADDRESS', 'Address : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_ZIP', 'Zip Code : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_CITY', 'City : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_COUNTRY', 'Country : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_PHONE', 'Phone : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_QUESTION', 'Question : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_ANSWER', 'Answer : ');
  
  define('MODULE_PAYMENT_MONEYGRAM_RECEIVER_FIRST_NAME', 'First Name');
  define('MODULE_PAYMENT_MONEYGRAM_RECEIVER_LAST_NAME', 'Last Name');
  define('MODULE_PAYMENT_MONEYGRAM_RECEIVER_ADDRESS', 'Address');
  define('MODULE_PAYMENT_MONEYGRAM_RECEIVER_ZIP', 'Zip Code');
  define('MODULE_PAYMENT_MONEYGRAM_RECEIVER_CITY', 'City');
  define('MODULE_PAYMENT_MONEYGRAM_RECEIVER_COUNTRY', 'Country');
  define('MODULE_PAYMENT_MONEYGRAM_RECEIVER_PHONE', 'Phone');

  define('MODULE_PAYMENT_MONEYGRAM_RECEIVER_NOTICE', ' PLEASE EMAIL YOUR ORDER NUMBER ,THE MONEY GRAM CONTROL NUMBER,AMOUNT,SENDER\'S FIRST AND LAST NAME,SENDER\'S ADDRESS AND COUNTRY,SENDER\'S PHONE NUMBER TO '.'loveweshop@gmail.com'.' AFTER YOUR SEND PAYMENT BY MONEY GRAM. THANKS!');
  
  define('MODULE_PAYMENT_MONEYGRAM_TEXT_CONFIG_1_1','Enable Money Gram Order Module');
  define('MODULE_PAYMENT_MONEYGRAM_TEXT_CONFIG_1_2','Do you want to accept Money Gram Order payments?');
  define('MODULE_PAYMENT_MONEYGRAM_TEXT_CONFIG_2_1','Sort order of display.');
  define('MODULE_PAYMENT_MONEYGRAM_TEXT_CONFIG_2_2','Sort order of display. Lowest is displayed first.'); 
  define('MODULE_PAYMENT_MONEYGRAM_TEXT_CONFIG_3_1','Set Order Status');
  define('MODULE_PAYMENT_MONEYGRAM_TEXT_CONFIG_3_2','Set the status of orders made with this payment module to this value');
  
  define('MODULE_PAYMENT_MONEYGRAM_TEXT_TITLE', 'Money Gram Order');
  define('MODULE_PAYMENT_MONEYGRAM_TEXT_DESCRIPTION', 'Make Payable To:<br><br>' .  '<b>'. MODULE_PAYMENT_MONEYGRAM_ENTRY_FIRST_NAME .'</b>' . MODULE_PAYMENT_MONEYGRAM_RECEIVER_FIRST_NAME . '<br>' .  '<b>'.MODULE_PAYMENT_MONEYGRAM_ENTRY_LAST_NAME . '</b>' .   MODULE_PAYMENT_MONEYGRAM_RECEIVER_LAST_NAME . '<br>' .  '<b>'.MODULE_PAYMENT_MONEYGRAM_ENTRY_ADDRESS . '</b>' .MODULE_PAYMENT_MONEYGRAM_RECEIVER_ADDRESS . '<br>'  .   '<b>'. MODULE_PAYMENT_MONEYGRAM_ENTRY_ZIP . '</b>'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_ZIP . '<br>'  .   '<b>'. MODULE_PAYMENT_MONEYGRAM_ENTRY_CITY .   '</b>'.  MODULE_PAYMENT_MONEYGRAM_RECEIVER_CITY . '<br>'  .  '<b>'.  MODULE_PAYMENT_MONEYGRAM_ENTRY_COUNTRY . '</b>'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_COUNTRY . '<br>'  .   '<b>'.  MODULE_PAYMENT_MONEYGRAM_ENTRY_PHONE . '</b>'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_PHONE . '<br>' . '<font size=2 color="red"><b>After the payment, plese tell us your Firstname, Lastname, amount, currency, country and MTCN(money transfer control number).</b></font>');
  
  define('MODULE_PAYMENT_MONEYGRAM_TEXT_EMAIL_FOOTER', "Make Payable To:\n\n" . MODULE_PAYMENT_MONEYGRAM_ENTRY_FIRST_NAME . MODULE_PAYMENT_MONEYGRAM_RECEIVER_FIRST_NAME . " - " . MODULE_PAYMENT_MONEYGRAM_ENTRY_LAST_NAME . MODULE_PAYMENT_MONEYGRAM_RECEIVER_LAST_NAME . " - "  . MODULE_PAYMENT_MONEYGRAM_ENTRY_ADDRESS . MODULE_PAYMENT_MONEYGRAM_RECEIVER_ADDRESS . " - "  . MODULE_PAYMENT_MONEYGRAM_ENTRY_ZIP . MODULE_PAYMENT_MONEYGRAM_RECEIVER_ZIP . " - "  . MODULE_PAYMENT_MONEYGRAM_ENTRY_CITY . MODULE_PAYMENT_MONEYGRAM_RECEIVER_CITY . " - "  . MODULE_PAYMENT_MONEYGRAM_ENTRY_COUNTRY . MODULE_PAYMENT_MONEYGRAM_RECEIVER_COUNTRY . " - "  . MODULE_PAYMENT_MONEYGRAM_ENTRY_PHONE . MODULE_PAYMENT_MONEYGRAM_RECEIVER_PHONE . "\n\n" . '<b>After the payment, plese tell us your first name, last name, amount, currency and country.</b>' . "\n\n" .  '<b>Your order will not be shipped until we receive the MTCN payment number provided by MOney Gram Money Transfer.</b>');

  define('MODULE_PAYMENT_MONEYGRAM_MARK_BUTTON_IMG', 'includes/templates/loveweshop/images/checkout/pic_3.jpg');
  define('MODULE_PAYMENT_MONEYGRAM_MARK_BUTTON_ALT', 'Checkout with Money Gram');
  define('MODULE_PAYMENT_MONEYGRAM_ACCEPTANCE_MARK_TEXT', '');

  define('MODULE_PAYMENT_MONEYGRAM_TEXT_CATALOG_LOGO', '<img align="absmiddle" src="' . MODULE_PAYMENT_MONEYGRAM_MARK_BUTTON_IMG . '" alt="' . MODULE_PAYMENT_MONEYGRAM_MARK_BUTTON_ALT . '" title="' . MODULE_PAYMENT_MONEYGRAM_MARK_BUTTON_ALT . '" /> &nbsp;' .  MODULE_PAYMENT_MONEYGRAM_ACCEPTANCE_MARK_TEXT);

?>
