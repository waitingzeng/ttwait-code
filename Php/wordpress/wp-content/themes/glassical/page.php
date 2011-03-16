<?php get_header(); ?>
				
				<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				
				<div class="post" id="post-<?php the_ID(); ?>">
					<div class="meta">
						Posted by <a href="<?php the_author_url(); ?>"><?php the_author(); ?></a> on <?php the_time('jS F Y') ?><?php edit_post_link('Edit this entry', ' // ', ''); ?>
					</div>
					<div class="comment_count"><?php comments_popup_link('0', '1', '%', '', 'n/a'); ?></div>
					<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>
					<div class="body">
						<?php the_content('<p>Continue Reading&#8230;</p>'); ?>
					</div>
					<?php wp_link_pages(); ?> 
				</div>
				
				<?php comments_template(); ?>
				
				<?php endwhile; ?>
				<?php endif; ?>
				
<?php get_footer(); ?>