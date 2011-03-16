$(function(){
$('#hd-nav>li>a').hover(function(){$(this).next('div').show();},function(){$(this).next('div').hide();});
$('#hd-nav>li>a').next('div').hover(function(){$(this).show();$(this).prev('a').addClass('cur');},function(){$(this).hide();$(this).prev('a').removeClass('cur');});		   
});
$(function(){
var $hdText=$('#hd-sr .hd-text');
$hdText.focus(function(){
	$(this).removeClass('lower');
	if($(this).val()==this.defaultValue){
		$(this).val('');
		}
	}).blur(function(){
		if($(this).val()==''){
			$(this).addClass('lower').val(this.defaultValue);
			}
		});
$('#hd-sr form:first').submit(function(){
	if($hdText.val()==$hdText[0].defaultValue||$hdText.val()==''){
		return false;
		}
	});
});