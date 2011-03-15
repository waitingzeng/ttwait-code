<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title>
	<?php 
	if(is_home()) {  
		echo get_bloginfo('description') . " &raquo; " . get_bloginfo('name'); 
	} 
	else { 
		echo wp_title('', false) . " &raquo; " . get_bloginfo('name'); 
	} 
	?>	
</title>
<?php define('ZROOT','http://www.electronics-store-china.com/');?>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/print.css" type="text/css" media="print" />

<!-- Sidebar docking boxes (dbx) by Brothercake - http://www.brothercake.com/ -->
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/dbx.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/dbx-key.js"></script>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/dbx.css" media="screen, projection" />

<!--[if lt IE 7]>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/ie-gif.css" type="text/css" />
<![endif]-->

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


<script type="text/javascript">var baseURL = "<?php echo ZROOT;?>"</script>
<link href="<?php echo ZROOT;?>includes/templates/lightinthebox/css/global.css" type="text/css" rel="stylesheet">
<link href="<?php echo ZROOT;?>includes/templates/lightinthebox/css/style_imagehover.css" type="text/css" rel="stylesheet">
<link href="<?php echo ZROOT;?>includes/templates/lightinthebox/css/style_sheets.css" type="text/css" rel="stylesheet">
<link href="<?php echo ZROOT;?>includes/templates/lightinthebox/css/theme-2.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="<?php echo ZROOT;?>includes/templates/lightinthebox/jscript/jscript_AC_RunActiveContent.js"></script>
<script type="text/javascript" src="<?php echo ZROOT;?>includes/templates/lightinthebox/jscript/jscript_SpryMenuBar.js"></script>
<script type="text/javascript" src="<?php echo ZROOT;?>includes/templates/lightinthebox/jscript/jscript_foot_search.js"></script>
<script type="text/javascript" src="<?php echo ZROOT;?>includes/templates/lightinthebox/jscript/jscript_frmCheck.js"></script>
<script type="text/javascript" src="<?php echo ZROOT;?>includes/templates/lightinthebox/jscript/jscript_function.js"></script>
<script type="text/javascript" src="<?php echo ZROOT;?>includes/templates/lightinthebox/jscript/jscript_head_search.js"></script>
<script type="text/javascript" src="<?php echo ZROOT;?>includes/templates/lightinthebox/jscript/jscript_imagehover.js"></script>

<script type="text/javascript" src="<?php echo ZROOT;?>includes/templates/lightinthebox/jscript/jscript_productZoom.js"></script>
<script type="text/javascript" src="<?php echo ZROOT;?>includes/templates/lightinthebox/jscript/jscript_prototype.js"></script>
<script type="text/javascript" src="<?php echo ZROOT;?>includes/templates/lightinthebox/jscript/jscript_score.js"></script>
<script type="text/javascript" src="<?php echo ZROOT;?>includes/templates/lightinthebox/jscript/jscript_swfobject.js"></script>
<script type="text/javascript" src="<?php echo ZROOT;?>includes/modules/pages/product_info/jscript_textarea_counter.js"></script>

<?php wp_head(); ?>

</head>



<body>
<div id="page">
  <div id="wrapper">
    <div id="header">


<!--bof-header logo and navigation display-->
<div id="headerblock">
<div style="display:none;" id="chat_div">
	<div class="g_t_c">
	<!-- BOF Chat Live -->
<a href="<?php echo ZROOT;?>contact_us.html"><img src="<?php echo ZROOT;?>includes/templates/lightinthebox/images/lp.gif" alt="wholesale" title=" wholesale " width="184" height="53"  class="margin_t" /></a>
<!-- EOF Chat Live -->	</div>
	<div id="chat_div_name" class="pad_l_28px margin_t g_t_l"><ul class="gray_trangle_list"/></div>
	<img width="13" height="13" border="0" onclick="close_chat_div()" src="<?php echo ZROOT;?>images/root/close.gif" title="close" alt="close" id="chat_div_close_img"/>
	</div>
<!--bof-branding display-->
<div id="logoWrapper">
<!-- bof: featured products  -->

