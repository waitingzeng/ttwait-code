<?php if ($this->_var['auction_list']): ?>
<div class="Mod2 blank">
<h2><?php echo $this->_var['lang']['auction_goods']; ?>
<a href="auction.php" class="more"><img src="themes/EnTemplate/images/more.gif" ></a></h2>
 <div class="tagcontent">
  <?php $_from = $this->_var['auction_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'auction');if (count($_from)):
    foreach ($_from AS $this->_var['auction']):
?>
   <div class="goodsbox">
   <div class="imgbox"><a href="<?php echo $this->_var['auction']['url']; ?>"><img src="<?php echo $this->_var['auction']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['auction']['goods_name']); ?>"/></a></div>
	 <p>
    <a href="<?php echo $this->_var['auction']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['auction']['goods_name']); ?>"><?php echo htmlspecialchars($this->_var['auction']['short_style_name']); ?></a><br />
  <span class="price">
    <?php echo $this->_var['auction']['formated_start_price']; ?>
  </span> 
	</p>
	 </div> 
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
</div>
<?php endif; ?>