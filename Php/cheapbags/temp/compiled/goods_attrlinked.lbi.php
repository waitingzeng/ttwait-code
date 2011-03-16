<?php $_from = $this->_var['attribute_linked']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'linked');$this->_foreach['links'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['links']['total'] > 0):
    foreach ($_from AS $this->_var['linked']):
        $this->_foreach['links']['iteration']++;
?>
<?php if ($this->_var['linked']['goods']): ?>
<div class="Mod2 blank" id="attribute<?php echo $this->_foreach['links']['iteration']; ?>">
<h2><?php echo sub_str($this->_var['linked']['title'],11); ?></h2>
 <div class="PublicBlank">
 <?php $_from = $this->_var['linked']['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'linked_goods_data');if (count($_from)):
    foreach ($_from AS $this->_var['linked_goods_data']):
?>
  <ul class="attribute">
      <li>
      <a href="<?php echo $this->_var['linked_goods_data']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['linked_goods_data']['goods_thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['linked_goods_data']['name']); ?>" align="left" /></a>
   <a href="<?php echo $this->_var['linked_goods_data']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['goods']['linked_goods_data_name']); ?>"><?php echo htmlspecialchars($this->_var['linked_goods_data']['short_name']); ?></a><br />
      <b class="PriceTwo"><?php echo $this->_var['linked_goods_data']['shop_price']; ?></b><br />
      </li>
  </ul>
 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </div> 
</div>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>