<div id="tabs">
  <ul>
    <li><a target="_top" class="one outer" rel="nofollow" href="<?php echo ZROOT;?>index.php?main_page=account">My Account
      <!--[if IE 7]><!--></a><!--<![endif]-->
      <!--[if lte IE 6]><table><tr><td style="position:absolute;left:0;top:0;"><![endif]-->
      <div class="tab_left">
        <p><a target="_top" title="View Orders" rel="nofollow" href="<?php echo ZROOT;?>index.php?main_page=account"> <span>View Orders</span></a></p>
        <p><a target="_top" title="Account Settings" rel="nofollow" href="<?php echo ZROOT;?>index.php?main_page=account_edit">Account Settings</a></p>
        <p><a target="_top" title="Manage Address Book" rel="nofollow" href="<?php echo ZROOT;?>index.php?main_page=manager_address">Manage Address Book</a></p>
      </div>
      <!--[if lte IE 6]></td></tr></table></a><![endif]-->
    </li>
    <li><a class="two outer" rel="nofollow" target="_top" href="#">Help
      <!--[if IE 7]><!--></a><!--<![endif]-->
      <!--[if lte IE 6]><table><tr><td style="position:absolute;left:0;top:0;"><![endif]-->
      <div class="tab_center">
        <p><a target="_top" rel="nofollow" href="<?php echo ZROOT;?>faq.html">Sumbit a Request</a></p>
        <p><a target="_top" rel="nofollow" href="<?php echo ZROOT;?>faqs_all.html">Knowledgebase</a></p>
      </div>
      <!--[if lte IE 6]></td></tr></table></a><![endif]-->
    </li>
    <li><a title="Currencies" rel="nofollow" class="three outer" href="/lightinthebox/microsoft-internet-keyboard-ps2_p25.html/#nogo">Currencies: <em>US$</em>
      <!--[if IE 7]><!--></a><!--<![endif]-->
      <!--[if lte IE 6]><table><tr><td style="position:absolute;left:0;top:0;"><![endif]-->
      <div class="tab_right">
                  	<p><img src="<?php echo ZROOT;?>includes/templates/lightinthebox/images/icons/flag/EUR.gif" alt="wholesale EUR" title=" wholesale EUR " width="16" height="11"  border="0" class="g_t_m" /><a target="_top" title="US Dollar" rel="nofollow" href="/lightinthebox/microsoft-internet-keyboard-ps2_p25.html?currency=EUR">Euro</a></p>
                  	<p><img src="<?php echo ZROOT;?>includes/templates/lightinthebox/images/icons/flag/GBP.gif" alt="wholesale GBP" title=" wholesale GBP " width="16" height="11"  border="0" class="g_t_m" /><a target="_top" title="US Dollar" rel="nofollow" href="/lightinthebox/microsoft-internet-keyboard-ps2_p25.html?currency=GBP">GB Pound</a></p>
                  	<p><img src="<?php echo ZROOT;?>includes/templates/lightinthebox/images/icons/flag/CAD.gif" alt="wholesale CAD" title=" wholesale CAD " width="16" height="11"  border="0" class="g_t_m" /><a target="_top" title="US Dollar" rel="nofollow" href="/lightinthebox/microsoft-internet-keyboard-ps2_p25.html?currency=CAD">Canadian Dollar</a></p>
                  	<p><img src="<?php echo ZROOT;?>includes/templates/lightinthebox/images/icons/flag/AUD.gif" alt="wholesale AUD" title=" wholesale AUD " width="16" height="11"  border="0" class="g_t_m" /><a target="_top" title="US Dollar" rel="nofollow" href="/lightinthebox/microsoft-internet-keyboard-ps2_p25.html?currency=AUD">Australian Dollar</a></p>
                  	<p><img src="<?php echo ZROOT;?>includes/templates/lightinthebox/images/icons/flag/HKD.gif" alt="wholesale HKD" title=" wholesale HKD " width="16" height="11"  border="0" class="g_t_m" /><a target="_top" title="US Dollar" rel="nofollow" href="/lightinthebox/microsoft-internet-keyboard-ps2_p25.html?currency=HKD">Hong Kong Dollars</a></p>
                  	<p><img src="<?php echo ZROOT;?>includes/templates/lightinthebox/images/icons/flag/CHF.gif" alt="wholesale CHF" title=" wholesale CHF " width="16" height="11"  border="0" class="g_t_m" /><a target="_top" title="US Dollar" rel="nofollow" href="/lightinthebox/microsoft-internet-keyboard-ps2_p25.html?currency=CHF">Switzerland Francs</a></p>
                </div>
      <!--[if lte IE 6]></td></tr></table></a><![endif]-->
    </li>
  </ul>
