<?php if ($this->_var['new_goods']): ?>
   <?php $_from = $this->_var['new_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
   <div class="goodsbox">
    <div class="imgbox"><a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" /></a></div>
		<p>
    <a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo $this->_var['goods']['short_style_name']; ?></a><br />
    <?php if ($this->_var['goods']['promote_price'] != ""): ?>		
    
   <?php echo $this->_var['lang']['promote_price']; ?><span class="price"><?php echo $this->_var['goods']['promote_price']; ?></span>
    <?php else: ?>     
<?php echo $this->_var['lang']['shop_price']; ?><span class="price"><?php echo $this->_var['goods']['shop_price']; ?></span>		 
    <?php endif; ?>
		</p>
   </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <p class="tr"><a href="search.php?intro=new"><img src="themes/EnTemplate/images/more.gif" ></a></p>
<?php endif; ?>