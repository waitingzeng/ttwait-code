<?php get_header(); ?>
				
				<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<div class="meta">
						Posted by <a href="<?php the_author_url(); ?>"><?php the_author(); ?></a> on <?php the_time('jS F Y') ?><?php edit_post_link('Edit this entry', ' // ', ''); ?>
					</div>
					<div class="comment_count"><?php comments_popup_link('0', '1', '%', '', 'n/a'); ?></div>
					<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>
					<div class="body">
						<?php include('adsense_singlepost_top_square.php') ?>
						<?php the_content('<p>Continue Reading&#8230;</p>'); ?>
					</div>
					<div class="postinfo">
						<ul class="post-categories">
							<h2>Filed Under</h2>
							<li>
							<?php the_category('</li><li>'); ?>
							</li>
						</ul>
						<?php the_tags('<ul class="tags"><h2>Tags</h2><li class="first">', '</li><li>', '</li></ul>'); ?>
					</div>
				</div>
					
				<? /* ?><ul class="paging">
					<h2>More Posts</h2>
					<li><?php previous_post_link('%link', 'Previous: %title') ?></li>
					<li><?php next_post_link('%link', 'Next: %title') ?></li>
				</ul><? */ ?>
				
				<?php comments_template(); ?>
				
				<?php endwhile; ?>
				
				<?php endif; ?>
				
<?php get_footer(); ?>