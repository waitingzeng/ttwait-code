<?php if ($this->_var['group_buy_goods']): ?>
<div class="Mod2 blank">
<h2><?php echo $this->_var['lang']['group_buy_goods']; ?>
<a href="group_buy.php" class="more"><img src="themes/EnTemplate/images/more.gif" ></a></h2>
  <div class="tagcontent">
  <?php $_from = $this->_var['group_buy_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_81035500_1300168079');if (count($_from)):
    foreach ($_from AS $this->_var['goods_0_81035500_1300168079']):
?>
 <div class="goodsbox">
  <div class="imgbox"><a href="<?php echo $this->_var['goods_0_81035500_1300168079']['url']; ?>"><img src="<?php echo $this->_var['goods_0_81035500_1300168079']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods_0_81035500_1300168079']['goods_name']); ?>" /></a></div>
	<p>
  <a href="<?php echo $this->_var['goods_0_81035500_1300168079']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods_0_81035500_1300168079']['goods_name']); ?>"><?php echo htmlspecialchars($this->_var['goods_0_81035500_1300168079']['short_style_name']); ?></a><br />
  <span class="price">
   <?php echo $this->_var['goods_0_81035500_1300168079']['last_price']; ?>
  </span>
	</p>
 </div>
 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </div>
 </div>
 <?php endif; ?>