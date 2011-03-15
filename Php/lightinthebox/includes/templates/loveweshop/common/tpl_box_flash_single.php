<?php
/**
 * Common Template - tpl_box_default_single.php
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_box_default_single.php 2975 2006-02-05 19:33:51Z birdbrain $
 */

// choose box images based on box position
//
if($this_is_home_page){
?>
<!--// bof: <?php echo $box_id; ?> //-->
<div class="midframe fl relative">
<script type="text/javascript">
var flashv = new Array();
flashv.push(["wholesale-Electronics_c2619","images/wholesale/201001/Flash031263973932.jpg"]);
flashv.push(["wholesale-Health-and-Beauty_c76","images/wholesale/201001/e_031263291878.jpg"]);
flashv.push(["wholesale-Less-than--1-99_c3929","images/wholesale/200912/e1262156212.jpg"]);
function showXml() {return flashv;}
var fPath = 'http://i2.lbox.me/swf/litb.swf';
var fstr = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="535" height="180" id="flashObject" align="middle">';
fstr += '<param name="allowScriptAccess" value="always" />';
fstr += '<param name="movie" value="'+fPath+'" />';
fstr += '<param name="quality" value="best" />';
fstr += '<param name="bgcolor" value="#ffffff" />';
fstr += '<param name="wmode" value="transparent" />';
fstr += '<embed src="'+fPath+'" wmode="transparent" quality="high" bgcolor="#ffffff" width="535" height="180" name="flashObject" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />';
fstr += '</object>';
document.write(fstr);
</script>

</div>
<!--// eof: <?php echo $box_id; ?> //-->
<?php } ?>
