	<div id="sidebar">
		<?php if (is_home()) { $check_home = '1'; } else { $check_home = '0'; } ?>
		
		<div class="sidebar_left">
			<ul>
				<li>
					<?php include('adsense_sidebar.php') ?>
				</li>
			
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>
		
				<?php endif; ?>
			
			</ul>
			
		</div>

		<div class="sidebar_right">
			<ul>
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>
				<li>
					<?php include (TEMPLATEPATH . '/searchform.php'); ?>
				</li>
			
				<?php wp_list_pages('title_li=<h2>Pages</h2>' ); ?>
				
				<li><h2>Archives</h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
				</li>			
				<li><h2>Categories</h2>
					<ul>
					<?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=1'); ?>
					</ul>
				</li>
	
				<li><h2>Recent Entries</h2>
				<ul>
					<?php query_posts('showposts=10'); ?>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
					<?php endwhile; endif; ?>
				</ul>
				</li>

				<?php /* If this is the frontpage */ if ($check_home == '1') { ?>				
					<?php get_links_list(); ?>
			
				<?php } ?>
			<?php endif; ?>
			</ul>
		</div>
		<div style="clear:both;"></div>
	</div>