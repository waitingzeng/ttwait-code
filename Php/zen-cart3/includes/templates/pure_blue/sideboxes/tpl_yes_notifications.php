<?php
/**
* PureBlue Template designed by zen-cart-power.com
* zen-cart-power.com - Free Zen Cart templates and modules
* Power your Zen Cart!
* 
* Side Box Template
*
* @package templateSystem
* @copyright Copyright 2008-2009 Zen-Cart-Power.com
* @copyright Copyright 2003-2005 Zen Cart Development Team
* @copyright Portions Copyright 2003 osCommerce
* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
* @version $Id: tpl_yes_notifications.php 2982 2006-02-07 07:56:41Z birdbrain $
*/
  $content = "";
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent centeredContent">';
  $content .= '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=notify_remove', $request_type) . '">' . zen_image(DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_BOX_NOTIFY_REMOVE, OTHER_BOX_NOTIFY_REMOVE_ALT) .'</a>';
  $content .= '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=notify_remove', $request_type) . '">' . '<br />' . sprintf(BOX_NOTIFICATIONS_NOTIFY_REMOVE, zen_get_products_name($_GET['products_id'])) .'</a>';
  $content .= '</div>';
?>