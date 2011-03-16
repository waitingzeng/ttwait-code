<div class="MemberInfo">
<?php if ($this->_var['user_info']): ?>
<?php echo $this->_var['lang']['hello']; ?>，<b class="username"><?php echo $this->_var['user_info']['username']; ?></b>，<?php echo $this->_var['lang']['welcome_return']; ?>！
 <a href="user.php"><?php echo $this->_var['lang']['user_center']; ?></a>
 <a href="user.php?act=logout"><?php echo $this->_var['lang']['user_logout']; ?></a>
<?php else: ?>
<?php echo $this->_var['lang']['hello']; ?>，<?php echo $this->_var['lang']['welcome']; ?>！<acronym class="Sign"><a href="user.php">Sign in</a></acronym>
<acronym class="Join"><a href="user.php?act=register">Join Free</a></acronym>
<?php endif; ?>
</div>