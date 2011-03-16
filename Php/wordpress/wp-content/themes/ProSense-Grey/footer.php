
<hr />
<div id="footer">
	<div id="footer_left">
		Copyright &copy; <a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a></a>
	</div>
	<div style="clear:both;"></div>
	<div id="footerbuttons">

<a href="<?php bloginfo('rss2_url'); ?>" title="Subscribe RSS 2.0" target="_new">
<img src="<?php bloginfo('stylesheet_directory'); ?>/images/button_rss.gif" alt="Subscribe RSS 2.0" />
</a> <a href="http://feedvalidator.org/check.cgi?url=<?php bloginfo('url'); ?>" target="_blank">
<img border="0" title="Validate RSS" src="<?php bloginfo('stylesheet_directory'); ?>/images/validrss.png"  alt='Valid RSS!' />
</a>

<a href="http://feedvalidator.org/check.cgi?url=<?php bloginfo('atom_url'); ?>" title="Valid Atom 0.3" target="_new">
<img src="<?php bloginfo('stylesheet_directory'); ?>/images/button_atom.gif" alt="Valid Atom 0.3" /></a> <a href="http://jigsaw.w3.org/css-validator/check/referer" title="Valid W3C CSS" target="_new"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/css.png" alt="Valid W3C CSS" /></a>
<a href="http://validator.w3.org/check/referer" title="Valid W3C XHTML 1.0" target="_new"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/button_xhtml.gif" alt="Valid W3C XHTML 1.0" /></a>
</div>

</div>
</div>

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