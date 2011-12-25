	<div id="sidebar">
        <div class="side-ad">
        <ul>
        	<?php include (TEMPLATEPATH . "/include3.php"); ?>
            <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar("Left sidebar") ) : else : ?>

            <?php wp_list_pages('title_li=<h2>Pages</h2>' ); ?>

            <li><h2>Archives</h2>
                <ul>
                    <?php wp_get_archives('type=monthly'); ?>
                </ul>
            </li>

            <li><h2>Categories</h2>
                <ul>
                    <?php wp_list_cats('sort_column=name&optioncount=0&hierarchical=0'); ?>
                </ul>
            </li>
            <?php endif; ?>
 

            
        </ul>
        </div>
        <ul>
        	<?php include (TEMPLATEPATH . "/include3.php"); ?>
            <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar("Right sidebar") ) : else : ?>

            <?php wp_list_pages('title_li=<h2>Pages</h2>' ); ?>

            <li><h2>Archives</h2>
                <ul>
                    <?php wp_get_archives('type=monthly'); ?>
                </ul>
            </li>

            <li><h2>Categories</h2>
                <ul>
                    <?php wp_list_cats('sort_column=name&optioncount=0&hierarchical=0'); ?>
                </ul>
            </li>

            <?php get_links_list(); ?>

            <?php endif; ?>
        </ul>
	</div>