				<div id="comments">
					
					<?
						if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
							die ('Please do not load this page directly. Thanks!');
						
						if(function_exists('post_password_required'))
						{
							if (post_password_required()) {
								_e('<p class="notice">This post is password protected. Enter the password to view comments.</p>');
								return;
							}
						}
						else
						{
							if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password)
							{
								_e('<p class="notice">This post is password protected. Enter the password to view comments.</p>');
								return;
							}
						}
					?>
					
					<?php if ( have_comments() ) : ?>
					<ol class="commentlist clearfix">
						
						<h2><?php comments_number(__('No Responses'), __('1 Response'), __('% Responses')); ?></h2>
						
						<div class="paging">
							<div class="prev"><?php previous_comments_link() ?></div> 
							<div class="next"><?php next_comments_link() ?></div>
						</div>
						
						<? wp_list_comments('avatar_size=75'); ?>
						
					</ol>
					
					<div class="paging">
						<div class="prev"><?php previous_comments_link() ?></div> 
						<div class="next"><?php next_comments_link() ?></div>
					</div>
					
					<?php else : // this is displayed if there are no comments so far ?>
						
						<?php if ('open' == $post->comment_status) : ?>
						<!-- If comments are open, but there are no comments. -->
						<p class="notice">No comments yet!</p>
						<?php else : // comments are closed ?>
						<!-- If comments are closed. -->
						<p class="notice">Comments are closed!</p>
						<?php endif; ?>
						
					<?php endif; ?>
					
					<?php if ('open' == $post->comment_status) : ?>
					<div id="respond" class="clearfix">
						
						<h2>Post your comments</h2>
						
						<div class="cancel-comment-reply">
							<small><?php cancel_comment_reply_link(); ?></small>
						</div>
						
						<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
						<p class="notice">You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
						<?php else : ?>
						<form action="/wp-comments-post.php" method="post" class="form clearfix">
							
							<?php if ( $user_ID ) : ?>
							
							<p>
								Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a>
							</p>
							
							<?php else : ?>
							
							<p>
								<label for="author">Name <small>(Required, never displayed)</small></label>
								<input type="text" name="author" id="author" value="<?php if($comment_author) : echo $comment_author; else: echo 'Your Name'; endif; ?>" tabindex="1" class="tf" />
							</p>
							
							<p>
								<label for="email">E-mail <small>(Required, never displayed)</small></label>
								<input type="text" name="email" id="email" value="<?php if($comment_author_email) : echo $comment_author_email; else: echo 'Your Email'; endif; ?>" tabindex="2" class="tf" />
							</p>
							
							<p>
								<label for="url"><abbr title="Uniform Resource Identifier">URI</abbr></label>
								<input type="text" name="url" id="url" value="<?php if($comment_author_url) : echo $comment_author_url; else: echo 'Your Website'; endif; ?>" tabindex="3" class="tf" />
							</p>
							
							<?php endif; ?>
							
							<p>
								<label for="comment">Comments</label>
								<textarea name="comment" id="comment" rows="10" cols="10" tabindex="4" class="tf"></textarea>
							</p>
							
							<p>
								<label for="submit">&nbsp;</label>
								<input name="submit" type="submit" id="submit" tabindex="5" class="submit" value="Submit" />
								<?php comment_id_fields(); ?>
							</p>
							
							<?php do_action('comment_form', $post->ID); ?>
							
						</form>
						<?php endif; // If registration required and not logged in ?>
						
					</div>
					<?php endif; ?>
					
				</div>