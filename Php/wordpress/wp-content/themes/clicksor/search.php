<?php get_header(); ?>
	<div id="content">
      <div class="clear"></div>
	<?php if (have_posts()) : ?>

		<h2 class="pagetitle">Search Results</h2>
		
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
			<div style="clear:both;"></div>
		</div>


		<?php while (have_posts()) : the_post(); ?>
				
			<div class="post">
				<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
								
				<div class="entry">
					<?php the_excerpt() ?>
				</div>
		
				<p class="postmetadata"><small><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --> | Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit','',' |'); ?>  <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></small></p>
			</div>
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
			<div style="clear:both;"></div>
		</div>
	
	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
		
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>