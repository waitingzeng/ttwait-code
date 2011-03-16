			</div>
			
			<? get_sidebar(); ?>
			
		</div>
		
		<div id="footer"><div style="clear:both;"></div>
	<div id="footerbuttons">

<a href="<?php bloginfo('rss2_url'); ?>" title="Subscribe RSS 2.0" target="_new">
<img src="<?php bloginfo('stylesheet_directory'); ?>/images/button_rss.gif" alt="Subscribe RSS 2.0" />
</a> <a href="http://feedvalidator.org/check.cgi?url=<?php bloginfo('url'); ?>" target="_blank">
<img border="0" title="Validate RSS" src="<?php bloginfo('stylesheet_directory'); ?>/images/validrss.png"  alt='Valid RSS!' />
</a>

<a href="http://feedvalidator.org/check.cgi?url=<?php bloginfo('atom_url'); ?>" title="Valid Atom 0.3" target="_new">
<img src="<?php bloginfo('stylesheet_directory'); ?>/images/button_atom.gif" alt="Valid Atom 0.3" /></a> <a href="http://jigsaw.w3.org/css-validator/check/referer" title="Valid W3C CSS" target="_new"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/css.png" alt="Valid W3C CSS" /></a>
<a href="http://validator.w3.org/check/referer" title="Valid W3C XHTML 1.0" target="_new"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/button_xhtml.gif" alt="Valid W3C XHTML 1.0" /></a>
</div></div>
		
	</div>
	
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.corner.js"></script>
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/cufon-yui.js"></script>
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/nevis_700.font.js"></script>
	
	<script type="text/javascript">
		//Cufon.replace('#navigation a');
		Cufon.replace('h1, h2, h3, h4, h5, h6');
		
		if(jQuery.browser.msie)
			$('#mainBody').addClass('ie'+parseInt(jQuery.browser.version));
		else if(jQuery.browser.opera)
			$('#mainBody').addClass('opera');
		
		if(!jQuery.browser.msie && !jQuery.browser.opera)
		{
			$('.comment-body, #respond, .post .postinfo').each(function () {
				$(this).corner('10px');
			});
			
			$('li.comment .reply a, .post a.more-link, .paging a, #comments #respond .form #submit, .wp-pagenavi *').each(function () {
				$(this).corner('5px');
			});
			
			$('.post .postinfo ul.tags li a').each(function () {
				$(this).corner('2px');
			});
		}
	</script>
	
	<?php wp_footer(); ?>
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-791706-40']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();


</script>

</body>
</html>