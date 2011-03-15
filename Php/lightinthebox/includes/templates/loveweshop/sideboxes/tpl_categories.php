<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_categories.php 4162 2006-08-17 03:55:02Z ajeh $
 */
  //print_r($box_categories_array);
  //print_r($cPath_array);
  //print_r($current_category_id);
  $content = "";
  //$content .= '<div class="pad_1em">' . "\n";
  $category_depth == !zen_has_category_subcategories($cPath_array[sizeof($cPath_array) - 1]) ? array_pop($cPath_array) : '';
  function showBoxCategory($cPath_array,$ii) {
  	global $db,$current_category_id,$category_depth;
  	if($current_category_id == $cPath_array[$ii]){
  		$content .= '<dt class="b red">'.zen_get_category_name($cPath_array[$ii],$_SESSION['languages_id']).'<span class="arrow_r">&nbsp;</span></dt>';
  	}else{
  		$content .= '<dd class="back"><span class="arrow_l fl bcl'.$ii.'">&nbsp;</span><a class="ac1'.$ii.'" href="'.zen_href_link(FILENAME_DEFAULT, 'cPath='.$cPath_array[$ii]).'">' .zen_get_category_name($cPath_array[$ii],$_SESSION['languages_id']).'</a></dd>';
  	}
   	$ii++;
	if ($ii < sizeof($cPath_array) ) {
    	$content .= showBoxCategory($cPath_array, $ii);
	}else {
		if(zen_has_category_subcategories($cPath_array[$ii])){
			//$content .= $cPath_array[$ii];
			//$content .= '<ul class="pad_1em">';
			$subcategories_query = "select categories_id
                            from " . TABLE_CATEGORIES . "
                            where parent_id = '" . (int)$cPath_array[$ii-1]. "' order by sort_order";
			$subcategoriesArray = $db->Execute($subcategories_query);
			while (!$subcategoriesArray->EOF) {
				$name = zen_get_category_name($subcategoriesArray->fields['categories_id'],$_SESSION['languages_id']);
				if ($category_depth && $subcategoriesArray->fields['categories_id'] == $current_category_id) {
					$content .= '<dd class="b red">'.$name.'<span class="arrow_r">&nbsp;</span></dd>';
				}else{
					$content .= '<dd><a href="'.zen_href_link(FILENAME_DEFAULT, 'cPath='.$subcategoriesArray->fields['categories_id']).'"';
					$content .= '>'.$name.'</a></dd>';
				}
				$subcategoriesArray->MoveNext();
			}
			//$content .= '</ul>';				
		}else{
			print_r('ERROR');
		}

	}

    return $content;
	}
	if (sizeof($cPath_array) > 0){
	  $content .= showBoxCategory($cPath_array,0);
	}else{
		$content .= '<a href="'.zen_href_link(FILENAME_DEFAULT, 'cPath='.$current_category_id).'" class="red b"> &lt;' . zen_get_category_name($current_category_id,$_SESSION['languages_id']).'</a>';
	}
  //$content .= '</div>';
?>