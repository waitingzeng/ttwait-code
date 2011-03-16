<?php if ($this->_var['hot_goods']): ?>
   <?php $_from = $this->_var['hot_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_06620300_1300165487');if (count($_from)):
    foreach ($_from AS $this->_var['goods_0_06620300_1300165487']):
?>
   <div class="goodsbox">
    <div class="imgbox"><a href="<?php echo $this->_var['goods_0_06620300_1300165487']['url']; ?>"><img src="<?php echo $this->_var['goods_0_06620300_1300165487']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods_0_06620300_1300165487']['name']); ?>" /></a></div>
		<p>
    <a href="<?php echo $this->_var['goods_0_06620300_1300165487']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods_0_06620300_1300165487']['name']); ?>"><?php echo $this->_var['goods_0_06620300_1300165487']['short_style_name']; ?></a><br />
    <?php if ($this->_var['goods_0_06620300_1300165487']['promote_price'] != ""): ?>
    <?php echo $this->_var['lang']['promote_price']; ?><span class="price"><?php echo $this->_var['goods_0_06620300_1300165487']['promote_price']; ?></span>
    <?php else: ?>
   <?php echo $this->_var['lang']['shop_price']; ?><span class="price"><?php echo $this->_var['goods_0_06620300_1300165487']['shop_price']; ?></span>
    <?php endif; ?> 
		</p>  
   </div>	
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <p class="tr"><a href="search.php?intro=hot" ><img src="themes/EnTemplate/images/more.gif" ></a></p>
<?php endif; ?>
