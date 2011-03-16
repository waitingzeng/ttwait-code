<?php if ($this->_var['new_articles']): ?>
<div class="Mod3 blank">
 <h2 class="new"><?php echo $this->_var['lang']['new_article']; ?></h2> 
 <div class="ContantBlank">
  <?php $_from = $this->_var['new_articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['new_articles'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['new_articles']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['new_articles']['iteration']++;
?>
  <?php if (($this->_foreach['new_articles']['iteration'] - 1) < 5): ?>
  <a href="<?php echo $this->_var['article']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['article']['title']); ?>" class="Triangle"><?php echo $this->_var['article']['short_title']; ?></a><br />
  <?php endif; ?> 
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </div>
</div>
<?php endif; ?>