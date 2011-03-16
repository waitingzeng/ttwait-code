<?php if ($this->_var['goods_article_list']): ?>
<div class="Mod3 blank" id="articlesList">
<h2><?php echo $this->_var['lang']['article_releate']; ?></h2>
 <div class="PublicBlank">
 <?php $_from = $this->_var['goods_article_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
   <a href="<?php echo $this->_var['article']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['article']['title']); ?>" class="Triangle"><?php echo sub_str($this->_var['article']['short_title'],15); ?></a><br />
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </div> 
</div>

<?php endif; ?>