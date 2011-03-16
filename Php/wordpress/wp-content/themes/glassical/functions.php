<?php
	
	if(function_exists('register_sidebar') )
	{
		register_sidebar();
		register_sidebar(array(
			'name' => 'Header Ad',
			'before_widget' => '<div class="ad">',
			'after_widget' => '</div>',
			'before_title'  => '',
			'after_title'   => ''
		));
	}
	
	function widget_mytheme_search() {
		include(TEMPLATEPATH . '/searchform.php');
	}
	
	/*if ( function_exists('register_sidebar_widget') )
		register_sidebar_widget(__('Search'), 'widget_mytheme_search');*/
	
	function is_even($num)
	{
		if($num % 2 == 0)
			return true;
		else
			return false;
	}
	
?>