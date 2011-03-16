<?php if ($this->_var['promotion_goods']): ?>
<div class="blank"></div>
<div class="Promotion blank">
 <h2><?php echo $this->_var['lang']['promotion_goods']; ?>
<a href="search.php?intro=promotion" class="more"><img src="themes/EnTemplate/images/more.gif"/></a>
 </h2>
 <?php $_from = $this->_var['promotion_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['promotion_foreach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['promotion_foreach']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['promotion_foreach']['iteration']++;
?>
   <div class="goodsbox">
    <div class="imgbox">   
   <a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['thumb']; ?>" border="0" alt="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"/></a>	 
	 </div>   
    <p><a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo $this->_var['goods']['short_name']; ?></a><br />
		  <?php echo $this->_var['lang']['promote_price']; ?><span class="price"><?php echo $this->_var['goods']['promote_price']; ?></span>
			</p>
  </div>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<?php endif; ?>