<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_main_product_image.php 3208 2006-03-19 16:48:57Z birdbrain $
 */
?>
<?php require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_MAIN_PRODUCT_IMAGE)); ?> 
<script language="javascript" src="/image/douco.js"></script>
<link rel="stylesheet" type="text/css" href="/image/zoom.css?v=1">
<div id="productImage" class="centeredContent back">
	<div id="productMainImage"><a class="MagicZoom MagicThumb" href="<?php echo $products_image_medium; ?>" target="_blank"><?php echo zen_image($products_image_medium, $products_name, MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT); ?></a><br />
    </div>
    <br class="clearBoth" />
</div>