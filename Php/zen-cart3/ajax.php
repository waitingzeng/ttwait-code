<?php
require('includes/application_top.php');
?>
function setItems(loging){
	var navMain = document.getElementById('navMain');
    var elms = navMain.getElementsByTagName('li');
    var len = elms.length;
    var i = 0;
    while(i < len){
        var elm = elms[i];
        var remove = false;
        if(elm.className.indexOf('loging') >=0){
            if(!loging)	remove = true;
        }
        if (elm.className.indexOf('nolog') >= 0) {
            if(loging) remove = true;
        	//elm.style.display = loging ? 'none' : 'block';
        }
        if(remove){
        	elm.parentNode.removeChild(elm);
            len--;
            continue;
        }else{
        	elm.style.display = 'inline';
        	i++;
        }
    }
}
<?php
	if($_SESSION['customer_id']){
		echo "setItems(true);";
	}else{
		echo "setItems(false);";
	}
?>