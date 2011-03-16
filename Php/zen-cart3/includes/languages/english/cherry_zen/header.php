<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header.php 2940 2006-02-02 04:29:05Z drbyte $
 */

// header text in includes/header.php
  define('HEADER_TITLE_CREATE_ACCOUNT', 'Create Account');
  define('HEADER_TITLE_MY_ACCOUNT', 'My Account');
  define('HEADER_TITLE_CART_CONTENTS', 'Shopping Cart');
  define('HEADER_TITLE_CHECKOUT', 'Checkout');
  define('HEADER_TITLE_TOP', 'Top');
  define('HEADER_TITLE_CATALOG', 'Home');
  define('HEADER_TITLE_LOGOFF', 'Log Out');
  define('HEADER_TITLE_LOGIN', 'Log In/Reg');

// added defines for header alt and text
  define('HEADER_ALT_TEXT', 'Powered by '.STORE_NAME.' : '.HTTP_SERVER);
  define('HEADER_SALES_TEXT', '<span>Email:&nbsp;&nbsp;&nbsp;<a href="mailto:'.STORE_OWNER_EMAIL_ADDRESS.'">'.STORE_OWNER_EMAIL_ADDRESS.'</a><br/><br/>MSN:&nbsp;<a href="msnim:add?contack='.MSN.'">'.MSN.'</a>');
  define('HEADER_LOGO_WIDTH', ' ');
  define('HEADER_LOGO_HEIGHT', ' ');
  $LOGOS = array('logo.gif', 'logo1.gif');
  define('HEADER_LOGO_IMAGE', $LOGOS[rand(0,count($LOGOS)-1)]);

// header Search Button/Box Search Button
  define('HEADER_SEARCH_BUTTON','Search');
  define('HEADER_SEARCH_DEFAULT_TEXT', 'Search');

?>