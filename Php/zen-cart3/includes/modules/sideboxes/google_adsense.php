<?php
/**
 * google adsense sidebox - displays google adsense ads in a sidebox
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: google_adsense.php 2006-06-06 06:06:06Z gilby $
 *
 * Display on non ssl pages only as you don't want to distract a paying customer
 */

  if ($request_type == 'NONSSL') {

    require($template->get_template_dir('tpl_google_adsense.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_google_adsense.php');

    $title = BOX_HEADING_GOOGLE_ADSENSE;
    $left_corner = false;
    $right_corner = false;
    $right_arrow = false;
    $title_link = false;

    require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);

  }

?>

