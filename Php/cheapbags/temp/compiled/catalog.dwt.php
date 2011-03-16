<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $this->_var['page_title']; ?></title>

<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>


<div class="Area">
<?php echo $this->fetch('library/cart.lbi'); ?>
<?php echo $this->fetch('library/search_form.lbi'); ?>
<?php echo $this->fetch('library/ur_here.lbi'); ?>
<div class="goodsTitle"><?php echo $this->_var['lang']['all_category']; ?></div>
<div class="tagcontent PbulicBorder clearfix blank">
<?php $_from = $this->_var['cat_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
            <div style="white-space:nowrap; padding-left:<?php echo $this->_var['cat']['level*2']; ?>em;
              <?php if ($this->_var['cat']['has_children'] == 0): ?>float:left;padding-left: 1em;<?php else: ?>clear:both;font-weight:bold;padding-top: 10px;<?php endif; ?>">
       <a href="<?php echo $this->_var['cat']['url']; ?>" class="Triangle"><?php echo $this->_var['cat']['cat_name']; ?>(<?php echo $this->_var['cat']['goods_num']; ?>)</a></div>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
</div>

<?php echo $this->fetch('library/help.lbi'); ?>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
