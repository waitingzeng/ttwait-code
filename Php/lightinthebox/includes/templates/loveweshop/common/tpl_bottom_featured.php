<?php
/**
 * Common Template - tpl_columnar_display.php
 *
 * This file is used for generating tabular output where needed, based on the supplied array of table-cell contents.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_columnar_display.php 3157 2006-03-10 23:24:22Z drbyte $
 */

?>
<div id="f_product"><h3 class="in_1em line_30px"><?php if ($title) {echo $title;} ?></h3>
<p>The top quality wedding dress, bridesmaid dress, flower girl dress and mother dress at pretty cheap price. Simply place the order and get your dreaming dress within only 30-60 days with your own size. Free shipping worldwide, it's simple to order from us. Action now! <br/>
</p>
</div>
<div id="reco_product" class="fr"><ul>
<?php
if (is_array($list_box_contents) > 0 ) {
	$list_box_contentsNum = count($list_box_contents);
 for($row=0;$row<$list_box_contentsNum;$row++) {
    $params = "";
    //if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
    $tempNum = count($list_box_contents[$row]);
    for($col=0;$col< $tempNum;$col++) {
       echo '<li>' . $list_box_contents[$row][$col]['text'] .  '</li>' . "\n";
      }
    unset($tempNum);
   }
?>
<br class="clear" />
<?php
  }
?>
</ul></div>
