<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php bloginfo('name'); ?> <?php if ( is_home() ) { ?> - <?php bloginfo('description'); } ?> <?php wp_title(); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<?php wp_get_archives('type=monthly&format=link'); ?>
	
	<?php 
		if(function_exists('is_singular') && function_exists('wp_enqueue_script')) {
			if (is_singular())
				wp_enqueue_script( 'comment-reply' );
		}
	?>

	<?php wp_head(); ?>
	
</head>

<body id="mainBody">
	
	<div id="pagewidth" class="clearfix">
		
		<div id="header">
			<div class="logo">
				<h1><a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a></h1>
            	<div class="description"><?php bloginfo('description'); ?></div>
			</div>
			
			<?php if (!dynamic_sidebar("Header Ad") ) : ?>  
				<div class="ad"><?php include('adsense_top.php'); ?></div>
			<?php endif; ?>
			
			
		</div>
		
		<div id="content">
			<div id="left">
				
				<?
					if(is_home()) : 
						_e('<h1 class="heading">Latest Posts</h1>');
					elseif(is_search()) : 
						_e('<h1 class="heading">Search Results for "').the_search_query()._e('"</h1>');
					elseif(is_category()) : 
						_e('<h1 class="heading">Archives for "').single_cat_title('')._e('"</h1>');
					elseif(is_tag()) : 
						_e('<h1 class="heading">Posts tagged as "').single_tag_title()._e('"</h1>');
					elseif(is_author()) : 
						_e('<h1 class="heading">Posts by "').the_author_link()._e('"</h1>');
					elseif(is_archive()) : 
						_e('<h1 class="heading">Archives for "').the_time('F, Y')._e('"</h1>');
					endif;
				?>