<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>

<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
<script type="text/javascript" src="themes/EnTemplate/js/action.js"></script>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>

<div class="Area clearfix">
  <div class="PageLeft f_l">
  
  <?php echo $this->fetch('library/category_tree.lbi'); ?> 
  <?php echo $this->fetch('library/goods_attrlinked.lbi'); ?>
  <?php echo $this->fetch('library/history.lbi'); ?>
  <?php echo $this->fetch('library/goods_article.lbi'); ?>
  <?php echo $this->fetch('library/promotion_info.lbi'); ?>
   
 </div>
 <div class="PageRight f_r">
 	<?php echo $this->fetch('library/cart.lbi'); ?>
 <?php echo $this->fetch('library/search_form.lbi'); ?>

 <div class="GoodWid">
  <?php echo $this->fetch('library/ur_here.lbi'); ?>
 <div class="GoodTit clearfix">
 <h1 class="f_l"><?php echo $this->_var['goods']['goods_style_name']; ?></h1>
 <span class="f_r">
  <?php if ($this->_var['prev_good']): ?>
        <a href="<?php echo $this->_var['prev_good']['url']; ?>"><img alt="上一个商品" src="themes/EnTemplate/images/up.gif"  /></a>
        <?php endif; ?>
        <?php if ($this->_var['next_good']): ?>
        <a href="<?php echo $this->_var['next_good']['url']; ?>"><img alt="下一个商品" src="themes/EnTemplate/images/down.gif" /></a>
        <?php endif; ?>
 </span>
 </div>
 <div class="GoodsProperty">
  <ul class="clearfix">
   <li class="f_l" id="focuscont">
    <?php $_from = $this->_var['pictures']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'picture');$this->_foreach['pic'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pic']['total'] > 0):
    foreach ($_from AS $this->_var['picture']):
        $this->_foreach['pic']['iteration']++;
?>
    <div class="focuscont" id="focuscont<?php echo $this->_foreach['pic']['iteration']; ?>"  style="display:none">
     <p><a href="gallery.php?id=<?php echo $this->_var['id']; ?>&amp;img=<?php echo $this->_var['picture']['img_id']; ?>" target="_blank"><img src="<?php echo $this->_var['picture']['img_url']; ?>"/></a></p>
    </div>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  </li>
  <li class="f_l" id="focustab">
  <div>
    <div class="topcolor" onclick="myScroll('up');" id="aa"></div>    
       <ul class="clearfix" id="items" >
       <?php $_from = $this->_var['pictures']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'picture');$this->_foreach['pic'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pic']['total'] > 0):
    foreach ($_from AS $this->_var['picture']):
        $this->_foreach['pic']['iteration']++;
?>
      <li><a href="#go" target="_blank" name="<?php echo $this->_foreach['pic']['iteration']; ?>"><img src="<?php echo $this->_var['picture']['img_url']; ?>" /></a></li>
       <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>      
       </ul>
      <div class="bottomcolor" onclick="myScroll('dow');" id="bb"></div>
   </div>  
   
   </li>
    <li class="f_r">
   <div class="GoodsTxt">
   <ul> 
   <form action="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY" >
   <?php if ($this->_var['promotion']): ?>
   <div class="Goodpromotion">
   <font id="fontcolor"><?php echo $this->_var['lang']['activity']; ?></font><br />
   <?php $_from = $this->_var['promotion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
   <?php if ($this->_var['item']['type'] == "snatch"): ?>
   <a href="snatch.php" title="<?php echo $this->_var['lang']['snatch']; ?>">[<?php echo $this->_var['lang']['snatch']; ?>]</a>
   <?php elseif ($this->_var['item']['type'] == "group_buy"): ?>
   <a href="group_buy.php" title="<?php echo $this->_var['lang']['group_buy']; ?>">[<?php echo $this->_var['lang']['group_buy']; ?>]</a>
   <?php elseif ($this->_var['item']['type'] == "auction"): ?>
   <a href="auction.php" title="<?php echo $this->_var['lang']['auction']; ?>">[<?php echo $this->_var['lang']['auction']; ?>]</a>
   <?php elseif ($this->_var['item']['type'] == "favourable"): ?>
   <a href="activity.php" title="<?php echo $this->_var['lang']['favourable']; ?>">[<?php echo $this->_var['lang']['favourable']; ?>]</a>
   <?php endif; ?>
   <a href="<?php echo $this->_var['item']['url']; ?>" title="<?php echo $this->_var['lang'][$this->_var['item']['type']]; ?> <?php echo $this->_var['item']['act_name']; ?><?php echo $this->_var['item']['time']; ?>"><?php echo $this->_var['item']['act_name']; ?></a><br />
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   <script>setInterval("colorStyle('fontcolor','a','b')",300);</script>
   </div>
   <?php endif; ?>
   
   
   <?php if ($this->_var['cfg']['show_goodssn']): ?>
   <li>
   <span class="Acolor"><?php echo $this->_var['lang']['goods_sn']; ?></span><?php echo $this->_var['goods']['goods_sn']; ?>
   </li>
   <?php endif; ?>
   
   <?php if ($this->_var['goods']['goods_number'] != "" && $this->_var['cfg']['show_goodsnumber']): ?>   
   <?php if ($this->_var['goods']['goods_number'] == 0): ?>
   <li>
   <span class="Acolor"><?php echo $this->_var['lang']['goods_number']; ?></span><img src="themes/EnTemplate/images/wuhuo.gif" />
   </li>
   <?php else: ?>
   <li>
   <span class="Acolor"><?php echo $this->_var['lang']['goods_number']; ?></span> <?php echo $this->_var['goods']['goods_number']; ?> <?php echo $this->_var['goods']['measure_unit']; ?>
   </li>
   <?php endif; ?>
   <?php endif; ?>
   
   <?php if ($this->_var['goods']['goods_brand'] != "" && $this->_var['cfg']['show_brand']): ?>
   <li>
   <span class="Acolor"><?php echo $this->_var['lang']['goods_brand']; ?></span><a href="<?php echo $this->_var['goods']['goods_brand_url']; ?>" ><u><?php echo $this->_var['goods']['goods_brand']; ?></u></a>
   <?php endif; ?>
   </li>
   <?php if ($this->_var['cfg']['show_goodsweight']): ?>
   <li>
   <span class="Acolor"><?php echo $this->_var['lang']['goods_weight']; ?></span><?php echo $this->_var['goods']['goods_weight']; ?>
   <?php endif; ?>
   </li>
   <?php if ($this->_var['cfg']['show_addtime']): ?>
   <li>
   <span class="Acolor"><?php echo $this->_var['lang']['add_time']; ?></span><?php echo $this->_var['goods']['add_time']; ?>
   </li>
   <?php endif; ?>  
   
   
   <li>
   <span class="Acolor"><?php echo $this->_var['lang']['goods_click_count']; ?>：</span><?php echo $this->_var['goods']['click_count']; ?>
   </li>
   <li>
   <span class="Acolor"><?php echo $this->_var['lang']['goods_rank']; ?></span> <img src="themes/EnTemplate/images/stars<?php echo $this->_var['goods']['comment_rank']; ?>.gif" alt="comment rank <?php echo $this->_var['goods']['comment_rank']; ?>" />
   </li>
   
   
   
   <?php if ($this->_var['cfg']['show_marketprice']): ?>
   <li class="NoLine">
   <span class="Acolor"><?php echo $this->_var['lang']['market_price']; ?></span><span class="market"><?php echo $this->_var['goods']['market_price']; ?></span>
   </li>
   <?php endif; ?>
   <li class="NoLine">
   <span class="Acolor"><?php echo $this->_var['lang']['shop_price']; ?></span><font class="PriceTwo" id="ECS_SHOPPRICE"><?php echo $this->_var['goods']['shop_price_formated']; ?></font>
   </li>   
   <?php $_from = $this->_var['rank_prices']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'rank_price');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['rank_price']):
