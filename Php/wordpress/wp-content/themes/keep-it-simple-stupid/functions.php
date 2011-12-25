<?php
if ( function_exists('register_sidebar') )
    register_sidebars(1, array(
		'before_widget' => '<li>', // Removes <li>
		'after_widget' => '</li>', // Removes </li>
		'before_title' => '<h2 class="heading">', // Replaces <h2>
		'after_title' => '</h2>', // Replaces </h2>
        'name'=>'Left sidebar'
	));

    register_sidebars(1, array(
		'before_widget' => '<li>', // Removes <li>
		'after_widget' => '</li>', // Removes </li>
		'before_title' => '<h2 class="heading">', // Replaces <h2>
		'after_title' => '</h2>', // Replaces </h2>
        'name'=>'Right sidebar'
	));
?>