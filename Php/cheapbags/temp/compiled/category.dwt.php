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
<?php if ($this->_var['cat_style']): ?>
<link href="<?php echo $this->_var['cat_style']; ?>" rel="stylesheet" type="text/css" />
<?php endif; ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,global.js,compare.js')); ?>
<script type="text/javascript" src="themes/EnTemplate/js/action.js"></script>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<div class="Area clearfix">
  <div class="PageLeft f_l">
  
  <?php echo $this->fetch('library/category_tree.lbi'); ?> 
  <?php echo $this->fetch('library/top10.lbi'); ?>
  <?php echo $this->fetch('library/history.lbi'); ?>
  <?php echo $this->fetch('library/promotion_info.lbi'); ?>
  <?php echo $this->fetch('library/vote_list.lbi'); ?>
   
 </div>
 <div class="PageRight f_r">
 <?php echo $this->fetch('library/cart.lbi'); ?>
	<?php echo $this->fetch('library/search_form.lbi'); ?>
<div class="GoodWid">
 <?php echo $this->fetch('library/ur_here.lbi'); ?>
 <?php if ($this->_var['brands']['1'] || $this->_var['price_grade']['1'] || $this->_var['filter_attr_list']): ?>
 <div class="Mod3 blank">
 <h2 class="mod1tit"><?php echo $this->_var['lang']['goods_filter']; ?></h2>
 <div class="mod1con">
    <?php if ($this->_var['brands']['1']): ?>
   <div class="screeBox">
     <strong><?php echo $this->_var['lang']['brand']; ?>：</strong>
    <?php $_from = $this->_var['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand');if (count($_from)):
    foreach ($_from AS $this->_var['brand']):
?>
     <?php if ($this->_var['brand']['selected']): ?>
     <p><?php echo $this->_var['brand']['brand_name']; ?></p>
     <?php else: ?>
     <a href="<?php echo $this->_var['brand']['url']; ?>"><?php echo $this->_var['brand']['brand_name']; ?></a>&nbsp;
     <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   </div>
   <?php endif; ?>
   <?php if ($this->_var['price_grade']['1']): ?>
   <div class="screeBox">
   <strong><?php echo $this->_var['lang']['price']; ?>：</strong>
   <?php $_from = $this->_var['price_grade']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'grade');if (count($_from)):
    foreach ($_from AS $this->_var['grade']):
?>
    <?php if ($this->_var['grade']['selected']): ?>
    <p><?php echo $this->_var['grade']['price_range']; ?></p>
    <?php else: ?>
    <a href="<?php echo $this->_var['grade']['url']; ?>"><?php echo $this->_var['grade']['price_range']; ?></a>&nbsp;
    <?php endif; ?>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   </div>
   <?php endif; ?>
   <?php $_from = $this->_var['filter_attr_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'filter_attr_0_97614000_1300165499');if (count($_from)):
    foreach ($_from AS $this->_var['filter_attr_0_97614000_1300165499']):
?>
      <div class="screeBox">
   <strong><?php echo htmlspecialchars($this->_var['filter_attr_0_97614000_1300165499']['filter_attr_name']); ?>：</strong>
   <?php $_from = $this->_var['filter_attr_0_97614000_1300165499']['attr_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'attr');if (count($_from)):
    foreach ($_from AS $this->_var['attr']):
?>
    <?php if ($this->_var['attr']['selected']): ?>
    <p><?php echo $this->_var['attr']['attr_value']; ?></p>
    <?php else: ?>
    <a href="<?php echo $this->_var['attr']['url']; ?>"><?php echo $this->_var['attr']['attr_value']; ?></a>&nbsp;
    <?php endif; ?>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   </div>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  </div>
 </div>

 <?php endif; ?> 
   
 <?php echo $this->fetch('library/goods_list.lbi'); ?>
 <?php echo $this->fetch('library/pages.lbi'); ?>
   
</div>
 </div>
</div>

<?php echo $this->fetch('library/help.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
