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
  $content = '';
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent">' . "\n";
  $content .= '<div class="wrapper">' . "\n";
  $content .= '<table cellspacing="0" cellpadding="0">' . "\n";
  foreach (explode($_COOKIE['recent_viewed']) as $recent_product) {
		$link = zen_href_link(zen_get_info_page($recent_product), 'products_id=' . $recent_product);
		$content .= '<tr>' . "\n" . 
					  '<td><a href="' .  $link . '">' . zen_get_products_image($recent_product, '35', '35') . '</a></td>' . "\n" . 
					  '<td><div class="recent-products-name"><a href="' . $link . '">' . zen_get_products_name($recent_product, $_SESSION['languages_id']) . '</a></div><div class="rent-products-price">' . zen_get_products_display_price($recent_product) . '</div></td>' . "\n" . 
					 '</tr>';
  }
  $content .= '</table>' . "\n";
  $content .= '</div>' . "\n";
  $content .= '</div>';
?>
