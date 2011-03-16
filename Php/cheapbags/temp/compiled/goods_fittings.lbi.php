<?php if ($this->_var['fittings']): ?>
<?php $_from = $this->_var['fittings']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_68177400_1300168280');if (count($_from)):
    foreach ($_from AS $this->_var['goods_0_68177400_1300168280']):
?>
  <div class="goodsbox">
  <div class="imgbox"><a href="<?php echo $this->_var['goods_0_68177400_1300168280']['url']; ?>"><img src="<?php echo $this->_var['goods_0_68177400_1300168280']['goods_thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods_0_68177400_1300168280']['name']); ?>" /></a></div>
   <a href="<?php echo $this->_var['goods_0_68177400_1300168280']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['goods_0_68177400_1300168280']['goods_name']); ?>"><?php echo htmlspecialchars($this->_var['goods_0_68177400_1300168280']['short_name']); ?></a><br />
   <?php echo $this->_var['lang']['fittings_price']; ?><b class="price"><?php echo $this->_var['goods_0_68177400_1300168280']['fittings_price']; ?></b>
  </div>
 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>