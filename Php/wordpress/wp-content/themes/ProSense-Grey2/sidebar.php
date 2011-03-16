	<div id="sidebar">
		<?php if (is_home()) { $check_home = '1'; } else { $check_home = '0'; } ?>
		
		<div class="sidebar_left">
			<ul>
				<li>
					<?php include('adsense_sidebar.php') ?>
				</li>
			
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>
		
				<?php endif; ?>
			
			</ul>
			
		</div>

		<div style="clear:both;"></div>
	</div>