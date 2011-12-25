<?php get_header(); ?>
<div id="wrapper">
	<div id="content">

        <?php if (have_posts()) : ?>

        <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
        <?php /* If this is a category archive */ if (is_category()) { ?>
        <h2 class="pagetitle">Archive for the '<?php echo single_cat_title(); ?>' Category</h2>

        <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
        <h2 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h2>

        <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
        <h2 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h2>

        <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
        <h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>

        <?php /* If this is a search */ } elseif (is_search()) { ?>
        <h2 class="pagetitle">Search Results</h2>

        <?php /* If this is an author archive */ } elseif (is_author()) { ?>
        <h2 class="pagetitle">Author Archive</h2>

        <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
        <h2 class="pagetitle">Blog Archives</h2>

        <?php } ?>


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