</div>
<!-- eof: featured products  -->
    <ul id="intro">
        <li class="logo"><a href="<?php echo ZROOT;?>" onfocus="if( this.blur ) this.blur();"><span class="hand"><img src="<?php echo ZROOT;?>includes/templates/lightinthebox/images/logo.jpg" alt="wholesale wholesale lightinthebox.com" title=" wholesale wholesale lightinthebox.com " width="194" height="46" /></span></a>    	</li>
    <li class="black big"><a class="pad_l" href="<?php echo ZROOT;?>">China Wholesale</a>,<font class="b">One World One Price</font></li>
    </ul>
<ul id="login">
<li class="fl" style="height:36px;"></li>
</ul>
<ul id="bookmark">
    <li class="fr pad_r_5px">Welcome!&nbsp; <a target="_top" href="<?php echo ZROOT;?>index.php?main_page=login" title="Sign in"> Sign in </a>&nbsp;or&nbsp; <a target="_top" href="<?php echo ZROOT;?>index.php?main_page=login" title="Register"> Register </a> </li>
	</ul>
</div>
<br class="clear" />
<!--eof-branding display-->

<!--eof-header logo and navigation display-->

<!--bof-optional categories tabs navigation display-->
<!--eof-optional categories tabs navigation display-->

</div>

<div id="navblock" class="fl">
<!--// bof:  //-->

<div style="position: relative; z-index: 200; height: 70px; float: left;" id="menu_btn">
	<span id="litbBtn" style="DISPLAY: block; Z-INDEX: 11; BACKGROUND: url(<?php echo ZROOT;?>includes/templates/lightinthebox/images/menu_arrow.gif) no-repeat; LEFT: 154px; OVERFLOW: hidden; WIDTH: 16px; CURSOR: pointer; POSITION: absolute; TOP: 18px; HEIGHT: 17px"></span>
  <div id="litbCon1" class="absolute">
  <ul id="menu_index_top">
    <li><a href="<?php echo ZROOT;?>see_all.html"><span>See All Categories</span></a></li>
  </ul>
    <ul>
      <li class="cate_title">
			<a href="<?php echo ZROOT;?>wholesale-camera-and-camcorder_c1">Camera and Camcorder</a></li>
    </ul>
  </div>
  <div id="litbCon2" class="absolute" style="display: none;">
  <ul id="menu_index_top">
    <li><a href="<?php echo ZROOT;?>see_all.html"><span>See All Categories</span></a></li>
  </ul>
  </div>
</div>
<!--// eof:  //-->
<div class="maxframe">
<!--bof-header ezpage links-->
<ul id="nav_menu">
  <li class="li1"><span><a href="<?php echo ZROOT;?>./">Home</a></span></li>
  <li class="li2"><span><a href="<?php echo ZROOT;?>wholesale.html">wholesale</a></span></li>
  <li class="li3"><span><a href="<?php echo ZROOT;?>shippinginfo.html">Dropship</a></span></li>
  <li class="li4"><span><a href="<?php echo ZROOT;?>see_all.html">See All</a></span></li>
  <li class="li5"><span><a href="<?php echo ZROOT;?>wholesale-Gifts-and-Party-Supplies_c470">Gifts</a></span></li>
  <li class="li6"><span><a href="<?php echo ZROOT;?>blog/">blog</a></span></li>
</ul>
<!--eof-header ezpage links-->
<div>
<ul class="fr" id="nav_chat">
	 <span id="nav_chat_sales">
          <p style="margin-top: 0px;">
     <a aim="" yahoo="admin1@yahoo.com" email="Admin1@admin.com" skype="skype 1" msn="admin1@hotmail.com" onClick="show_chat_div(this);" title="name1" class="red" href="javascript:void(0);"><strong>name1</strong>
     </a>
     <em> is Online to help you.</em>
     </p>   
                <p style="margin-top: 0px;">
     <a aim="" yahoo="admin2@yahoo.com" email="Admin2@admin.com" skype="skype 2" msn="admin2@hotmail.com" onClick="show_chat_div(this);" title="name2" class="red" href="javascript:void(0);"><strong>name2</strong>
     </a>
     <em> is Online to help you.</em>
     </p>  
                <p style="margin-top: 0px;">
     <a aim="" yahoo="admin3@yahoo.com" email="Admin3@admin.com" skype="skype 3" msn="admin3@hotmail.com" onClick="show_chat_div(this);" title="name3" class="red" href="javascript:void(0);"><strong>name3</strong>
     </a>
     <em> is Online to help you.</em>
     </p>   
                <p style="margin-top: 0px;">
     <a aim="" yahoo="admin4@yahoo.com" email="Admin4@admin.com" skype="LIVE_HELP_ADMIN_4_SKYPE" msn="admin4@hotmail.com" onClick="show_chat_div(this);" title="name4" class="red" href="javascript:void(0);"><strong>name2</strong>
     </a>
     <em> is Online to help you.</em>
     </p>  
      </span>
