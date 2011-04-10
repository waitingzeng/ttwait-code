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
	
?>