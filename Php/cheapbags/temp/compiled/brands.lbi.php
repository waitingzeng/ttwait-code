<?php if ($this->_var['brand_list']): ?>
<div class="Mod3 blank">
  <h2 class="Brands"><?php echo $this->_var['lang']['goods_brand']; ?></h2>
	 <div class="brands ContantBlank">
   <?php $_from = $this->_var['brand_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand');$this->_foreach['brand_foreach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['brand_foreach']['total'] > 0):
    foreach ($_from AS $this->_var['brand']):
        $this->_foreach['brand_foreach']['iteration']++;
?>
    <?php if (($this->_foreach['brand_foreach']['iteration'] - 1) <= 6): ?>
      <?php if ($this->_var['brand']['brand_logo']): ?>
   <a href="<?php echo $this->_var['brand']['url']; ?>"><img src="data/brandlogo/<?php echo $this->_var['brand']['brand_logo']; ?>" alt="<?php echo htmlspecialchars($this->_var['brand']['brand_name']); ?> (<?php echo $this->_var['brand']['goods_num']; ?>)" /></a>
      <?php else: ?>
        <a href="<?php echo $this->_var['brand']['url']; ?>" class="brandtxt"><?php echo htmlspecialchars($this->_var['brand']['brand_name']); ?> <?php if ($this->_var['brand']['goods_num']): ?>(<?php echo $this->_var['brand']['goods_num']; ?>)<?php endif; ?></a>
      <?php endif; ?>
    <?php endif; ?>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  <p class="tr"><a href="brand.php" class="brandMore">All brand</a></p>
	 </div>
	 </div>
<?php endif; ?>