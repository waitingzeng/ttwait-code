<?php
/**
 * tpl_specials.php
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_specials.php 6128 2007-04-08 04:53:32Z birdbrain $
 */
  $content = "";
  $specials_box_counter = 0;
  while (!$random_specials_sidebox_product->EOF) {
    $specials_box_counter++;
    $content .= '<li>';
    $content .= '<a title="' . $random_specials_sidebox_product->fields['products_name'] .'" href="'. zen_href_link(zen_get_info_page($random_specials_sidebox_product->fields['products_id']),'products_id='.$random_specials_sidebox_product->fields['products_id']) .'">'. zen_image_OLD(DIR_WS_IMAGES.$random_specials_sidebox_product->fields['products_image'],$random_specials_sidebox_product->fields['products_name'],42,42,'class="fl"') .'</a>';
    $content .= '<span><a title="'. $random_specials_sidebox_product->fields['products_name'] .'" href="' . zen_href_link(zen_get_info_page($random_specials_sidebox_product->fields['products_id']),'products_id='.$random_specials_sidebox_product->fields['products_id']) .'">'. substr($random_specials_sidebox_product->fields['products_name'],0,16).(strlen($random_specials_sidebox_product->fields['products_name']) > 16 ? '...': '') .'</a><br/>';
    $content .= '<strong class="red">'. $currencies->display_price((zen_get_products_base_price($random_specials_sidebox_product->fields['products_id']) == 0 ? zen_get_products_sample_price($random_specials_sidebox_product->fields['products_id']) : zen_get_products_base_price($random_specials_sidebox_product->fields['products_id'])),zen_get_tax_rate($random_specials_sidebox_product->fields['products_id'])) .'</strong>';
    $content .= '</span>';
    $content .= '</li>';
    $random_specials_sidebox_product->MoveNextRandom();
  }
?>
