<div id="sidebar2">
	<!--
	<div class="widget">
        <div class="textwidget"><?php include('adsense_sidebar_right.php') ?></div>
    </div>-->
	<div class="widget"><h4 class="widgettitle">Categories</h4>
        <ul>
            <?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=1'); ?>
        </ul>
    </div>
    <div class="widget">
    	<ul>
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>
		
	<?php endif; ?>
    </ul>
    </div>
</div>