?>
   <li class="NoLine">
   <span class="Acolor"><?php echo $this->_var['rank_price']['rank_name']; ?>：</span><font class="PriceTwo" id="ECS_RANKPRICE_<?php echo $this->_var['key']; ?>"><?php echo $this->_var['rank_price']['price']; ?></font>
   </li>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>   
   <?php if ($this->_var['goods']['is_promote'] && $this->_var['goods']['gmt_end_time']): ?>
   <li>
   <span class="Acolor"><?php echo $this->_var['lang']['promote_price']; ?></span><font class="PriceTwo"><?php echo $this->_var['goods']['promote_price']; ?></font>
   </li>
   <?php endif; ?>

   
   <?php if ($this->_var['goods']['is_promote'] && $this->_var['goods']['gmt_end_time']): ?>
   <?php echo $this->smarty_insert_scripts(array('files'=>'lefttime.js')); ?>
   <li>
   <span class="Acolor"><?php echo $this->_var['lang']['residual_time']; ?> </span><font class="a" id="leftTime"><?php echo $this->_var['lang']['please_waiting']; ?></font>
   </li>
   <?php endif; ?>
   
   <?php if ($this->_var['goods']['give_integral'] > 0): ?>
   <li>
   <span class="Acolor"><?php echo $this->_var['lang']['goods_give_integral']; ?></span><font class="PriceTwo"><?php echo $this->_var['goods']['give_integral']; ?> <?php echo $this->_var['points_name']; ?></font>
   </li>
   <?php endif; ?>
   <?php if ($this->_var['cfg']['use_integral']): ?>
   <li>
   <span class="Acolor"><?php echo $this->_var['lang']['goods_integral']; ?></span><font class="PriceTwo"><?php echo $this->_var['goods']['integral']; ?> <?php echo $this->_var['points_name']; ?></font>
   </li>
   <?php endif; ?>
   <?php if ($this->_var['goods']['bonus_money']): ?>
   <li>
   <span class="Acolor"><?php echo $this->_var['lang']['goods_bonus']; ?></span><font class="PriceTwo"><?php echo $this->_var['goods']['bonus_money']; ?></font>
   </li>
   <?php endif; ?>
   
  <?php if ($this->_var['volume_price_list']): ?>
  <li class="NoLine clearfix blank">
   <font class="a"><?php echo $this->_var['lang']['volume_price']; ?>：</font><br />
   <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr>
    <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['number_to']; ?></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo $this->_var['lang']['Preferences_price']; ?></td>
    </tr>
    <?php $_from = $this->_var['volume_price_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('price_key', 'price_list');if (count($_from)):
    foreach ($_from AS $this->_var['price_key'] => $this->_var['price_list']):
?>
    <tr>
    <td align="center" bgcolor="#FFFFFF" class="shop"><?php echo $this->_var['price_list']['number']; ?></td>
    <td align="center" bgcolor="#FFFFFF" class="PriceTwo"><?php echo $this->_var['price_list']['format_price']; ?></td>
    </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   </table>
  </li>
   <?php endif; ?>
  
   
   
   <?php $_from = $this->_var['specification']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('spec_key', 'spec');if (count($_from)):
    foreach ($_from AS $this->_var['spec_key'] => $this->_var['spec']):
?>
   <li class="NoLine">
   <span class="Acolor"><?php echo $this->_var['spec']['name']; ?>：</span>
   
   <?php if ($this->_var['spec']['attr_type'] == 1): ?>
   <?php if ($this->_var['cfg']['goodsattr_style'] == 1): ?>
   </li>
   <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>   
   <li class="Line">
   <label for="spec_value_<?php echo $this->_var['value']['id']; ?>">
   <input type="radio" name="spec_<?php echo $this->_var['spec_key']; ?>" value="<?php echo $this->_var['value']['id']; ?>" id="spec_value_<?php echo $this->_var['value']['id']; ?>" <?php if ($this->_var['key'] == 0): ?>checked<?php endif; ?> onClick="changePrice()" />   
   <?php echo $this->_var['value']['label']; ?> [<?php if ($this->_var['value']['price'] > 0): ?><?php echo $this->_var['lang']['plus']; ?><?php elseif ($this->_var['value']['price'] < 0): ?><?php echo $this->_var['lang']['minus']; ?><?php endif; ?> <?php echo $this->_var['value']['format_price']; ?>] 
   </label>    
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   </li>
   <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" />
   <?php else: ?>
   <select name="spec_<?php echo $this->_var['spec_key']; ?>" onChange="changePrice()" class="InputBorder">
    <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
    <option label="<?php echo $this->_var['value']['label']; ?>" value="<?php echo $this->_var['value']['id']; ?>"><?php echo $this->_var['value']['label']; ?> <?php if ($this->_var['value']['price'] > 0): ?><?php echo $this->_var['lang']['plus']; ?><?php elseif ($this->_var['value']['price'] < 0): ?><?php echo $this->_var['lang']['minus']; ?><?php endif; ?><?php if ($this->_var['value']['price'] != 0): ?><?php echo $this->_var['value']['format_price']; ?><?php endif; ?></option>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>    
   </select>
   <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" />
   <?php endif; ?>
   <?php else: ?>   
   <li class="Line">
   <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
   <label for="spec_value_<?php echo $this->_var['value']['id']; ?>">
   <input type="checkbox" name="spec_<?php echo $this->_var['spec_key']; ?>" value="<?php echo $this->_var['value']['id']; ?>" id="spec_value_<?php echo $this->_var['value']['id']; ?>" onClick="changePrice()" />
   <?php echo $this->_var['value']['label']; ?> [<?php if ($this->_var['value']['price'] > 0): ?><?php echo $this->_var['lang']['plus']; ?><?php elseif ($this->_var['value']['price'] < 0): ?><?php echo $this->_var['lang']['minus']; ?><?php endif; ?> <?php echo $this->_var['value']['format_price']; ?>] <br />
   </label>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   </li>
   <input type="hidden" name="spec_list" value="<?php echo $this->_var['key']; ?>" />
   <?php endif; ?>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   
   
   <li><span class="Acolor"><?php echo $this->_var['lang']['number']; ?>：</span>
   <input name="number" type="text" id="number" value="1" size="4" onBlur="changePrice()" class="InBorder"/>
   </li>
   <li>
   <span class="Acolor"><?php echo $this->_var['lang']['amount']; ?>：</span><span id="ECS_GOODS_AMOUNT" class="PriceTwo"></span>
   </li>
   <?php if ($this->_var['goods']['is_shipping']): ?>
   <li class="Line">
    <font class="a"><?php echo $this->_var['lang']['goods_free_shipping']; ?></font>
   </li>
    <?php endif; ?> 
		<span>
    <a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)"><img src="themes/EnTemplate/images/car_gray.gif" /></a><br /><a href="javascript:collect(<?php echo $this->_var['goods']['goods_id']; ?>)"><img src="themes/EnTemplate/images/favorites.jpg" /></a>
	  <?php if ($this->_var['affiliate']['on']): ?>
   <a href="user.php?act=affiliate&goodsid=<?php echo $this->_var['goods']['goods_id']; ?>"><img src="themes/EnTemplate/images/add_to_cart.jpg" /></a>
   <?php endif; ?>
   </span>  

  </form>
  </ul>
   </div>
   </li>
   </ul>
  <script>
  initAutoFocus();
  var numLi = $("items").getElementsByTagName("li").length;
  if(numLi<5){
  $("aa").className="top";
  $("bb").className="bottom"
  }
  </script>
  </div>
    <div class="Goodsfotit clearfix" id="com_b">
     <h2><?php echo $this->_var['lang']['feed_goods_desc']; ?></h2>
    <h2 class="h2bg"><?php echo $this->_var['lang']['goods_attr']; ?></h2>
    <h2 class="h2bg"><?php echo $this->_var['lang']['goods_tag']; ?></h2>
    <?php if ($this->_var['package_goods_list']): ?>
    <h2 class="h2bg"><font id="package"><?php echo $this->_var['lang']['remark_package']; ?></font></h2>
    <script>setInterval("colorStyle('package','a','b')",300);</script>
    <?php endif; ?>
    <h2 class="h2bg"><?php echo $this->_var['lang']['accessories_releate']; ?></h2>
 </div>
  <div class="Goodscontent clearfix blank" id="com_v"></div>
  <div id="com_h">
     <blockquote>
        <?php echo $this->_var['goods']['goods_desc']; ?>
       </blockquote>
    <blockquote>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
        <?php $_from = $this->_var['properties']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'property_group');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['property_group']):
