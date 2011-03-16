<?php get_header(); ?>
				
				<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<div class="meta">
						Posted by <a href="<?php the_author_url(); ?>"><?php the_author(); ?></a> on <?php the_time('jS F Y') ?><?php edit_post_link('Edit this entry', ' // ', ''); ?>
					</div>
					<div class="comment_count"><?php comments_popup_link('0', '1', '%', '', 'n/a'); ?></div>
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
					<div class="body">
						<?php the_content('Continue Reading'); ?>
					</div>
				</div>
				<?php endwhile; ?>
				
				<div class="paging">
					<div class="prev"><?php next_posts_link('Previous Posts') ?></div>
					<div class="next"> <?php previous_posts_link('Next Posts') ?></div>
				</div>
				
				<?php endif; ?>
				
<?php get_footer(); ?>