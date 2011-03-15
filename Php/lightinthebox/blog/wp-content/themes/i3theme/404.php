<?php get_header(); ?>
  <div id="content">
      
    <div class="post">
        <h2>Error 404 - Not Found</h2>
		
		<div class="entry">
		<p>Sorry, the page that you are looking for does not exist.</p>	
		</div><!--/entry -->
	
	</div><!--/post -->
	
  </div><!--/content -->
  
		<div id="footer">
		  	<span class="mangoorange">
         <a href="http://www.i3theme.com">i3Theme 1.7</a> is designed by <a href="http://www.ndesign-studio.com">N.Design Studio</a>, customized by <a href="http://www.mangoorange.com/">MangoOrange&trade;</a>, <br/> sponsored by <a href="http://www.web-hosting-top.com/">Top 10 Web Hosting Worldwide</a> and <a href="http://www.b4udecide.com/">Webhosting</a>.
         </span>
		</div>
		
	</div><!--/left-col -->

<?php 
$current_page = $post->ID; // Hack to prevent the no sidebar error
include_once("sidebar-right.php"); 
?>
  
<?php get_footer(); ?>