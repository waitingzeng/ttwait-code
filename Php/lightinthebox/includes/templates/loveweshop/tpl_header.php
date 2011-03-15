<?php
/**
 * Common Template - tpl_header.php
 *
 */
?>

<?php
  // Display all header alerts via messageStack:
  if ($messageStack->size('header') > 0) {
    echo $messageStack->output('header');
  }
  if (isset($_GET['error_message']) && zen_not_null($_GET['error_message'])) {
  echo htmlspecialchars(urldecode($_GET['error_message']));
  }
  if (isset($_GET['info_message']) && zen_not_null($_GET['info_message'])) {
   echo htmlspecialchars($_GET['info_message']);
} else {

}
?>


<!--bof-header logo and navigation display-->
<?php
if (!isset($flag_disable_header) || !$flag_disable_header) {
	switch ($current_page){
		case 'checkout_shipping':
			echo '<div class="ck_w margin_t center">';
		  break;
		default:
			echo '<div id="headerblock">';		
	}
?>

<div style="display:none;" id="chat_div">
	<div class="g_t_c">
	<!-- BOF Chat Live -->
<a href="<?php echo zen_href_link(FILENAME_CONTACT_US); ?>"><?php echo zen_image($template->get_template_dir('lp.gif', DIR_WS_TEMPLATE, $current_page_base,'images'). '/lp.gif','','','',' class="margin_t"'); ?></a>
<!-- EOF Chat Live -->	</div>
	<div id="chat_div_name" class="pad_l_28px margin_t g_t_l"><ul class="gray_trangle_list"/></div>
	<img width="13" height="13" border="0" onclick="close_chat_div()" src="<?php echo HTTP_SERVER.DIR_WS_CATALOG;?>images/root/close.gif" title="close" alt="close" id="chat_div_close_img"/>
	</div>
<!--bof-branding display-->
<div id="logoWrapper">
    <?php switch ($current_page){
			    	case 'checkout_shipping':
			    	case 'checkout_payment':
			    	case 'checkout_login':
			    	case 'checkout_shipping_address':
			    	case 'address_book_process':
    	      ?>
    	      <div class="ck_w center">
				    <ul id="intro">
				    <?php if($this_is_home_page){?>
					    <li class="index_logo"><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '" title="'. SEO_COMMON_KEYWORDS.' '.STORE_NAME .'"><span class="hand">' . zen_image($template->get_template_dir(HEADER_LOGO_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . HEADER_LOGO_IMAGE, HEADER_ALT_TEXT) . '</span></a>'; ?></li>
				    <?php }else{ ?>
					    <li class="logo"><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '" onfocus="if( this.blur ) this.blur();"><span class="hand">' . zen_image($template->get_template_dir(HEADER_LOGO_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . HEADER_LOGO_IMAGE, HEADER_ALT_TEXT) . '</span></a>'; ?></li>
				    <?php } ?>
				    <li class="black big"><?php echo STORE_SLOGAN; ?></li>
				    </ul>
				    <li class="fr">
	            <img height="44" width="94" border="0" src="includes/templates/<?php echo $template_dir; ?>/images/logo/gif_logo1.gif" style="margin: 0pt 12px 4px 0pt;"/>
	            <img border="0" alt="wholesale Check to Verisign" title="wholesale Check to Verisign " src="includes/templates/<?php echo $template_dir; ?>/images/logo/gif_logo2.gif"/>
            </li>
            </div>
		<?php break;
		      default:
		      require($template->get_template_dir('tpl_modules_header_right.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_header_right.php'); 
		      ?>
			    <ul id="intro">
			    <?php if($this_is_home_page){?>
				    <li class="index_logo"><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '" title="'. SEO_COMMON_KEYWORDS.' '.STORE_NAME .'"><span class="hand">' . zen_image($template->get_template_dir(HEADER_LOGO_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . HEADER_LOGO_IMAGE, HEADER_ALT_TEXT) . '</span></a>'; ?></li>
			    <?php }else{ ?>
				    <li class="logo"><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '" onfocus="if( this.blur ) this.blur();"><span class="hand">' . zen_image($template->get_template_dir(HEADER_LOGO_IMAGE, DIR_WS_TEMPLATE, $current_page_base,'images'). '/' . HEADER_LOGO_IMAGE, HEADER_ALT_TEXT) . '</span></a>'; ?></li>
			    <?php } ?>
			    <li class="black big"><?php echo STORE_SLOGAN; ?></li>
			    </ul>
			   
			    <ul id="login">
			    <li class="fl" style="height:36px;"></li>
			    </ul>
			    <ul id="bookmark">
			      <li class="fr">
			        <!-- AddThis Bookmark Button BEGIN -->
			        <script type="text/javascript">
			          addthis_url    = location.href;   
			          addthis_title  = document.title;  
			          addthis_pub    = 'showq';     
			        </script>
			        <script type="text/javascript" src="<?php echo HTTP_SERVER.DIR_WS_CATALOG?>includes/templates/<?php echo $template_dir?>/jscript/bookmark.js"></script>
			        <!-- AddThis Bookmark Button END -->
			      </li>
			      <?php if (isset($_SESSION['customer_id'])){ ?>
			      <li class="fr pad_r_5px">Welcome!&nbsp; <a target="_top" href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL');?>" title="Sign in"><?php echo zen_get_customer_name($_SESSION['customer_id']); ?></a>&nbsp;or&nbsp; <a target="_top" href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL');?>" title="Register"> Logout </a> </li>
			      <?php }else{ ?>
			      <li class="fr pad_r_5px">Welcome!&nbsp; <a target="_top" href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL');?>" title="Sign in"> Sign in </a>&nbsp;or&nbsp; <a target="_top" href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL');?>" title="Register"> Register </a> </li>
			      <?php } ?>
			    </ul>		
		<?php } ?>
</div>
<br class="clear" />
<!--eof-branding display-->

<!--eof-header logo and navigation display-->
</div>
<?php } ?>