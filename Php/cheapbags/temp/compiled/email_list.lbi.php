<div class="Mod3 blank tc">
<h2><?php echo $this->_var['lang']['email_subscribe']; ?></h2>
  <input type="text" id="user_email" class="InBorderTwo" style="margin-bottom:9px;" size="22"/><br />
  <input type="button" value="<?php echo $this->_var['lang']['email_list_ok']; ?>" class="bnt_number140 blank" onclick="add_email_list();" />
  <input type="button"  value="<?php echo $this->_var['lang']['email_list_cancel']; ?>" class="bnt_number2" onclick="cancel_email_list();" />
</div>
<script type="text/javascript">
var email = document.getElementById('user_email');
function add_email_list()
{
  if (check_email())
  {
    Ajax.call('user.php?act=email_list&job=add&email=' + email.value, '', rep_add_email_list, 'GET', 'TEXT');
  }
}
function rep_add_email_list(text)
{
  alert(text);
}
function cancel_email_list()
{
  if (check_email())
  {
    Ajax.call('user.php?act=email_list&job=del&email=' + email.value, '', rep_cancel_email_list, 'GET', 'TEXT');
  }
}
function rep_cancel_email_list(text)
{
  alert(text);
}
function check_email()
{
  if (Utils.isEmail(email.value))
  {
    return true;
  }
  else
  {
    alert('<?php echo $this->_var['lang']['email_invalid']; ?>');
    return false;
  }
}
</script>

