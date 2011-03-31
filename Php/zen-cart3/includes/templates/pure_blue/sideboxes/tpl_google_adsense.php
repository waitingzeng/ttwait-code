<?php
/**
 * Google Adsense Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 *
 * @version $Id: tpl_google_adsense.php  2006-06-06 06:06:06Z gilby
 *
 */

$content = '<div id="googleadsenseContent" class="sideBoxContent centeredContent">';

/* Your google code goes between the 2 single quotes in the next line */
$content .= '<script type="text/javascript"><!--
google_ad_client = "pub-2955786967867023";
/* 160x90, created 4/1/10 zhouzuai */
google_ad_width = 160;
google_ad_height = 90;
google_ad_format = "160x90_0ads_al";
google_ad_channel = "";
google_color_border = "FFFFFF";
google_color_bg = "FFFFFF";
google_color_link = "454545";
google_color_text = "454545";
google_color_url = "454545";
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';

$content .= '</div>';

?>
