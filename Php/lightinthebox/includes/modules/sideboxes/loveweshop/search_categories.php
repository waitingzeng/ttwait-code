<?php
/**
 * categories sidebox - prepares content for the main categories sidebox
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: categories.php 2718 2005-12-28 06:42:39Z drbyte $
 */
		
    $row = 0;
    $priceListArray = array();
    $priceList = array();

// don't build a tree when no categories
//    reset($list_box_contents2);
    $totalNum = sizeof($list_box_contents2);
    for ($i = 0;$i < $totalNum; $i++){
    	$priceListArray[] = $list_box_contents2[$i]['products_price'];
    }
    sort($priceListArray);
    echo '<div id="category_left_menu" class="margin_t allborder bg_box_gray">';
    echo '<h3 class="pad_l_10px line_20px bg_box_eecd gray">Narrow By</h3>';
    echo '<dl class="lnav">';
    echo '<dt class="big b">Price</dt>';
    echo '<dt class="b red">Any Price<span class="arrow_r">&nbsp;</span></dt>';
    $priceListOutString = '';
    if ($totalNum <= 5){
    	$priceListRowNum = 1;
    }elseif ( 5 < $totalNum and $totalNum <= 15){
    	$priceListRowNum = 2;  	
    }elseif (15 < $totalNum and $totalNum <= 25){
    	$priceListRowNum = 3;
    }elseif (25 < $totalNum and $totalNum <= 35){
    	$priceListRowNum = 4;
    }elseif ($totalNum >= 35){
      $priceListRowNum = 5;
    }
    
    for ($i=0; $i<$priceListRowNum; $i++){
     echo '<dd>';
     echo '<a href="'.cleanSameArg2('min_price','max_price').'&min_price='.floor($priceListArray[$totalNum*$i/$priceListRowNum]).'&max_price='.floor($priceListArray[$totalNum*($i+1)/$priceListRowNum-1]).'"  rel="nofollow">';
     echo $currencies->display_price($priceListArray[$totalNum*$i/$priceListRowNum],zen_get_tax_rate($_GET['products_tax_class_id'])).' - '.$currencies->display_price($priceListArray[$totalNum*($i+1)/$priceListRowNum-1],zen_get_tax_rate($_GET['products_tax_class_id']));    
     echo '</a>';
     echo '</dd>';
    }
    echo '</dl>';
    echo '</div>';
?>