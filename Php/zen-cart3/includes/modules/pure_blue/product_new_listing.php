<?php
/**
 * product_listing module
 *
 * @package modules
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: product_listing.php 4655 2006-10-02 01:02:38Z ajeh $
 * UPDATED TO WORK WITH COLUMNAR PRODUCT LISTING For Zen Cart v1.3.6 - 10/25/2006
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
// Column Layout Support originally added for Zen Cart v 1.1.4 by Eric Stamper - 02/14/2004
// Upgraded to be compatible with Zen-cart v 1.2.0d by Rajeev Tandon - Aug 3, 2004
// Column Layout Support (Grid Layout) upgraded for v1.3.0 compatibility DrByte 04/04/2006
//
if (!defined('PRODUCT_LISTING_LAYOUT_STYLE')) define('PRODUCT_LISTING_LAYOUT_STYLE','rows');
if (!defined('PRODUCT_LISTING_COLUMNS_PER_ROW')) define('PRODUCT_LISTING_COLUMNS_PER_ROW',3);
$row = 0;
$col = 0;
$list_box_contents = array();
$title = '';

$max_results = (PRODUCT_LISTING_LAYOUT_STYLE=='columns' && PRODUCT_LISTING_COLUMNS_PER_ROW>0) ? (PRODUCT_LISTING_COLUMNS_PER_ROW * (int)(MAX_DISPLAY_PRODUCTS_LISTING/PRODUCT_LISTING_COLUMNS_PER_ROW)) : MAX_DISPLAY_PRODUCTS_LISTING;


$show_submit = zen_run_normal();
$listing_split = $products_new_split;

 // create column list
  $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
  'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
  'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
  'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
  'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
  'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
  'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE);

  /*                         ,
  'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);
  */
  asort($define_list);
  reset($define_list);
  $column_list = array();
  foreach ($define_list as $key => $value)
  {
    if ($value > 0) $column_list[] = $key;
  }

// Begin Row Layout Header
if (PRODUCT_LISTING_LAYOUT_STYLE == 'rows') {		// For Column Layout (Grid Layout) add on module

  $list_box_contents[0] = array('params' => 'class="productListing-rowheading"');

  $zc_col_count_description = 0;
  $lc_align = '';
  for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
    switch ($column_list[$col]) {
      case 'PRODUCT_LIST_MODEL':
        $lc_text = TABLE_HEADING_MODEL;
        $lc_align = '';
        $zc_col_count_description++;
        break;
      case 'PRODUCT_LIST_NAME':
        $lc_text = TABLE_HEADING_PRODUCTS;
        $lc_align = '';
        $zc_col_count_description++;
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $lc_text = TABLE_HEADING_MANUFACTURER;
        $lc_align = '';
        $zc_col_count_description++;
        break;
      case 'PRODUCT_LIST_PRICE':
        $lc_text = TABLE_HEADING_PRICE;
        $lc_align = 'right' . (PRODUCTS_LIST_PRICE_WIDTH > 0 ? '" width="' . PRODUCTS_LIST_PRICE_WIDTH : '');
        $zc_col_count_description++;
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $lc_text = TABLE_HEADING_QUANTITY;
        $lc_align = 'right';
        $zc_col_count_description++;
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $lc_text = TABLE_HEADING_WEIGHT;
        $lc_align = 'right';
        $zc_col_count_description++;
        break;
      case 'PRODUCT_LIST_IMAGE':
        $lc_text = TABLE_HEADING_IMAGE;
        $lc_align = 'center';
        $zc_col_count_description++;
        break;
    }

    if ( ($column_list[$col] != 'PRODUCT_LIST_IMAGE') ) {
      $lc_text = zen_create_sort_heading($_GET['sort'], $col+1, $lc_text);
    }
    $list_box_contents[0][$col] = array('align' => $lc_align,
                                        'params' => 'class="productListing-heading"',
                                        'text' => $lc_text );
  }

} // End Row Layout Header used in Column Layout (Grid Layout) add on module

/////////////  HEADER ROW ABOVE /////////////////////////////////////////////////

$num_products_count = $listing_split->number_of_rows;

