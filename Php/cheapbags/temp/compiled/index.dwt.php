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
<link rel="alternate" type="application/rss+xml" title="RSS|<?php echo $this->_var['page_title']; ?>" href="<?php echo $this->_var['feed_url']; ?>" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,index.js')); ?>
<script type="text/javascript" src="themes/EnTemplate/js/action.js"></script>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="Area clearfix">
 <div class="PageLeft f_l">
  
<?php echo $this->fetch('library/category_tree.lbi'); ?>
<?php echo $this->fetch('library/new_articles.lbi'); ?>
<?php echo $this->fetch('library/top10.lbi'); ?>
<?php echo $this->fetch('library/order_query.lbi'); ?>
<?php echo $this->fetch('library/invoice_query.lbi'); ?>
<?php echo $this->fetch('library/email_list.lbi'); ?>

 </div>
  <div class="PageRight f_l">   
	<?php echo $this->fetch('library/cart.lbi'); ?>
	<?php echo $this->fetch('library/search_form.lbi'); ?>
	<div class="PageMiddle f_l">	
	<?php echo $this->fetch('library/index_ad.lbi'); ?>
	<?php echo $this->fetch('library/recommend_promotion.lbi'); ?>
	<div class="PbulicBorder blank">
	<div class="infotit clearfix" id="com_b">
    <h2><span class="new"></span><?php echo $this->_var['lang']['new_goods']; ?></h2>
    <h2 class="h2bg"><span class="hot"></span><?php echo $this->_var['lang']['hot_goods']; ?></h2>
    <h2 class="h2bg"><span class="best"></span><?php echo $this->_var['lang']['best_goods']; ?></h2>
 </div>
 <div class="tagcontent" id="com_v"></div>
 <div id="com_h">
    <blockquote>
    <?php echo $this->fetch('library/recommend_new.lbi'); ?>
    </blockquote>
    <blockquote>
    <?php echo $this->fetch('library/recommend_hot.lbi'); ?>
    </blockquote>
    <blockquote>
    <?php echo $this->fetch('library/recommend_best.lbi'); ?>
    </blockquote>   
   </div>
	 </div>
  <script type="text/javascript">reg("com");</script>
	
<?php echo $this->fetch('library/group_buy.lbi'); ?>
<?php echo $this->fetch('library/auction.lbi'); ?>

	</div>
	<div class="AreaRight f_r">	 
		
<?php echo $this->fetch('library/brands.lbi'); ?>

	</div>
  </div> 
</div> 
<?php echo $this->fetch('library/help.lbi'); ?>
<?php if ($this->_var['img_links'] || $this->_var['txt_links']): ?>
<div class="Area blank">
<div class="Mod3">
<h2>Link</h2>
<div class="ContantBlank links clearfix">
 <?php $_from = $this->_var['img_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
   <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><img src="<?php echo $this->_var['link']['logo']; ?>" alt="<?php echo $this->_var['link']['name']; ?>" /></a>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   <?php if ($this->_var['txt_links']): ?>
   <?php $_from = $this->_var['txt_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
   <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>" class="linkTxt"><?php echo $this->_var['link']['name']; ?></a>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   <?php endif; ?>
</div>
</div> 
</div> 
<?php endif; ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
