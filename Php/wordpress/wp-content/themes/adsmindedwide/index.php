<?php include ("header.php"); ?>

<div id="contentwrapper">

<div id="content">
	<div id="blogs">
    	<?php $count = 0; ?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <br /><br />
		<div id="post-<?php the_ID(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icon_post.gif" alt="" /> <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="View Details: <?php the_title(); ?>"><?php the_title(); ?></a></h2></div> <!-- End Of Class Title -->
                    
		<div class="small">
			<?php the_time("l j F Y @ g:i a") ?>
		</div> <!-- End Of Class Small -->
		
		<div class="article">
	<?php if($count == 0){include("adsense_singlepost_top_square.php");}?>
  <?php the_content("<br />Continue Reading &raquo; <br />" . the_title('','',false), 0). ""; ?>

<br/>
        </div> <!-- End Of Class Article -->

<br />
		<div class="postmetadata alt">
			<?php comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)')); ?>
			&nbsp;|&nbsp;<?php _e("Posted in"); ?> <?php the_category(',') ?>
            &nbsp; &nbsp;<?php edit_post_link(); ?>
		</div> <!-- End Of Class Meta -->

		<!--
		<?php trackback_rdf(); ?>
		-->
		<?php $count++; ?>
		<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php endif; ?>

		<!-- start bottom blog nav -->
<br /><br />
		<div align="center">
            <span class="menu"><?php previous_posts_link('Next Posts &raquo;&raquo;') ?></span>
            <span class="menu"><?php next_posts_link('&laquo;&laquo; Previous Posts') ?></span>
        </div>

	</div> <!-- end blogs -->


	<div id="centerbar">
        <?php include ("centerbar.php"); ?>
    </div> <!-- End Of Class centerbar -->

    <div id="sidebar">
        <?php get_sidebar(); ?>
    </div> <!-- End Of Class sidebar -->

</div> <!-- end content -->


</div> <!-- end contentwrapper -->

<div id="footer">
    <?php get_footer(); ?>
</div>

</div> <!-- end wrapper -->
</body>
</html>
