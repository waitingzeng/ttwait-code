<?php
/**
* PureBlue Template designed by zen-cart-power.com
* zen-cart-power.com - Free Zen Cart templates and modules
* Power your Zen Cart!
* 
* Common Template - tpl_footer.php
*
* @package templateSystem
* @copyright Copyright 2008-2009 Zen-Cart-Power.com
* @copyright Copyright 2003-2005 Zen Cart Development Team
* @copyright Portions Copyright 2003 osCommerce
* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
* @version $Id: tpl_footer.php 4821 2006-10-23 10:54:15Z drbyte $
*/
require(DIR_WS_MODULES . zen_get_module_directory('footer.php'));
?>
<?php
if (!isset($flag_disable_footer) || !$flag_disable_footer) {
?>

<div id="navSuppWrapper">
		<!--bof-navigation display -->
		<?php if (EZPAGES_STATUS_FOOTER == '1' or (EZPAGES_STATUS_FOOTER == '2' and (strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])))) { ?>
		<?php require($template->get_template_dir('tpl_ezpages_bar_footer.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_ezpages_bar_footer.php'); ?>
		<?php } ?>
		<!--eof-navigation display -->
	

	<!--bof- site copyright display 
	<div id="siteinfoLegal" class="legalCopyright"><?php echo FOOTER_TEXT_BODY; ?></div> <br/>
	eof- site copyright display -->

	<!--bof-ip address display -->
	<?php
	if (SHOW_FOOTER_IP == '1') {
	?>
	<div id="siteinfoIP"><?php echo TEXT_YOUR_IP_ADDRESS . '  ' . $_SERVER['REMOTE_ADDR']; ?></div>
	<?php
	}
	?>
    <!--eof-ip address display -->

	<div class="clearBoth"></div>
</div>


<!--bof-banner #5 display -->
<?php
  if (SHOW_BANNERS_GROUP_SET5 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET5)) {
    if ($banner->RecordCount() > 0) {
?>
<div id="bannerFive" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
<?php
    }
  }
?>
<!--eof-banner #5 display -->

<?php
} // flag_disable_footer
?>

<?php
if(false&&!isset($links)){
	$links = array('Western Union' => 'http://www.westernunion.com',
		 'MoneyBookers' => 'http://www.moneybookers.com',
		 'MoneyGram' => 'http://www.moneygram.com',
		 'Bank Of China' => 'http://www.boc.cn/en/index.html',
		 'EMS' => 'http://www.ems.com.cn', 
		 'DHL' => 'http://www.dhl.com', 
		 'TNT' => 'http://www.tnt.com', 
		 'UPS' => 'http://www.ups.com');
	$content = '<div class="banners">';
	foreach ($links as $name=>$link) {
		$content .= '<a href="'.$link.'" target="_blank"><img src="images/links/' . strtolower($name) .'.gif" alt="'.$name.'" title="'.$name.'" height="35px" /></a>';
	}
	$content .= '</div>';
	echo $content;
}
if(GOOGLE_ANALYTICS_ID != ''){
?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("<?php echo GOOGLE_ANALYTICS_ID;?>");
pageTracker._trackPageview();
} catch(err) {}</script>
<?php }?>