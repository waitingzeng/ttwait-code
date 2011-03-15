<?php get_header(); ?>
  <div id="content">
  
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  		
      <div class="post-nav"> 
         <span class="previous"><?php previous_post_link('%link') ?></span> 
         <span class="next"><?php next_post_link('%link') ?></span>
      </div>  
   
      <div class="post" id="post-<?php the_ID(); ?>">
         <div class="date"><span><?php the_time('M') ?></span> <?php the_time('d') ?></div>
         <div class="title">
            <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
				<?php the_title(); ?></a></h2>
            <div class="postdata">
               <span class="category"><?php the_category(', ') ?></span>
               <span class="right mini-add-comment"><a href="#respond">Add comments</a></span>
            </div>
         </div>
         
         <div class="entry">
         <?php the_content('Continue reading &raquo;'); ?>
         <?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
         
         <p class="submeta">written by <strong><?php the_author(); ?></strong> 
         <?php 
         if(function_exists("the_tags"))
         the_tags('\\\\ tags: ', ', ', '<br />'); 					
         ?>
         </p>
         <?php edit_post_link('Edit', '', ''); ?>
         </div><!--/entry -->
         
         <?php comments_template(); ?>
      </div><!--/post -->
      
	<?php endwhile; else: ?>
                 
         <p>Sorry, no posts matched your criteria.</p>
         
	<?php endif; ?>

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

