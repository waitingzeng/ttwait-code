<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2009 Bouncing Limited, Philip Clarke
 * @copyright Modified 2010, Clive Vooght
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

// test if box should display
  $show_messenger_live = true;
  if(!defined('MESSENGER_INVITEE'))
  	$show_messenger_live = false;
  if ($show_messenger_live == true) {
      require($template->get_template_dir('tpl_messenger_live.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_messenger_live.php');
      $title =  BOX_HEADING_MESSENGER_LIVE;
      $left_corner = false;
      $right_corner = false;
      $right_arrow = false;
	  $title_link = false;
      require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
 }
