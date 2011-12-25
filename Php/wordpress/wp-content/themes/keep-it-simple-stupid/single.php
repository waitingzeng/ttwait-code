<?php get_header(); ?>
<div id="wrapper">
	<div id="content">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
        <?php include (TEMPLATEPATH . '/loop.php'); ?>

		<!--
        <div id="nav-below" class="navigation">
            <div class="nav-previous"><?php previous_post_link('<span class="meta-nav">&laquo;</span> %link') ?></div>
            <div class="nav-next"><?php next_post_link('%link <span class="meta-nav">&raquo;</span>') ?></div>
        </div>
		-->
        <div id="commentarea">
            <?php comments_template(); ?>
        </div>
            <div class="comment-footer"></div>
    <?php endwhile; else: ?>
	
    <p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>
	
    </div>
	
<?php get_sidebar(); ?>
    <div class="clear"></div>
</div>

<?php get_footer(); ?>
