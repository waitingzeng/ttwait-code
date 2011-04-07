
<!-- resources -->

<br />
<div class="blocktitle"><?php _e('Resources'); ?></div>
	<div class="block">
	        <div class="menu">
	        <u><b>Subscribe</b></u> <a href="<?php bloginfo('rss2_url'); ?>" target="_new" title="rss"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icon_rss.gif" alt="rss" /></a>
                <div class="nolilink">
                    <ul>
				        <li><a href="<?php bloginfo('rss2_url'); ?>" target="_new">RSS 2.0</a></li>
				        <li><a href="<?php bloginfo('rss_url'); ?>" target="_new">RSS 0.92</a></li>
                        <li><a href="<?php bloginfo('atom_url'); ?>" target="_new">Atom 0.3</a></li>
                    </ul>
                </div>

        <br />
		<u><b>Pages</b></u>
		<div><img src="<?php bloginfo('stylesheet_directory'); ?>/images/blank.gif" width="1" height="5" alt="+" /></div>
            <ul>
				<?php wp_list_pages('title_li='); ?>
			</ul>

    </div>

<!-- categories -->

<br />
<div class="blocktitle"><?php _e('Blog Categories'); ?></div>
	<div class="block">
		<div class="menu">
			<ul class="slightbigger">
				<?php list_cats(FALSE, '', 'name',
                				'asc', '', TRUE, FALSE,
                				TRUE, FALSE, FALSE,
                				TRUE, FALSE, '', FALSE,
                				'', '', '',
                				TRUE); ?>
			</ul>
		</div>
	</div>

<!-- monthly archives -->

<br />
<div class="blocktitle"><?php _e('Monthly Archives'); ?></div>
	<div class="block">
		<div class="menu">

                <u><b>By Month</b></u>
                <div><img src="<?php bloginfo('stylesheet_directory'); ?>/images/blank.gif" width="1" height="5" alt="" /></div>
                <ul>
				<?php wp_get_archives('type=monthly&show_post_count=1'); ?>
			</ul>
		</div>
	</div>


   
<!-- Links -->
<?php if ( is_home() ) { ?>
<br />
<div class="blocktitle"><?php _e('Links'); ?></div>
	<div class="block">
		<div class="menu">
			<ul>
				<?php /* Get links from the first category (by default is Blogroll) */
                    get_links('1', '<li>', '</li>', '<br />', 0, 'name', 0, 0, -1, 0);
                ?>
			</ul>
		</div>
	</div>
<?php }?>

<?php /* If this is the frontpage */  if ( is_home() ) { ?>
<br /><br />
<!-- Search Google -->
<center>
<form method="get" action="http://www.google.com/custom" target="google_window">
<table bgcolor="#FFFFFF">
<tr><td nowrap="nowrap" valign="top" align="left" height="32">
<a href="http://www.google.com/">
<img src="http://www.google.com/logos/Logo_25wht.gif" border="0" alt="Google" align="middle"></img></a>
<br/>
<input type="text" name="q" size="18" maxlength="255" value=""></input>
</td></tr>
<tr><td valign="top" align="left">
<input type="submit" name="sa" value="Search"></input>
<input type="hidden" name="client" value="google_adsense_account"></input>
<input type="hidden" name="forid" value="1"></input>
<input type="hidden" name="channel" value="5292143788"></input>
<input type="hidden" name="ie" value="ISO-8859-1"></input>
<input type="hidden" name="oe" value="ISO-8859-1"></input>
<input type="hidden" name="cof" value="GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:FFFFFF;LBGC:336699;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;FORID:1;"></input>
<input type="hidden" name="hl" value="en"></input>
</td></tr></table>
</form>
</center>
<!-- Search Google -->
<?php } ?>

