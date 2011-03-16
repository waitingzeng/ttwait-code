<?php if (empty ( $this->_var['order_query'] )): ?>
<script>var invalid_order_sn = "<?php echo $this->_var['lang']['invalid_order_sn']; ?>"</script>
<div class="Mod3 blank">
<h2 class="tc"><?php echo $this->_var['lang']['order_query']; ?></h2>
<div class="clearfix">
  <form name="ecsOrderQuery" class="tc">
    <input type="text" name="order_sn" class="InBorderTwo" size="22" /><br /><br />
    <input type="button" value="<?php echo $this->_var['lang']['query_order']; ?>" class="bnt_number6 blank" onclick="orderQuery();" />
  </form>
 <div id="ECS_ORDER_QUERY" class="fgry word">
      <?php else: ?>
      <?php if ($this->_var['order_query']['user_id']): ?>
   <span class="username"><?php echo $this->_var['lang']['order_number']; ?></span>：<a href="user.php?act=order_detail&order_id=<?php echo $this->_var['order_query']['order_id']; ?>"><?php echo $this->_var['order_query']['order_sn']; ?></a><br>
    <?php else: ?>
   <span class="username"><?php echo $this->_var['lang']['order_number']; ?></span>：<?php echo $this->_var['order_query']['order_sn']; ?><br>
    <?php endif; ?>
   <span class="username"><?php echo $this->_var['lang']['order_status']; ?></span>：<font class="f1"><?php echo $this->_var['order_query']['order_status']; ?></font><br>
    <?php if ($this->_var['order_query']['invoice_no']): ?>
   <span class="username"><?php echo $this->_var['lang']['consignment']; ?></span>：<?php echo $this->_var['order_query']['invoice_no']; ?>
    <?php endif; ?>
    <?php if ($this->_var['order_query']['shipping_date']): ?>
   <span class="username"><?php echo $this->_var['lang']['shipping_date']; ?></span>： <?php echo $this->_var['order_query']['shipping_date']; ?><br>
    <?php endif; ?>
    
    <?php endif; ?>
   </div>
</div>
</div>
