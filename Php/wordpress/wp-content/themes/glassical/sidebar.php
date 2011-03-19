			<div id="right">
				<ul id="sidebar">
					<li class="widget">
						<div class="search_widget">
							<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
								<input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
								<input type="submit" name="" value="" id="sb" />
							</form>
							<!--<a href="#" class="feedbutton"></a>-->
						</div>
					</li>
					<li class="widget"><?php include('adsense_sidebar_right.php') ?></li>
					<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : else : ?>
					<li class="widget">
						<ul>
							<li>
								<img src="<?php bloginfo('stylesheet_directory'); ?>/images/ad-300-250.jpg" alt="Ad" width="300" height="250" />
							</li>
						</ul>
					</li>
					
					<li class="widget">
						<h2><?php _e('Categories'); ?></h2>
						<ul>
							<?php wp_list_cats('optioncount=1&children=1'); ?>
						</ul>
					</li>
					
					<li class="widget">
						<h2><?php _e('Archives'); ?></h2>
						<ul>
							<?php wp_get_archives('type=monthly'); ?>
						</ul>
					</li>
					
					<li class="widget">
						<ul><?php get_links_list(); ?></ul>
					</li>
					
					<li class="widget">
						<h2><?php _e('Meta'); ?></h2>
						<ul>
							<?php wp_register(); ?>
							<li><?php wp_loginout(); ?></li>
							<li><a href="<?php echo bloginfo('rss2_url'); ?>"><?php _e('Entries RSS'); ?></a></li>
							<li><a href="<?php echo bloginfo('comments_rss2_url'); ?>"><?php _e('Comments RSS'); ?></a></li>
							<li><a href="http://validator.w3.org/check?uri=referer"><?php _e('Valid XHTML'); ?></a></li>
						</ul>
					</li>
					<?php endif; ?>
				</ul>
				
				<div id="creditsfix"></div>
				
			</div>
			<!--
			<ul id="credits">
				<li><a href="http://www.symmetricweb.com" title="Web Design Service"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/symmetric-web.jpg" alt="Web Design Service" /> Made by Symmetric Web</a></li>
				<li><a href="http://www.smashingmagazine.com"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/smashing-magazine.jpg" alt="Smashing Magazine" /> Distributed by Smashing Magazine</a></li>
			</ul>-->