<?php include ("header.php"); ?>

<div id="contentwrapper">

<div id="content">
	<div id="blogs">
	<br/>
        <br />

            <?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
		<h1><u>Archive for the '<?php echo single_cat_title(); ?>' Category</u></h1>

 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h1><u>Archive for <?php the_time('F jS, Y'); ?></u></h1>

	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h1><u>Archive for <?php the_time('F, Y'); ?></u></h1>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h1><u>Archive for <?php the_time('Y'); ?></u></h1>

	  <?php /* If this is a search */ } elseif (is_search()) { ?>
		<h1><u>Search Results</u></h1>

	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h1><u>Author Archive</u></h1>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h1><u>Blog Archives</u></h1>

		<?php } ?>


		<?php while (have_posts()) : the_post(); ?>
		<br /><br />
				<div id="post-<?php the_ID(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icon_post.gif" alt="" /> <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="View Details: <?php the_title(); ?>"><?php the_title(); ?></a></h2></div> <!-- End Of Class Title -->

		<div class="small">
			<?php the_time("l j F Y @ g:i a") ?>
		</div> <!-- End Of Class Small -->

        <div class="article">
            <?php the_content("Continue Reading &raquo; <br/>" . the_title('','',false), 0). ""; ?>
        </div> <!-- End Of Class Article -->

<br />
		<div class="postmetadata alt">
			<?php comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)')); ?>
			&nbsp;|&nbsp;<?php _e("Posted in"); ?> <?php the_category(',') ?>
            &nbsp; &nbsp;<?php edit_post_link(); ?>
		</div> <!-- End Of Class Meta -->


		<?php endwhile; ?>

		<!-- start bottom blog nav -->
<br /><br />
		<div align="center">
            <span class="menu"><?php previous_posts_link('Next Posts &raquo;&raquo;') ?></span>
            <span class="menu"><?php next_posts_link('&laquo;&laquo; Previous Posts') ?></span>
        </div>

	<?php else : ?>

		<h2>Not Found</h2>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

	<?php endif; ?>

	</div> <!-- end blogs -->

	<div id="centerbar">
        <br/>
        <?php include ("centerbar.php"); ?>
    </div> <!-- End Of Class centerbar -->

    <div id="sidebar">
        <br/>
        <?php get_sidebar(); ?>
    </div> <!-- End Of Class sidebar -->

</div> <!-- end content -->

</div> <!-- end contentwrapper -->

<div id="footer">
	<?PHP include ("footer.php"); ?>
</div>

</div> <!-- end wrapper -->
</body>
</html>
