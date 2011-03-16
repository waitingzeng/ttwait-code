<?php get_header(); ?>
<div id="wrapper">
	<div id="content">

	<?php include('adsense_homepage_linkunit.php') ?>

	<?php if (have_posts()) : ?>
		<?php $count = 1 ?>
		<?php while (have_posts()) : the_post(); ?>
				
			<div class="post" id="post-<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				
				<div class="entry">
					<?php if($count == 1){include('adsense_singlepost_top_square.php');} ?>
					<?php the_content('Read the rest of this entry &raquo;'); ?>
				</div>
		
				<p class="postmetadata"><small><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --> | Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit','',' |'); ?>  <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></small></p>
			</div>
			
			<?php if ($count==2) { include('adsense_homepage_banner.php'); } ?>
			
			<?php $count = $count + 1; ?>
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
			<div style="clear:both;"></div>
		</div>
		
	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
