<?php
/**
* PureBlue Template designed by zen-cart-power.com
* zen-cart-power.com - Free Zen Cart templates and modules
* Power your Zen Cart!
* 
* @copyright Copyright 2008-2009 Zen-Cart-Power.com
* @copyright Copyright 2003-2006 Zen Cart Development Team
* @copyright Portions Copyright 2003 osCommerce
* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
* @version $Id: index.php 6550 2007-07-05 03:54:54Z drbyte $
*/    
?>

<div id="top_nav">
<div id="tab_nav">
<!--<div class="top-nav-left"></div>-->
<div class="top-nav-right"></div>
	<ul class="list-style-none">
		<li class="home-link"><a href="<?php echo '' . HTTP_SERVER . DIR_WS_CATALOG;?>"><!--img src="images/spacer.gif" width="1" height="14" alt=""--></a></li>

<?php
if ($current_page_base == 'account' || $current_page_base == 'login' || $current_page_base == 'account_edit' || $current_page_base == 'address_book' || $current_page_base == 'account_password' || $current_page_base == 'account_newsletters' || $current_page_base == 'account_notifications') { $active = 'tab_active'; 
	} else { $active = '';
}?>
		<li id="<?php echo $active;?>"><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><?php echo TOP_MENU_MY_ACCOUNT;?></a></li>


<!--TTwait add -->
			<?php if($current_page_base == 'payment'){$active='tab_active';}
            	else{$active='';}		
            ?>
            <li id="<?php echo $active;?>"><a href="<?php echo zen_href_link('payment'); ?>"><span><?php echo BOX_INFORMATION_PAYMENT; ?></span></a></li>
            <?php if (DEFINE_SHIPPINGINFO_STATUS <= 1) {
            	if($current_page_base == 'shippinginfo'){$active='tab_active';}
            	else{$active='';}	
            ?>
            <li id="<?php echo $active;?>"><a href="<?php echo zen_href_link(FILENAME_SHIPPING); ?>"><span><?php echo BOX_INFORMATION_SHIPPING; ?></span></a></li>
            <?php }?>
            <?php if (DEFINE_CONDITIONS_STATUS <= 1) {
            	if($current_page_base == 'conditions'){$active='tab_active';}
            	else{$active='';}		
            ?>
            <li id="<?php echo $active;?>"><a href="<?php echo zen_href_link(FILENAME_CONDITIONS); ?>"><span><?php echo BOX_INFORMATION_CONDITIONS; ?></span></a></li>
            <?php }?>
            <?php if (DEFINE_PRIVACY_STATUS <= 1) {
            	if($current_page_base == 'privacy'){$active='tab_active';}
            	else{$active='';}		
            ?>
            <li id="<?php echo $active;?>"><a href="<?php echo zen_href_link(FILENAME_PRIVACY); ?>"><span><?php echo BOX_INFORMATION_PRIVACY; ?></span></a></li>
            <?php }?>
            <?php if (DEFINE_CONTACT_US_STATUS <= 1) {
            	if($current_page_base == 'contact_us'){$active='tab_active';}
            	else{$active='';}
            ?>
            <li id="<?php echo $active;?>"><a href="<?php echo zen_href_link(FILENAME_CONTACT_US); ?>"><span><?php echo BOX_INFORMATION_CONTACT; ?></span></a></li>
            <?php }?>
            <!--TTwait add end-->
	</ul>
</div>


<div id="login_logout_section" class="float-right">
    <ul class="list-style-none inline-list">
<?php if ($_SESSION['customer_id']) { ?>
	<li>
		<a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><?php echo ($_SESSION['customer_first_name'].' '.$_SESSION['customer_last_name']);?></a>
	</li>
    <li><a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGOFF; ?></a></li>
	</ul>
<?php
      } else {
        if (STORE_STATUS == '0') {
?>
    <a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGIN; ?></a>
	<?php echo HEADER_OR; ?>
    <a href="<?php echo zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'); ?>"><?php echo HEADER_TITLE_REGISTER; ?></a>
<?php } } ?>

<?php /*if ($_SESSION['cart']->count_contents() != 0) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'); ?>"><?php echo HEADER_TITLE_CART_CONTENTS; ?></a></li>
    <li><a href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'); ?>"><?php echo HEADER_TITLE_CHECKOUT; ?></a></li>
<?php } */?>

</div>
</div>

<!-- tools section -->
<div id="tools_wrapper" class="align-center">
	<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td class="td-search-header">
		<div class="search-header float-left">
            <?php require($template->get_template_dir('tpl_search_header.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_search_header.php');?>
    		<div class="advanced_search float-left">
                <a href="index.php?main_page=advanced_search"><?php echo HEADER_ADVANCED_SEARCH; ?></a>
            </div>
		</div>
		</td>
		<td>
		<!-- header cart section -->
		<table class="align-center cart-header">
		<tr>
			<td>
			<?php require($template->get_template_dir('tpl_shopping_cart_header.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_shopping_cart_header.php'); 
			echo $content;
			/*require($template->get_template_dir('tpl_box_header.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_box_header.php');*/?>		
			</td>
			<?php if ($_SESSION['cart']->count_contents() != 0) { ?>
			<td>&nbsp;|<td>
			<td class="blue-link">
				<a href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'); ?>"><?php echo HEADER_TITLE_CHECKOUT; ?></a>
			</td>
			<?php }?>
		</tr>
		</table>
		<!-- /header cart section -->


		</td>
		<td class="td-languages">
			<div class="languages-wrapper">
				
				<div class="clearBoth"></div>
			</div>
    	</td>
	</tr>
	</table>
</div>
<div class="dotted-line line-header"></div>
<!-- /tools section -->