?>
        <tr>
          <th colspan="2" bgcolor="#FFFFFF"><?php echo htmlspecialchars($this->_var['key']); ?></th>
        </tr>
        <?php $_from = $this->_var['property_group']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'property');if (count($_from)):
    foreach ($_from AS $this->_var['property']):
?>
        <tr>
          <td bgcolor="#FFFFFF" align="left" width="30%" class="price">[<?php echo htmlspecialchars($this->_var['property']['name']); ?>]</td>
          <td bgcolor="#FFFFFF" align="left" width="70%"><?php echo $this->_var['property']['value']; ?></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       </table>
       </blockquote>
    <blockquote>
        <?php echo $this->fetch('library/goods_tags.lbi'); ?>
       </blockquote>
    <?php if ($this->_var['package_goods_list']): ?>
        <blockquote>
        <?php $_from = $this->_var['package_goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'package_goods');if (count($_from)):
    foreach ($_from AS $this->_var['package_goods']):
?>
        <strong><?php echo $this->_var['package_goods']['act_name']; ?></strong><br />
        <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dcdcdc">
        <tr>
          <td bgcolor="#fafafa">
          <?php $_from = $this->_var['package_goods']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_list');if (count($_from)):
    foreach ($_from AS $this->_var['goods_list']):
?>
          <a href="goods.php?id=<?php echo $this->_var['goods_list']['goods_id']; ?>" target="_blank"><?php echo $this->_var['goods_list']['goods_name']; ?></a> &nbsp;&nbsp;X <?php echo $this->_var['goods_list']['goods_number']; ?><br />
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </td>
          <td bgcolor="#fafafa">
          <?php echo $this->_var['lang']['old_price']; ?><font class="market"><?php echo $this->_var['package_goods']['subtotal']; ?></font><br />
          <?php echo $this->_var['lang']['package_price']; ?><font class="price"><?php echo $this->_var['package_goods']['package_price']; ?></font><br />
          <?php echo $this->_var['lang']['then_old_price']; ?><font class="price"><?php echo $this->_var['package_goods']['saving']; ?></font><br />
          </td>
          <td bgcolor="#fafafa" align="center">
          <a href="javascript:addPackageToCart(<?php echo $this->_var['package_goods']['act_id']; ?>)"><?php echo $this->_var['lang']['button_buy']; ?></a>
          </td>
        </tr>
        </table>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </blockquote>
       <?php endif; ?>
     <blockquote>
        <?php echo $this->fetch('library/goods_fittings.lbi'); ?>
       </blockquote>
   </div>
  <script type="text/javascript">reg("com");</script>
  
	<?php echo $this->fetch('library/goods_related.lbi'); ?>
	<?php echo $this->fetch('library/bought_goods.lbi'); ?>
	<?php echo $this->fetch('library/bought_note_guide.lbi'); ?>
  <?php echo $this->fetch('library/comments.lbi'); ?>
  
 </div>
 </div>
</div>

<?php echo $this->fetch('library/help.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
<script type="text/javascript">
var goods_id = <?php echo $this->_var['goods_id']; ?>;
var goodsattr_style = <?php echo empty($this->_var['cfg']['goodsattr_style']) ? '1' : $this->_var['cfg']['goodsattr_style']; ?>;
var gmt_end_time = <?php echo empty($this->_var['promote_end_time']) ? '0' : $this->_var['promote_end_time']; ?>;
<?php $_from = $this->_var['lang']['goods_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var goodsId = <?php echo $this->_var['goods_id']; ?>;
var now_time = <?php echo $this->_var['now_time']; ?>;


onload = function(){
  changePrice();
  fixpng();
  try {onload_leftTime();}
  catch (e) {}
}

/**
 * 点选可选属性或改变数量时修改商品价格的函数
 */
function changePrice()
{
  var attr = getSelectedAttributes(document.forms['ECS_FORMBUY']);
  var qty = document.forms['ECS_FORMBUY'].elements['number'].value;

  Ajax.call('goods.php', 'act=price&id=' + goodsId + '&attr=' + attr + '&number=' + qty, changePriceResponse, 'GET', 'JSON');
}

/**
 * 接收返回的信息
 */
function changePriceResponse(res)
{
  if (res.err_msg.length > 0)
  {
    alert(res.err_msg);
  }
  else
  {
    document.forms['ECS_FORMBUY'].elements['number'].value = res.qty;

    if (document.getElementById('ECS_GOODS_AMOUNT'))
      document.getElementById('ECS_GOODS_AMOUNT').innerHTML = res.result;
  }
}

</script>
</html>
