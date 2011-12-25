<?php get_header(); ?>
<div id="wrapper">
	<div id="content">

    <?php if (have_posts()) : ?>

        <h2 class="pagetitle">Search Results</h2>

        <div id="nav-above" class="navigation">
            <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts')) ?></div>
            <div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>')) ?></div>
        </div>

		<?php while (have_posts()) : the_post(); ?>
				
            <?php include (TEMPLATEPATH . '/loop.php'); ?>

		<?php endwhile; ?>

        <div id="nav-below" class="navigation">
            <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts')) ?></div>
            <div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>')) ?></div>
        </div>
	
	<?php else : ?>

        <h2 class="center">Not Found</h2>
        <?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
    <div class="clear"></div>
</div>
<?php get_footer(); ?>