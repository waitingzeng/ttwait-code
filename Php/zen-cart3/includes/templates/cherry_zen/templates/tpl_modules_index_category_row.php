<?php
$cachekey = 'modules_index_category.row.tpl';
$content = get_cache($cachekey);
if(!$content){
ob_start();
require(DIR_WS_MODULES . zen_get_module_directory('index_category_row.php'));
$title = '<h2 class="centerBoxHeading">All Brand In Our Site</h2>';
?>
<!-- bof: index categorys row -->
<div class="centerBoxWrapper" id="brandLogo">
<?php
  require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
?>
<script type="text/javascript">
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
</script>
</div>
<?php
	$content = ob_get_contents();
	save_cache($cachekey, $content);
	ob_end_clean();
}
echo $content;
?>