</ul>
<script>marquee(3000, 15 ,0 ,'nav_chat_sales');</script>
</div>
<!--bof-navigation display-->
<div class="search_bar fl"><form name="quick_find_header" action="<?php echo ZROOT;?>index.php?main_page=advanced_search_result" method="get" id = "quick_find_header"><input type="hidden" name="main_page" value="advanced_search_result" /><input type="hidden" name="inc_subcat" value="1" style="display: none" /><input type="hidden" name="search_in_description" value="1" /><ul id="search_con" class="use_nav_bg"><b></b><li>Search</li><li><select name="categories_id" class="select" id="light_select">
  <option value="" selected="selected">All Categories</option>
  <option value="1">Camera and Camcorder</option>
  <option value="2">Car Accessories</option>
  <option value="3">Cell Phones</option>
  <option value="21">Clothing and Apparel</option>
  <option value="22">Computers</option>
  <option value="23">Gifts and Party Supplies</option>
  <option value="28">Health and Beauty</option>
  <option value="25">Home and Garden</option>
  <option value="24">Jewelry</option>
  <option value="33">MP3 and Media Player</option>
  <option value="48">Sports Outdoor</option>
  <option value="49">Toy</option>
  <option value="50">Video Game</option>
</select>
</li><li><input type="text" name="keyword" class ="input" id="keyword" value="Enter search keywords here" onfocus="if (this.value == 'Enter search keywords here') this.value = '';" onblur="if (this.value == '') this.value = 'Enter search keywords here';" /></li><li><a class="btn_search" onclick="if($('keyword').value=='Enter search keywords here'){alert('Please submit the keyword!');}else{$('quick_find_header').submit();}return false;" href="javascript:void(0);"></a></li></ul><ul id="shoping_con"><li><a href="<?php echo ZROOT;?>index.php?main_page=shopping_cart"  rel="nofollow"><span>Your Shopping Cart</span></a></li></ul></form></div><!--eof-navigation display-->
</div>
</div>

      <?php //include (TEMPLATEPATH . '/searchform.php'); ?>
    </div><!-- /header -->

	<?php 
	$current_page = $post->ID; // Hack to prevent the no sidebar error
	include_once("sidebar-left.php"); 
	$post->ID = $current_page;
	?>
	
    <div id="left-col">
      <div id="nav">
        <ul>
          <li class="page_item <?php if ( is_home() ) { ?>current_page_item<?php } ?>"><a href="<?php echo get_settings('home'); ?>/" title="Home">Home</a></li>
		  <?php $children = wp_list_pages('sort_column=menu_order&depth=1&title_li=');?>
        </ul>
      </div><!-- /nav -->

    <?php /* Menu for subpages of current page (thanks to K2 theme for this code) */
    global $notfound;
    if (is_page() and ($notfound != '1')) {
        // Code Remove: to prevent the no sidebar error.
        while($current_page) {
            $page_query = $wpdb->get_row("SELECT ID, post_title, post_status, post_parent FROM $wpdb->posts WHERE ID = '$current_page'");
            $current_page = $page_query->post_parent;
        }
        $parent_id = $page_query->ID;
        $parent_title = $page_query->post_title;

        
				// if ($wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = '$parent_id' AND post_status != 'attachment'")) {
        if ($wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = '$parent_id' AND post_type != 'attachment'")) {
        	
    ?>

    <div id="subnav">
      <ul>
      	<?php wp_list_pages('sort_column=menu_order&depth=1&title_li=&child_of='. $parent_id); ?>
      </ul>
    </div><!-- /sub nav -->

    <?php } } ?>
	