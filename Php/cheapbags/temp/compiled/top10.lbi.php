<div class="Mod3 blank">
<h2 class="Top"><?php echo $this->_var['lang']['top10']; ?></h2>
<div class="top10List clearfix">
  <?php $_from = $this->_var['top_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['top_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['top_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['top_goods']['iteration']++;
?>
  <ul class="clearfix">
	<img src="themes/EnTemplate/images/top_<?php echo $this->_foreach['top_goods']['iteration']; ?>.gif" class="iteration" />
      <li class="topimg f_l">
      <a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" /></a>
      </li>      
      <li class="txt f_r">
			<a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>"><?php echo $this->_var['goods']['short_name']; ?></a><br />
      <?php echo $this->_var['lang']['shop_price']; ?><font class="price"><?php echo $this->_var['goods']['price']; ?></font><br />
     </li>
    </ul>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </div>
</div>
