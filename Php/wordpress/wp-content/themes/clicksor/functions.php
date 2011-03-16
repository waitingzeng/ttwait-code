<?php
if ( function_exists('register_sidebar') )
    register_sidebars(2);
function widget_mytheme_search() {
?>
<div>
	<form method="get" id="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>"><p><input type="text" value="Search..." name="s" id="s" onfocus="if (this.value == 'Search...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search...';}" /></p></form>
</div>
</form>
<?php
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Search'), 'widget_mytheme_search');

?>