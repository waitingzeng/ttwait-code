<?php
function zen_categories_generator() {
	global $languages_id, $db;
	$data = array();
	$categories_query = "select c.categories_id, cd.categories_name, c.parent_id
               from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
               where c.categories_id = cd.categories_id
               and c.categories_status=1
               and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
               order by c.parent_id, cd.categories_name";
     $categories = $db->Execute($categories_query);
     while (!$categories->EOF) {
       $data[$categories->fields['parent_id']][$categories->fields['categories_id']] = array('name' => $categories->fields['categories_name'], 'count' => 0);
       $categories->MoveNext();
     }
     $data2 = array();
     foreach ($data[0] as $id => $item) {
     	if(array_key_exists($id, $data)){
     		foreach ($data[$id] as $cid => $value) {
     			$item['cpath'] = 'cPath='.$id.'_'.$cid;
     			$data2[$value['name']][$cid] = $item;
     		}
     	}
     }
     return $data2;
}

$title = '';
$index_categories = zen_categories_generator();
$num_categories = count($index_categories);

$row = 0;
$col = 0;
$list_box_contents = '';
if ($num_categories > 0) {
  if ($num_categories < MAX_DISPLAY_CATEGORIES_PER_ROW || MAX_DISPLAY_CATEGORIES_PER_ROW == 0) {
    $col_width = floor(100/$num_categories);
  } else {
    $col_width = floor(100/MAX_DISPLAY_CATEGORIES_PER_ROW);
  }

  $i = 0;
  $names = array_keys($index_categories);
  sort($names);
  foreach ($names as $name) {
  	$top_categorys = $index_categories[$name];
  	$i += 1;
  	$event = "onMouseOver=\"MM_showHideLayers('layer".$i."','','show')\" onMouseOut=\"MM_showHideLayers('layer".$i."','','hide')\"";
  	$lc_text = '';
  	$logoimg = 'logo/'.strtolower($name).'.jpg';
  	if(!file_exists(DIR_WS_IMAGES . $logoimg)){
  		continue;
  	}
  	$lc_text .= '<div class="brandLogo" '.$event.'>'.zen_image(DIR_WS_IMAGES . $logoimg, $name, SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT) . '<br />' . $name.'</div>';
    $lc_text .= '<div id="layer'.$i.'" class="layercss" '.$event.'><ul>';
    foreach ($top_categorys as $id => $item) {
    	$cPath_new = $item['cpath'];
    	// strip out 0_ from top level cats
    	$lc_text .= '<li><a href="' . zen_href_link(FILENAME_DEFAULT, $cPath_new) . '">-' . $item['name'] . '</a></li>';
    }
    $lc_text .= '</ul></div>';
 
  	$list_box_contents[$row][$col] = array('params' => 'class="categoryListBoxContents"' . ' ' . 'style="width:' . $col_width . '%;"',
                                           'text' => $lc_text);
    
    $col ++;
    if ($col > (MAX_DISPLAY_CATEGORIES_PER_ROW -1)) {
      $col = 0;
      $row ++;
    }
  }
}
?>
