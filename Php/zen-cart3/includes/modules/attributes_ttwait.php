<?php

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
// limit to 1 for performance when processing larger tables

$sizelist = explode(';', $products_sizelist);

if(count($sizelist) > 0){
              $sql = "select *  from        " . TABLE_PRODUCTS_OPTIONS . " popt
              where           popt.products_options_id='1' 
              and             popt.language_id = '" . (int)$_SESSION['languages_id'] . "' limit 1" ;

              $products_options_names = $db->Execute($sql);
			  if(!isset($zv_display_select_option))$$zv_display_select_option=0;
			  $zv_display_select_option ++;
              
              if (!$products_options_names->EOF) {
              	$pr_attr->fields['total'] ++;
              	$products_options_array = array();
              	foreach ($sizelist as $k=>$value) {
              		$products_options_array[] = array('id' => $k, 'text' => $value);
              	}
                $products_options_value_id = '';
                $products_options_details = '';
                $products_options_details_noname = '';
                $tmp_radio = '';
                $tmp_checkbox = '';
                $tmp_html = '';
                $selected_attribute = false;

                $tmp_attributes_image = '';
                $tmp_attributes_image_row = 0;
                $show_attributes_qty_prices_icon = 'false';
                
                switch (true) {
                  // checkbox
                  case ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_CHECKBOX):
                  if ($show_attributes_qty_prices_icon == 'true') {
                    $options_name[] = ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'];
                  } else {
                    $options_name[] = $products_options_names->fields['products_options_name'];
                  }
                  foreach ($products_options_array as $products_options_value_id => $products_options_details) {
                  	$tmp_checkbox .= zen_draw_checkbox_field('id[' . $products_options_names->fields['products_options_id'] . ']['.$products_options_value_id.']', $products_options_value_id, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsCheckbox" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details . '</label><br />' . "\n";
                  }
                  
                  $options_menu[] = $tmp_checkbox . "\n";
                  $options_comment[] = $products_options_names->fields['products_options_comment'];
                  $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
                  break;
                  // radio buttons
                  case ($products_options_names->fields['products_options_type'] == PRODUCTS_OPTIONS_TYPE_RADIO):
                  if ($show_attributes_qty_prices_icon == 'true') {
                    $options_name[] = ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'];
                  } else {
                    $options_name[] = $products_options_names->fields['products_options_name'];
                  }
                  foreach ($products_options_array as $products_options_value_id=>$products_options_details) {
                  	$tmp_radio .= zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, 0, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsRadioButton zero" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details . '</label><br />' . "\n";
                  }
                  
                  $options_menu[] = $tmp_radio . "\n";
                  $options_comment[] = $products_options_names->fields['products_options_comment'];
                  $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
                  break;
                  // dropdown menu auto switch to selected radio button display
                  case (count($products_options) == 1):
                 $products_options_value_id = $products_options_array[0]['id'];
                 $products_options_details = $products_options_array[0]['text'];
                  if ($show_attributes_qty_prices_icon == 'true') {
                    $options_name[] = '<label class="switchedLabel ONE" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'] . '</label>';
                  } else {
                    $options_name[] = $products_options_names->fields['products_options_name'];
                  }
                  $options_menu[] = zen_draw_radio_field('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_value_id, 'selected', 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '"') . '<label class="attribsRadioButton" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '-' . $products_options_value_id . '">' . $products_options_details . '</label>' . "\n";
                  $options_comment[] = $products_options_names->fields['products_options_comment'];
                  $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
                  break;
                  default:
                  // normal dropdown menu display
                  if (isset($_SESSION['cart']->contents[$prod_id]['attributes'][$products_options_names->fields['products_options_id']])) {
                    $selected_attribute = $_SESSION['cart']->contents[$prod_id]['attributes'][$products_options_names->fields['products_options_id']];
                  } else {
                    // use customer-selected values
                    if ($_POST['id'] !='') {
                      reset($_POST['id']);
                      foreach ($_POST['id'] as $key => $value) {
                        if ($key == $products_options_names->fields['products_options_id']) {
                          $selected_attribute = $value;
                          break;
                        }
                      }
                    } else {
                    // use default selected set above
                    }
                  }

                  if ($show_attributes_qty_prices_icon == 'true') {
                    $options_name[] = ATTRIBUTES_QTY_PRICE_SYMBOL . $products_options_names->fields['products_options_name'];
                  } else {
                    $options_name[] = '<label class="attribsSelect" for="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '">' . $products_options_names->fields['products_options_name'] . '</label>';
                  }


                  $options_menu[] = zen_draw_pull_down_menu('id[' . $products_options_names->fields['products_options_id'] . ']', $products_options_array, $selected_attribute, 'id="' . 'attrib-' . $products_options_names->fields['products_options_id'] . '"') . "\n";
                  $options_comment[] = $products_options_names->fields['products_options_comment'];
                  $options_comment_position[] = ($products_options_names->fields['products_options_comment_position'] == '1' ? '1' : '0');
                  break;
                }
              }
}

?>