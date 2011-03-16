<?php get_header(); ?>
	<div id="content">
    <div class="clear"></div>
	<?php $count = 1 ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
			<div class="entry">
				<?php if($count == 1){include('adsense_singlepost_top_square.php');} ?>
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
	
			</div>
		</div>
        <?php $count = $count + 1; ?>
	  <?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>