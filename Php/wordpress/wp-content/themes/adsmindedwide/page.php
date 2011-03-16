<?PHP include ("header.php"); ?>

<div id="contentwrapper">

<div id="content">
	<div id="blogs">
	<br/>
        <br />
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="navi">
			                 <div align="left"><?php previous_post('&laquo; %','','yes') ?></div>
			                 <div align="right"><?php next_post(' % &raquo;','','yes') ?></div>
		              </div> <!-- End Of Class Navi -->
		              <br />
                <div id="post-<?php the_ID(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icon_post.gif" alt="" /> <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="View Details: <?php the_title(); ?>"><?php the_title(); ?></a></h1></div> <!-- End Of Class Title -->

		<div class="article">
<?php include("adsense_singlepost_top_square.php");?>
  <?php the_content("Continue Reading &raquo; <br/>" . the_title('','',false), 0). ""; ?>

        <br/ >

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

		<?php if (!( is_home() || is_page() || is_category() || is_day() || is_month() || is_year() || is_search() )) { ?>
		<p class="postmetadata alt">
						Subscribe <b><?php comments_rss_link('RSS 2.0'); ?></b> feed.

						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							<a href="#respond"><b>Leave a response</b></a>, or <a href="<?php trackback_url(display); ?>"><b>Trackback</b></a> from your own site.

						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							Responses are currently closed, but you can <a href="<?php trackback_url(display); ?> "><b>Trackback</b></a> from your own site.

						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							You can skip to the end and leave a response. Pinging is currently not allowed.

						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							Both comments and pings are currently closed.

						<?php } edit_post_link('Edit this entry.','',''); ?>
				</p>
		<?php } ?>

<br />
<div class="previouspost">
<h3>Best Deal Ads :</h3>
<div align="center">

<?php /* Delete off the codes below (from here until ***** ?> line) and put in your Chitika ads codes */ ?>
<img src="<?php bloginfo('stylesheet_directory'); ?>/dummy_ads/300x250_img.jpg" alt="" />

<?php /*

Google AdSense program policies allow you to place up to three ad units and one link unit on any page. So, you have to play around with the ads placements.

<script type="text/javascript"><!--
ch_client = "";
ch_width = 468;
ch_height = 180;
ch_color_border = "#000000";
ch_color_bg = "#FFFFFF";
ch_color_title = "#0060C0";
ch_color_text = "#333333";
ch_non_contextual = 1;
ch_nosearch = 1 ;
var ch_queries = new Array('ipod mini','pda','lcd','laptop','ram','mp3 player','mobile phone');
var ch_selected=Math.floor((Math.random()*ch_queries.length));
ch_query = ch_queries[ch_selected];
ch_nosearch = 1;
//--></script>
<script  src="http://scripts.chitika.net/eminimalls/mm.js" type="text/javascript">
</script>

                    ***** */ ?>

</div>
</div> <!-- End Of Class previouspost -->

<br />

		<br /><br />

		<?php comments_template(); // Get wp-comments.php template ?>

		<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php endif; ?>

		<!-- start bottom blog nav -->

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
	<?PHP include ("footer.php"); ?>
</div>

</div> <!-- end wrapper -->
</body>
</html>