if ($listing_split->number_of_rows > 0) {
  $rows = 0;
  // Used for Column Layout (Grid Layout) add on module
  $column = 0;	
  if (PRODUCT_LISTING_LAYOUT_STYLE == 'columns') {
    if ($num_products_count < PRODUCT_LISTING_COLUMNS_PER_ROW || PRODUCT_LISTING_COLUMNS_PER_ROW == 0 ) {
      $col_width = floor(100/$num_products_count);
    } else {
      $col_width = floor(100/PRODUCT_LISTING_COLUMNS_PER_ROW);
    }
  }
  // Used for Column Layout (Grid Layout) add on module


  $listing = $db->Execute($listing_split->sql_query);
  $extra_row = 0;

  while (!$listing->EOF) {

    if (PRODUCT_LISTING_LAYOUT_STYLE == 'rows') { // Used in Column Layout (Grid Layout) Add on module
      $rows++;

      if ((($rows-$extra_row)/2) == floor(($rows-$extra_row)/2)) {
        $list_box_contents[$rows] = array('params' => 'class="productListing-even"');
      } else {
        $list_box_contents[$rows] = array('params' => 'class="productListing-odd"');
      }

      $cur_row = sizeof($list_box_contents) - 1;
    }   // End of Conditional execution - only for row (regular style layout)

    $product_contents = array(); // Used For Column Layout (Grid Layout) Add on module
    for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
      $lc_align = '';

      switch ($column_list[$col]) {
        case 'PRODUCT_LIST_MODEL':
          $lc_align = '';
          $lc_text = $listing->fields['products_model'];
          break;
        case 'PRODUCT_LIST_NAME':
          $lc_align = '';
          if (isset($_GET['manufacturers_id'])) {
            $lc_text = '<br/><a target="_blank" href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'products_id=' . $listing->fields['products_id']) . '"  target="_blank">' . $listing->fields['products_name'] . '</a><div class="listingDescription">' . zen_trunc_string(zen_clean_html(stripslashes(zen_get_products_description($listing->fields['products_id'], $_SESSION['languages_id']))), PRODUCT_LIST_DESCRIPTION) . '</div>' ;
          } else {
            $lc_text = '<br/><a  target="_blank" href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $listing->fields['products_id']) . '">' . $listing->fields['products_name'] . '</a>';
          }
          break;
        case 'PRODUCT_LIST_MANUFACTURER':
          $lc_align = '';
          $lc_text = '<a target="_blank" href="' . zen_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing->fields['manufacturers_id']) . '">' . $listing->fields['manufacturers_name'] . '</a>';
          break;
        case 'PRODUCT_LIST_PRICE':
          $lc_price = '<br/><span class="listingPrice">' . zen_get_products_display_price($listing->fields['products_id']) . '</span>';
          $lc_align = 'right';
          $lc_text =  $lc_price;

          // more info in place of buy now
          $lc_button = '';
          if (zen_has_product_attributes($listing->fields['products_id']) or PRODUCT_LIST_PRICE_BUY_NOW == '0') {
            //$lc_button = '<a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $listing->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
          } else {
            if (PRODUCT_LISTING_MULTIPLE_ADD_TO_CART != 0) {
            if (
                // not a hide qty box product
                $listing->fields['products_qty_box_status'] != 0 &&
                // product type can be added to cart
                zen_get_products_allow_add_to_cart($listing->fields['products_id']) != 'N'
                &&
                // product is not call for price
                $listing->fields['product_is_call'] == 0
                &&
                // product is in stock or customers may add it to cart anyway
                ($listing->fields['products_quantity'] > 0 || SHOW_PRODUCTS_SOLD_OUT_IMAGE == 0) ) {
                    $how_many++;
                  }
            // hide quantity box
            if ($listing->fields['products_qty_box_status'] == 0) {
              $lc_button = '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT, 'class="listingBuyNowButton"') . '</a>';
            } else {
              $lc_button = TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART . "<input type=\"text\" name=\"products_id[" . $listing->fields['products_id'] . "]\" value=\"0\" size=\"4\" />";
            }
          } else {
// qty box with add to cart button
            if (PRODUCT_LIST_PRICE_BUY_NOW == '2' && $listing->fields['products_qty_box_status'] != 0) {
              $lc_button= zen_draw_form('cart_quantity', zen_href_link(zen_get_info_page($listing->fields['products_id']), zen_get_all_get_params(array('action')) . 'action=add_product&products_id=' . $listing->fields['products_id']), 'post', 'enctype="multipart/form-data"') . '<input type="text" name="cart_quantity" value="' . (zen_get_buy_now_qty($listing->fields['products_id'])) . '" maxlength="6" size="4" /><br />' . zen_draw_hidden_field('products_id', $listing->fields['products_id']) . zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT) . '</form>';
            } else {
              $lc_button = '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing->fields['products_id']) . '">' . zen_image_button(BUTTON_IMAGE_BUY_NOW, BUTTON_BUY_NOW_ALT, 'class="listingBuyNowButton"') . '</a>';
            }
            }
          }
          if($lc_button){
          $the_button = $lc_button;
        $products_link = '<a href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $listing->fields['products_id']) . '">' . MORE_INFO_TEXT . '</a>';
          $lc_text .= '<br />' . zen_get_buy_now_button($listing->fields['products_id'], $the_button, $products_link) . '<br />' . zen_get_products_quantity_min_units_display($listing->fields['products_id']);
          $lc_text .= '<br />' . (zen_get_show_product_switch($listing->fields['products_id'], 'ALWAYS_FREE_SHIPPING_IMAGE_SWITCH') ? (zen_get_product_is_always_free_shipping($listing->fields['products_id']) ? TEXT_PRODUCT_FREE_SHIPPING_ICON . '<br />' : '') : '');
          }else{
          	$lc_text = $lc_price;
          }
          break;
        case 'PRODUCT_LIST_QUANTITY':
          $lc_align = 'right';
          $lc_text = $listing->fields['products_quantity'];
          break;
        case 'PRODUCT_LIST_WEIGHT':
          $lc_align = 'right';
          $lc_text = $listing->fields['products_weight'];
          break;
        case 'PRODUCT_LIST_IMAGE':
          $lc_align = 'center';
        if ($listing->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) {
          $lc_text = '';
        } else {
          if (isset($_GET['manufacturers_id'])) {
          $lc_text = '<a target="_blank" target="_blank" href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), 'products_id=' . $listing->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $listing->fields['products_image'], $listing->fields['products_name'], IMAGE_PRODUCT_LISTING_WIDTH, IMAGE_PRODUCT_LISTING_HEIGHT, 'class="listingProductImage"') . '</a>';
          } else {
          $lc_text = '<a  target="_blank" target="_blank" href="' . zen_href_link(zen_get_info_page($listing->fields['products_id']), ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $listing->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $listing->fields['products_image'], $listing->fields['products_name'], IMAGE_PRODUCT_LISTING_WIDTH, IMAGE_PRODUCT_LISTING_HEIGHT, 'class="listingProductImage"') . '</a>';
          }
        }
          break;
      }

      $product_contents[] = $lc_text; // Used For Column Layout (Grid Layout) Option

      if (PRODUCT_LISTING_LAYOUT_STYLE == 'rows') {
        $list_box_contents[$rows][$col] = array('align' => $lc_align,
                                                'params' => 'class="productListing-data"',
                                                'text'  => $lc_text);
      }
    }

    // Following code will be executed only if Column Layout (Grid Layout) option is chosen
    if (PRODUCT_LISTING_LAYOUT_STYLE == 'columns') {
      $lc_text = implode('', $product_contents);
      $list_box_contents[$rows][$column] = array('params' => 'class="centerBoxContentsProducts centeredContent back"' . ' ' . 'style="width:' . $col_width . '%;"',
                                                 'text'  => $lc_text);
      $column ++;
      if ($column >= PRODUCT_LISTING_COLUMNS_PER_ROW) {
        $column = 0;
        $rows ++;
      }
    }
    // End of Code fragment for Column Layout (Grid Layout) option in add on module
    $listing->MoveNext();
  }
  $error_categories = false;
} else {
  $list_box_contents = array();

  $list_box_contents[0] = array('params' => 'class="productListing-odd"');
  $list_box_contents[0][] = array('params' => 'class="productListing-data"',
                                  'text' => TEXT_NO_NEW_PRODUCTS);

  $error_categories = true;
}


  if ($how_many > 0 && PRODUCT_LISTING_MULTIPLE_ADD_TO_CART != 0 and $show_submit == true and $listing_split->number_of_rows > 0) {
  // bof: multiple products
    echo zen_draw_form('multiple_products_cart_quantity', zen_href_link(FILENAME_DEFAULT, zen_get_all_get_params(array('action')) . 'action=multiple_products_add_product'), 'post', 'enctype="multipart/form-data"');
  }

?>