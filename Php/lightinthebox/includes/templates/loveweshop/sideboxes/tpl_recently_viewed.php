<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_best_sellers.php 2982 2006-02-07 07:56:41Z birdbrain $
 */

  $content = '<ul class="recent_view pad_10px">' . "\n";
  foreach ($recent_viewed as $recent_product) {
	$link = zen_href_link(zen_get_info_page($recent_product), 'products_id=' . $recent_product);
	$content .= '<li>' . "\n" . 
				  '<a class="ih" href="' .  $link . '">' . zen_get_products_image($recent_product, '85', '85') . '</a>' . "\n" . 
				  '<span><a href="' . $link . '">' . zen_get_products_name($recent_product, $_SESSION['languages_id']) . '</a></span>' . "\n" . 
				 '</li>';
  }
  $content .= '</ul>';
?>