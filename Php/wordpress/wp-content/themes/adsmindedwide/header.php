<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/1">
	<title><?php bloginfo('name'); ?></title>
	<meta name="ROBOTS" content="INDEX,FOLLOW"/>
    <meta name="Title" content="<?php bloginfo('name'); ?>" />
	<meta name="description" content="One Wordpress Blog."/>
	<meta name="abstract" content="One Wordpress Blog."/>
	<meta name="keywords" content="Wordpress Blog"/>
	<meta name="revisit-after" content="1 days"/>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
	<style type="text/css" media="screen">@import url( <?php bloginfo('stylesheet_url'); ?> );</style>
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/rss+xml" title="Comments RSS 2.0" href="<?php bloginfo('comments_rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS 0.92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php wp_head(); ?>
</head>

<body>

<div id="wrapper">

<!-- search bar -->
<div id="searchbar">
	<div id="searchbox">
        <a name="top"></a>
		<form id="searchform" method="get" action="<?php bloginfo('home'); ?>/">
		<span class="small" style="margin-left:22px"><input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" size="25" /> <input type="submit" name="submit" value="<?php _e('Search'); ?>" /></span>
		</form>
	</div>

<!-- time and date -->

	<div id="current_time">
		<?php
			$hourdiff = "12"; /* time difference, ex: "-8" or "8" */
			$timeadjust = ($hourdiff * 60 * 60);
			$melbdate = date("g:i a - D j M Y",time() + $timeadjust);
			print ("$melbdate");
		?>
	</div>

</div><!-- end search bar -->

<div id="header">

<!-- Header Ads -->

	<div id="headerads">
		<?php include ("headerads.php"); ?>
	</div>

<div id="heading">
    <h1><a href="<?php echo get_settings('home'); ?>/"><u><?php bloginfo('name'); ?></u></a></h1>
    <div class="description"><?php bloginfo('description'); ?></div>
</div>


</div><!-- end header -->
