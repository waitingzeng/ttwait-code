<?php

 include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_NEW_LISTING));
?>
<?php
/**
 * load the list_box_content template to display the products
 */
if (PRODUCT_LISTING_LAYOUT_STYLE == 'columns') {
  require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
} else {// (PRODUCT_LISTING_LAYOUT_STYLE == 'rows')
  require($template->get_template_dir('tpl_tabular_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_tabular_display.php');
}
?>