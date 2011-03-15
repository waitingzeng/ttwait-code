<?php
/**
 * Common Template - tpl_box_default_left.php
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_box_default_left.php 2975 2006-02-05 19:33:51Z birdbrain $
 */

// choose box images based on box position
  if ($title_link) {
    $title = '<a href="' . zen_href_link($title_link) . '">' . $title . BOX_HEADING_LINKS . '</a>';
  }
//
?>
<!--// bof: box_categories //-->
<div id="category_left_menu" class="margin_t allborder bg_box_gray">
<h3 class="pad_l_10px line_20px bg_box_eecd gray"><?php echo $title; ?></h3>
<dl class="lnav">
	<dt class="big b"><?php echo $subtitle; ?></dt>
	<?php echo $content; ?>
	<?php if ($categories_displayTypes == 2 || $current_products_list) {?>
  <dt class="big b">Price</dt>
  	  <?php echo $priceListOutString; ?>
  <?php } ?>
  		<?php //print_r(zen_parse_category_path($cPath)); ?>
</dl>
</div>
<!--// eof: box_categories //-->

