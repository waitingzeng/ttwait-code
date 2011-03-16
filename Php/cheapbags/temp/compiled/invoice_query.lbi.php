<?php if ($this->_var['invoice_list']): ?>
<style type="text/css">
.vote{
border-bottom:1px dashed #ccc;
margin-bottom:8px;
padding-bottom:5px;
padding-top:4PX;
}
.vote form{display:inline;}
.vote form a{text-decoration:underline;}
</style>
<div class="Mod3 blank">
<h2 class="tc"><?php echo $this->_var['lang']['shipping_query']; ?></h2>
 <?php $_from = $this->_var['invoice_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'invoice');$this->_foreach['invoice'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['invoice']['total'] > 0):
    foreach ($_from AS $this->_var['invoice']):
        $this->_foreach['invoice']['iteration']++;
?>
  <div class="vote">
   <font class="username"><?php echo $this->_var['lang']['order_number']; ?></font> <?php echo $this->_var['invoice']['order_sn']; ?><br />
   <font class="username"><?php echo $this->_var['lang']['consignment']; ?></font> <?php echo $this->_var['invoice']['invoice_no']; ?><br />
  </div>
   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<?php endif; ?>