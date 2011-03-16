<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: categories_ul_generator.php 2004-07-11  DrByteZen $
//      based on site_map.php v1.0.1 by networkdad 2004-06-04
//

 class zen_categories_ul_generator {
   var $root_category_id = 0,
       $max_level = 5,
       $data = array(),
       $root_start_string = '',
       $root_end_string = '',
       $parent_start_string = '',
       $parent_end_string = '',

       $parent_group_start_string = '<ul%s>',
       $parent_group_end_string = '</ul>',

       $child_start_string = '<li%s>',
       $child_end_string = '</li>',

       $spacer_string = '',
       $spacer_multiplier = 1;

   function zen_categories_ul_generator($load_from_database = true) {
     global $languages_id, $db;
  $this->data = array();
  $categories_query = "select c.categories_id, cd.categories_name, c.parent_id
                       from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                       where c.categories_id = cd.categories_id
                       and c.categories_status=1
                       and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                       order by c.parent_id, cd.categories_name";
         $categories = $db->Execute($categories_query);
         while (!$categories->EOF) {
           $this->data[$categories->fields['parent_id']][$categories->fields['categories_id']] = array('name' => $categories->fields['categories_name'], 'count' => 0);
           $categories->MoveNext();
         }
//DEBUG: These lines will dump out the array for display and troubleshooting:
//foreach ($this->data as $pkey=>$pvalue) { 
//   foreach ($this->data[$pkey] as $key=>$value) { echo '['.$pkey.']'.$key . '=>' . $value['name'] . '<br>'; }
//}
   }

   function buildBranch($parent_id, $level = 0, $submenu=false) {
     $result = sprintf($this->parent_group_start_string, ($submenu==true) ? ' class="level'. ($level+1) . '"' : '' );

     if (isset($this->data[$parent_id])) {
       foreach ($this->data[$parent_id] as $category_id => $category) {
         $category_link = $category_id;
         if (isset($this->data[$category_id])) {
         $result .= sprintf($this->child_start_string, ($submenu==true) ? ' class="submenu"' : '');
         } else {
         $result .= sprintf($this->child_start_string, '');
         }
         if (isset($this->data[$category_id])) {
           $result .= sprintf($this->parent_start_string, ($submenu==true) ? ' class="level'.($level+1) . '"' : '');
         }

         if ($level == 0) {
           $result .= $this->root_start_string;
         }
         $result .= str_repeat($this->spacer_string, $this->spacer_multiplier * $level) . '<a href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $category_link) . '">';
         $result .= $category['name'];
         $result .= '</a>';

         if ($level == 0) {
           $result .= $this->root_end_string;
         }

         if (isset($this->data[$category_id])) {
           $result .= $this->parent_end_string;
         }

         if (isset($this->data[$category_id]) && (($this->max_level == '0') || ($this->max_level > $level+1))) {
           $result .= $this->buildBranch($category_id, $level+1, $submenu);
         }
         $result .= $this->child_end_string;

       }
     }

     $result .= $this->parent_group_end_string;

     return $result;
   }

   //function buildTree($submenu=false) {
   //  return $this->buildBranch($this->root_category_id, '', $submenu);
   //}
   
   function buildTree()
   {
   		$result = array();
   		$result[] = '<ul>';
   		foreach ($this->data[$this->root_category_id] as $cid => $category) {
   			//print var_dump($cid);
   			$cls = '';
   			if(!isset($this->data[$cid]))$cls = 'class="leaf"';
   			$result[] = '<li><a href="'.zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cid).'" '.$cls.'>'. $category['name'].'<!--[if IE 7]><!-->
</a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->';
   			if(isset($this->data[$cid])){
   				$result[] = '<ul>';
   				foreach ($this->data[$cid] as $tid => $value) {
   					$result[] = '<li><a href="'.zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cid.'_'.$tid).'">'.$value['name'].'</a></li>';
   				}
   				$result[] = '<!--[if lte IE 6.5]><![endif]--></ul>';
   			}
   			$result[] = '<!--[if lte IE 6]></td></tr></table></a><![endif]--></li>';
   		}
   		$result[] = '<div style=" clear:both; visibility:hidden;"> ';
   		$result[] = '</ul>';
   		return join('', $result);
   }
   function buildTree2()
   {
   		$result = array();
   		$result[] = '<ul id="nav">';
   		foreach ($this->data[$this->root_category_id] as $cid => $category) {
   			//print var_dump($cid);
   			$result[] = '<li><a href="javascript:show('.$cid.');" class="sone">'. $category['name'].'</a><!--[if IE 7]><!-->
</a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]-->';
   			if(isset($this->data[$cid])){
   				$result[] = '<ul id="menusub'.$cid.'" style="display:none;">';
   				foreach ($this->data[$cid] as $tid => $value) {
   					$result[] = '<li><a href="'.zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cid.'_'.$tid).'" class="stwo">'.$value['name'].'</a></li>';
   				}
   				$result[] = '<!--[if lte IE 6.5]><![endif]--></ul>';
   			}
   			$result[] = '<!--[if lte IE 6]></td></tr></table><![endif]--></li>';
   		}
   		$result[] = '<div style=" clear:both; visibility:hidden;"> ';
   		$result[] = '</ul>';
   		return join('', $result);
   }
 }
?>