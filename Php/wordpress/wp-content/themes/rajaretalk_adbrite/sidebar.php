	<div id="sidebar">
		<?php if (is_home()) { $check_home = '1'; } else { $check_home = '0'; } ?>
		
		<div class="widget">
			<div class="textwidget"><?php include('adsense_sidebar.php') ?></div>
		</div>
		<div class="widget"><h4 class="widgettitle"><?php echo bloginfo('name');?></h4>
			<ul>
				<?php query_posts('showposts=20&orderby=rand'); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
				<?php endwhile; endif; ?>
			</ul>
		</div>
		<?php /* If this is the frontpage */ if ($check_home == '1') { ?>		
        
        <div class="widget"><h4 class="widgettitle"><?php _e('Links'); ?></h4>
			<ul>
            	<?php get_links('84', '<li>', '</li>', '<br />', 0, 'name', 0, 0, -1, 0); ?>
			</ul>
		</div>
		<?php } ?>
        
        <div class="widget">
            <ul>
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>
            
        <?php endif; ?>
        </ul>
        </div>

</div>