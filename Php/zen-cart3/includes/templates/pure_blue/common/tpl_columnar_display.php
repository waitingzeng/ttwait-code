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
<?php
  if ($title) {
  ?>
<?php echo $title; ?>
<?php
 }
 ?>
  <div class="centerBoxWrapperContents">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">

<?php
if (is_array($list_box_contents) > 0 ) {

$MaxCol=0;
 for($row=0;$row<sizeof($list_box_contents);$row++) {
    $params = "";
    //if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
?>
<tr>
<?php
    for($col=0;$col<sizeof($list_box_contents[$row]);$col++) {
      $r_params = "";
      if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
$r_params = str_replace("50", "98", $r_params);
$r_params = str_replace("33", "98", $r_params);
$r_params = str_replace("25", "98", $r_params);
$col_width = str_replace("50", "48", $col_width);
$col_width = str_replace("33", "31", $col_width);
$col_width = str_replace("25", "23", $col_width);
     if (isset($list_box_contents[$row][$col]['text'])) {
?>
    <?php 
    //echo '<!--<td width="'. ($col_width-((sizeof($list_box_contents[$row])-1))) .'%"><div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div></td>-->' . "\n"; 
    //echo '<td width="'. $col_width .'%" align="right"><div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div></td>' . "\n";
    echo '<td width="'. $col_width .'%" align="center" valign="top"><div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div></td>' . "\n";
     ?>
    <?php if ($row == 0 && $col < (sizeof($list_box_contents[$row]) - 1)) {
            echo '<td class="vDotLine" rowspan="' . ((sizeof($list_box_contents))*2) . '"></td>' . "\n";
          	$MaxCol += 1;
          }

      }
    }
?>

</tr>

<?php 
	if ($row < (sizeof($list_box_contents)-1)) {?>
<tr>
	<?php	for($col=0;$col<($MaxCol + 1);$col++) {
	  echo '<td class="hDotLine"></td>';
	} ?>
</tr>
<?php	}
	?>


<?php
  }
}
?>
</table>
 </div>