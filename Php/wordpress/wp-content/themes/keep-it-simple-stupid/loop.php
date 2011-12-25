<?php
/*
Template Name: Wordpress loop
*/
$count++;
?>
        <div class="post" id="post-<?php the_ID(); ?>">
            <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
            <div class="posted"><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></div>

            <div class="entry">
            <?php if ($count == 1) { ?>
            <?php include (TEMPLATEPATH . "/include2.php"); ?>
            <?php } ?>
            <?php if (is_home() || is_single()) {
                    the_content('Read more');
            } elseif (is_archive() || is_search()) {
                    the_excerpt();
            }
            ?>
            <?php link_pages('<div class="page-link">Pages: ', '</div>', 'number'); ?>
            </div>

            <div class="postmetadata">
                <div class="cat">Posted in <?php the_category(', ') ?></div>

                <div class="comments"><?php if(!is_single()){comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;');} else { ?>
                <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php comments_number('No Responses', 'One Response', '% Responses' );?></a>
                <?php } ?>
                </div>
            </div>
            
        </div>