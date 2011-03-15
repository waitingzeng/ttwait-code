<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=product_info.<br />
 * Displays details of a typical product
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_product_info_display.php 5369 2006-12-23 10:55:52Z drbyte $
 */
 require(DIR_WS_MODULES . '/debug_blocks/product_info_prices.php');
?>
<?php
// only display when more than 1
  if ($products_found_count > 1) {
?>

<div class="fr"><a href="<?php echo zen_href_link(FILENAME_DEFAULT, 'cPath='. zen_get_products_category_id($_GET['products_id']));?>" / class="b_" title="<?php echo zen_get_category_name(zen_get_products_category_id($_GET['products_id']),$_SESSION['languages_id']);?>">other item in the list</a>&nbsp;<span id="recent_flash_smallPage" class="product_title">
  <?php //echo (PREV_NEXT_PRODUCT); ?>
  <?php //echo ($position+1 . "/" . $counter); ?>
  </span></div>
<?php
  }
?>
<?php if ($messageStack->size('product_info') > 0) echo $messageStack->output('product_info'); ?>
<!--bof Prev/Next top position -->
<?php if (PRODUCT_INFO_PREVIOUS_NEXT == 1 or PRODUCT_INFO_PREVIOUS_NEXT == 3) { ?>
<?php
/**
 * display the product previous/next helper
 */
require($template->get_template_dir('tpl_product_flash_page.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_product_flash_page.php'); ?>
<?php } ?>
<!--eof Prev/Next top position-->
<br class="clear" />
<div class="margin_t allborder fl" style="padding: 2px 0px; width:950px;">
  <div class="fl for_gray_bg" style="width:950px;">
    <!--bof Main Product Image -->
    <?php
  if (zen_not_null($products_image)) {
  ?>
    <?php
/**
 * display the main product image
 */
   require($template->get_template_dir('tpl_modules_main_product_image.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_main_product_image.php'); ?>
    <?php
  }
?>
    <!--eof Main Product Image-->
    <div id="product_info_con" class="fr">
          <!--bof Form start-->
      <?php echo zen_draw_form('cart_quantity_frm', zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params(array('action')) . 'action=add_product'), 'post', 'enctype="multipart/form-data"') . "\n"; ?>
      <!--eof Form start-->
      <?php echo zen_draw_hidden_field('products_id',$_GET['products_id']); ?>
      <div class="fl pad_product line_180">
        <!--bof Product Name-->
        <h1 style="font-size: 16px;"><?php echo $products_name; ?></h1>
        <!--eof Product Name-->
        <ul class="pad_10px">
          <li>item#:&nbsp;<?php echo $products_model; ?></li>
          <div class="hr_d"></div>
        <!--bof Product Price block -->
        <li class="big margin_t"> Retail price: <del>
          <?php
						// base price
						  if ($show_onetime_charges_description == 'true') {
						    $one_time = '<span >' . TEXT_ONETIME_CHARGE_SYMBOL . TEXT_ONETIME_CHARGE_DESCRIPTION . '</span><br />';
						  } else {
						    $one_time = '';
						  }
						  echo $one_time . ((zen_has_product_attributes_values((int)$_GET['products_id']) and $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : '') . $currencies->display_price(zen_get_products_retail_price((int)$_GET['products_id']),zen_get_tax_rate($product_info->fields['products_tax_class_id']));
						?>
          </del> </li>
        <h3 class="relative">Wholesale Price:<div id="t_p"><ul><li><a class="one u b_" href="javascript:void(0)"><?php echo $currencies->display_symbol_left($_SESSION['currency']);?><!--[if IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]><table><tr><td><![endif]--><div>
				<?php
					reset($currencies->currencies);
				 while (list($key, $value) = each($currencies->currencies)) { 
					if($key != $_SESSION['currency']){	?>
        	<a class="b_ big_" href="<?php echo $_SERVER['REQUEST_URI'];?>?currency=<?php echo $key; ?>"><?php echo $value['symbol_left']; ?></a>
				<?php }} ?>
        <!--[if lte IE 6.5]><IFRAME src="javascript:void(0)"></IFRAME><![endif]--></div><!--[if lte IE 6]></td></tr></table></a><![endif]--></li></ul></div>
          <span id="products_price_unit" class="red" style="padding-left:50px;"><?php echo number_format((zen_get_products_base_price((int)$_GET['products_id']) == 0 ? zen_get_products_sample_price((int)$_GET['products_id']) : zen_get_products_base_price((int)$_GET['products_id'])), 2, '.', '');?></span></h3>
        <!--eof Product Price block -->
        <li class="big">Start from: <?php echo $products_quantity_order_min;?> Unit(s)</li>      
        <!--bof free ship icon  -->
        <?php if(zen_get_product_is_always_free_shipping((int)$_GET['products_id'])) { ?>
             <li>This item is: <img border="0" class="g_t_m" src="includes/templates/<?php echo $template_dir; ?>/images/free.gif"/></li>
        <?php }else{
            echo zen_get_freeshipping_same_products($products_name);
        }
        	?>
        <!--eof free ship icon  -->
        
        </ul>
        
        <!--bof Quantity Discounts table -->
				<?php
				  if ($products_discount_type != 0 || $categories_discount_type != 0) { ?>
				<?php
				/**
				 * display the products quantity discount
				 */
				 require($template->get_template_dir('tpl_modules_products_quantity_discounts.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_products_quantity_discounts.php'); ?>
				<?php
				  }
				?>
				<!--eof Quantity Discounts table -->
        <!--bof Attributes Module -->
				<?php
          if ($pr_attr->fields['total'] > 0) {
        ?>
        <?php
        /**
         * display the product atributes
         */
          require($template->get_template_dir('/tpl_modules_attributes.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_attributes.php'); ?>
        <?php
          }
        ?>
        <!--eof Attributes Module -->
        
      </div>
      <div class="minframe fr pad_top">
        <ul class="white_bg allborder pad_10px" id="product_price">
          <li><span id="products_price_all" class="red b big"><?php echo zen_get_products_display_final_price((int)$_GET['products_id']);?></span>&nbsp;<span id="shipping_rule">+ 
          Shipping Cost </span></li>
          </ul>
        <a name="show"></a>
        <ul class="g_t_c product_ul_h">
          <?php if ($products_quantity > 0){ ?>
          <strong>Quantity: </strong>
          <input type="text" name="cart_quantity" id="cart_quantity" value="<?php echo $products_quantity_order_min;?>" maxlength="6" style="width:30px"  onkeyup="value=value.replace(/[^\d]/g,'');changePrice();" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''));changePrice();"/> <strong>Unit(s)</strong>
          <?php }else{ ?>
          <img border="0" src="includes/templates/<?php echo $template_dir; ?>/images/soldout.gif"/><br/>
          <?php } ?>
        </ul>
        <?php if ($products_quantity > 0){ ?>
        <ul id="selectArea" class="g_t_c product_ul_h relative"></ul>
        <ul class="g_t_c gray" id="tmp_tit"></ul>
		<script type="text/javascript">
				function validateS(){
						this.ini = init;
						this.checking = checkS;
						this.outArr = new Array();
						this.inArr = new Array();
						this.errStr = '';
						this.buttonSrc=new Image();
						this.buttonSrc.src="includes/templates/<?php echo $template_dir; ?>/images/car_gray.gif";
					}
					var tempPrice = new Array();
					function init(){
						var formsEl = document.forms['cart_quantity_frm'].elements;
						for(i=0;i<formsEl.length;i++){
							if(formsEl[i].id.substr(0,7) == 'attrib-'){
								if(!(formsEl[i].tagName == "SELECT"&&formsEl[i].length==1)){formsEl[i].value = "";}
								if(formsEl[i].tagName == "SELECT"){
									formsEl[i].onchange = function(){
										if(tempPrice[this.id])
											extraPrice -= tempPrice[this.id];
										var t = this.selectedIndex;
										extraPrice += Number(stripPrice(this.options[t].getAttribute('price')));
										tempPrice[this.id] = Number(stripPrice(this.options[t].getAttribute('price')));
										checkS();
									}
								}
								var tmparr = [formsEl[i],formsEl[i].getAttribute('options_name').replace(':','')];
								this.outArr.push(tmparr);
							}
						}
						if(this.outArr.length>0)
							$('tmp_tit').innerHTML = 'To add to shopping cart,<br />choose from options to the left.';
					}
				
				
					function checkS() {
						var err = '';
						var _img='<img class="mar_r5" src="includes/templates/<?php echo $template_dir; ?>/images/add-to-cart.gif"/>';
				
						for(i=0;i<vs.outArr.length;i++){
							if(vs.outArr[i][0].tagName == "SELECT"){
								if(vs.outArr[i][0].disabled == false && vs.outArr[i][0].value.replace(/\s/g,'')=="")
									err += _img+"<nobr>" + vs.outArr[i][1] + '</nobr>,';
							}
						}
						changePrice();
						vs.errStr = err;
						formatOutput();
					}
				
					function showTit(obj,key){
						(key==0)?$(obj).style.display = '':$(obj).style.display = 'none';
					}
					function formatOutput(){
						var tt = vs.errStr.substr(0,vs.errStr.length-1),_str="";
						tt = tt.replace(/,/g,' <br/> ');
						if(vs.errStr!=''){
							_str = '<img src="includes/templates/<?php echo $template_dir; ?>/images/car_gray.gif" onmouseout="showTit(\'tit_t\',1)" onmouseover="showTit(\'tit_t\',0)">'+'<div onmouseout="showTit(\'tit_t\',1)" onmouseover="showTit(\'tit_t\',0)" id="tit_t" style="display:none"><b></b><div style="padding:0 10px 10px 10px;"><div class="mar_5">Please Select</div><div class="bt1"></div>'+tt+'</div><b></b></div>';
						}else{
							_str = '<input type="image" class="none" src="includes/templates/<?php echo $template_dir; ?>/images/car.gif" alt="Add to Cart" title="Add to Cart" />';
						}
						$('selectArea').innerHTML = _str;
						jQuery('#tit_t').css({top:40-jQuery('#tit_t').height()});
				
					}
					var vs = new validateS();
					vs.ini();
					vs.checking();
				  </script>
          <?php } ?>
        <div class="seal_m_en center"></div>
        <ul class="g_t_c">
          <li style="margin-top: 3px;"><a class="u blue"  title="Shipping &amp; Delivery" onclick="floatBox(this,'shipping_info');" href="<?php echo $_SERVER['REQUEST_URI'];?>#show">Shipping &amp; Delivery</a></li>
          <li style="margin-top: 3px;"><a class="u blue"  title="Payment methods" onclick="floatBox(this,'payment_option');" href="<?php echo $_SERVER['REQUEST_URI'];?>#show">Payment methods</a></li>
          <li style="margin-top: 3px;"><a class="u blue"  title="Calculate shipping costs" onclick="floatBox(this,'costs');" href="<?php echo $_SERVER['REQUEST_URI'];?>#show">Calculate shipping costs</a></li>
          <li style="margin-top: 3px;"><a class="u blue"  title="Ask questions about this product" onclick="javascript:popupWindow(\'' . zen_href_link(FILENAME_POPUP_ASK_A_QUESTION, 'products_id='.$_GET['products_id']) . '\')" href="<?php echo $_SERVER['REQUEST_URI'];?>#show">Ask questions about this product</a></li>
        </ul>
      </div>
      </form>
      <script>changePrice();</script>
      <!-- EOF ProductShipping Cart-->
    </div>
<!-- EOF Product Tools-->    </div> 
</div>
<br class="clear" />
<div class="margin_t fl maxwidth">
<div id="product_main_con" class="fl black">
<div>
  <!--bof Product description -->
  <?php if ($products_description != '') { ?>
    <div><h2 class="blue">Description: </h2></div>
    <div id="Item_Description_Spc" class="pad_10px pad_l_28px big"><?php echo stripslashes($products_description); ?></div>
  <?php } ?>
  <!--eof Product description -->

</div>


<br class="clear" />


<!--bof Additional Product Images -->
<?php
/**
 * display the products additional images
 */
  require($template->get_template_dir('/tpl_modules_additional_images.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_additional_images.php'); ?>
<!--eof Additional Product Images -->


<!--bof Prev/Next bottom position -->
<?php if (PRODUCT_INFO_PREVIOUS_NEXT == 2 or PRODUCT_INFO_PREVIOUS_NEXT == 3) { ?>
<?php
/**
 * display the product previous/next helper
 */
	
 require($template->get_template_dir('/tpl_products_next_previous.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_products_next_previous.php'); ?>
<?php } ?>
<!--eof Prev/Next bottom position -->

<div class="g_t_r pad_bottom">
<a target="_blank" title="Print Page" href="<?php echo '../../loveweshop/templates/print_page_p'.$_GET['products_id'];?>">Print Page</a>
</div>

<div id="p_review">
<div class="hr_d"></div>
<!-- BOF Product Reviews -->
<?php
  if ($flag_show_product_info_reviews == 1) {
    // if more than 0 reviews, then show reviews content; otherwise, don't show 
    if ($reviews->RecordCount() > 0 ) { ?>

<h2 class="margin_t blue fl">Product Reviews:  <a href="<?php echo zen_href_link(zen_get_info_page($_GET['products_id']),'products_id=' . $_GET['products_id']).'#review' ?>"><?php echo zen_image($template->get_template_dir('btn_review.gif', DIR_WS_TEMPLATE, $current_page_base,'images/button'). '/btn_review.gif','','','',' class="g_t_m"'); ?></a></h2>
<div class="clear"></div>
<div class="pad_10px pad_l_28px big">
<!--bof Reviews button and count-->

	    <?php while (!$reviews->EOF){	      
	    				$customer_name = substr($reviews->fields['customers_name'],strpos($reviews->fields['customers_name'],' '));
	    				if(!isset($customer_name)){
	    					$customer_name = $reviews->fields['reviews_id'];
	    				}
	    	?>
				<ul class="border_b margin_t pad_bottom">
				<?php for( $i = 0;$i < $reviews->fields['reviews_rating'];$i++){?>
							<span class="star"></span>
				<?php } ?>
				<?php if ( $reviews->fields['reviews_rating']<5){
								for( $i = 0;$i < 5-$reviews->fields['reviews_rating'];$i++){
									echo '<span class="star_gray"></span>';
								}		
							}?>
				&nbsp;<strong><?php echo $reviews->fields['reviews_title']; ?></strong>, <?php echo zen_date_short($reviews->fields['date_added']);?>  <?php if($reviews->fields['reviews_is_featured']){echo '<span style="font-size: 10px;"> ( <a href="'.zen_href_link(FILENAME_TESTIMONIALS).'" class="u">'.TEXT_PRODUCT_FEATURED_REVIEW.'</a> ) </span>';} ?><br/><?php echo $customer_name; ?><div style="" class="gray big"><?php echo $reviews->fields['reviews_text'] ?></div>
				</ul>
			<?php $reviews->MoveNext();
					} ?>
      </div>
    <?php } else {
    		//no display addBy showq@qq.com
    	}?>

<?php } ?>

<!--eof Reviews button and count -->
<a name="review"></a><h2 class="margin_t blue">Write a Review:</h2>
	<div class="pad_bottom pad_l_28px big">
	<p>Tell us what you think about this item, share your opinion with other people. Please make sure that your review focus on this item. All the reviews are moderated and will be reviewed within two business days. Inappropriate reviews will not be posted. </p>
	<p>Have any question or inquire for this item? Please contact <a target="_blank" class="red u" href="<?php echo zen_href_link(FILENAME_FAQS_ALL); ?>">Customer Service</a>. (Our customer representative will get back shortly.)</p>
	<ul class="inquiry">	
	<form onsubmit="return(fmChk(this))" method="post" action="<?php echo zen_href_link(zen_get_info_page($_GET['products_id']),'products_id=' . $_GET['products_id']).'#review' ?>" name="post_review" id="post_review">
	<input type="hidden" value="4" id="product_score" name="product_score"/>
	<input type="hidden" value="review" id="action" name="action"/>
	<input type="hidden" value="" id="session_key" name="session_key"/>
	<table width="360" border="0" class="big">
	  <tbody><tr><td colspan="2">
	  <?php if ($messageStack->size('reviews') > 0) echo $messageStack->output('reviews'); ?>
	  <td></tr>
	  <tr><td colspan="2">Indicates required fields<span class="red">*</span></td></tr>
	  <tr><td colspan="2">
		  <table><tbody><tr>
		  <td class="big">Rating: </td>
		  <td>
		  <div onmousedown="rating.startSlide()" onmousemove="rating.doSlide(event)" onmouseout="rating.resetHover()" onclick="rating.setRating(event)" onmouseup="rating.stopSlide()" id="r_RatingBar" style="background: transparent url(../../loveweshop/templates/includes/templates/loveweshop/images/icon/unfilled.gif) repeat scroll 0%; width: 75px; cursor: pointer; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;">
			<div style="background: transparent url(../../loveweshop/templates/includes/templates/loveweshop/images/icon/hover.gif) repeat-x scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; height: 14px; width: 0px;" id="r_Hover">
			<div id="r_Filled" style="background: transparent url(../../loveweshop/templates/includes/templates/loveweshop/images/icon/sparkle.gif) repeat-x scroll 0%; overflow: hidden; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; height: 14px; width: 60px;"></div>
			</div>
		</div>
		</td>
		<td><div id="score_title"></div></td>
		</tr></tbody></table>
		<script type="text/javascript">
		var rbi = new BvRatingBar('r_');
		window.rating = rbi;
		</script>
		</td></tr>
	  <tr>
		<td width="110" valign="top">Your Name: <span class="red">*</span></td>
		<td width="250" valign="top">
    <input type="text" chkrule="nnull" chkname="Your Name" class="input_5" value="<?php echo isset($_SESSION['customer_id'])? zen_get_customer_name($_SESSION['customer_id']): '';  ?>" name="customer_name"/>		<div class="big_">Enter your Reviewer Nickname </div></td>
	  </tr>
	     		<?if(isset($_SESSION['customer_id'])){
	     		  //nothing
	     		}else{
	     			?><tr>
						<td width="110" valign="top">Your Email: <span class="red">*</span></td>
						<td width="250" valign="top">
							<input type="text" chkrule="nnull/eml" chkname="Email" class="input_5" value="" name="customer_email"/>		</td>
					  </tr>
					  <?php } ?>
	  	  <tr>
		<td valign="top">Review Title: <span class="red">*</span></td>
		<td valign="top">
<input type="text" chkrule="nnull/max50" chkname="Review Title" class="input_5" value="" name="review_title"/></td>
	  </tr>
	

	  <tr>
		<td colspan="2">
<textarea chkrule="nnull/max10000" chkname="review" class="textarea1 txt_review" name="review_content" id="txt_review" onblur="if(this.value == '') this.className='textarea1 txt_review'" onfocus="this.className='textarea1'"></textarea>
</td>
	  </tr>
	  <tr>
		<td height="50" align="right" colspan="2"><button id="submint1_review" type="submit"><span id="submint2_review">Submit</span></button></td>
	  </tr>
	</tbody></table>
	</form>
	</ul>
</div>
<!-- EOF Product Reviews -->
</div>
<!-- BOF Related_categories Search_feedback -->
<?php
	require(DIR_WS_MODULES . zen_get_module_directory('sideboxes/'.$template_dir.'/related_categories.php'));
	require(DIR_WS_MODULES . zen_get_module_directory('sideboxes/'.$template_dir.'/search_feedback.php'));
?>
<!-- EOF Relate_categories Search_feedback -->
</div>
  <div class="mini_frame fr">
    <?php require(DIR_WS_MODULES . zen_get_module_directory('sideboxes/'.$template_dir.'/recently_sold.php')); ?>
    <?php require($template->get_template_dir('tpl_modules_also_purchased_products.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_also_purchased_products.php');?>
  	<?php require(DIR_WS_MODULES . zen_get_module_directory('sideboxes/'.$template_dir.'/subscribe.php')); ?>
  </div>
</div>

<!--bof Form close-->
</form>
<!--bof Form close-->
<br class="clear"/>
