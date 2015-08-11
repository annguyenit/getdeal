
<?php/*
<?php if ( comments_open() ) : ?>
<div class="comments">
  <?php if ( post_password_required() ) : ?>
  <p class="nopassword">
    <?php echo PASSWORD_PROTECT; ?>
  </p>
</div>
<!-- #comments -->
<?php  return; endif; ?>
<div id="comments">
  <?php if (have_comments()) : ?>
  <h3><?php printf(_n(__('1 Beoordeling','templatic'), __('%1$s Beoordeling','templatic'), get_comments_number()), number_format_i18n( get_comments_number() ), '' ); ?></h3>
  <div class="comment_list">
    <ol>
      <?php wp_list_comments(array('callback' => 'commentslist')); ?>
    </ol>
  </div>
  <?php endif; // end have_comments() ?>
</div>
<?php if ('open' == $post->comment_status) : ?>
<div id="respond">
  <h3><?php echo POST_REVIEW;?></h3>
  <div class="comment_form">
    <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
    <p class="comment_message"><?php echo YOU_MUST;?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php echo LOGGED_IN;?></a> <?php echo POST_COMMENT;?></p>
    <?php else : ?>
    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
      <?php if ( $user_ID ) : ?>
      <p class="comment_message"><?php echo LOGGED_AS;?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php echo LOGOUT;?></a></p>
      
      
      <p class="commpadd clearfix commform-textarea">
				<label for="comment"><small class="comment2"><?php echo REVIEW;?></small></label>
				<textarea name="comment" id="comment" cols="50" rows="7" tabindex="1"></textarea>
			</p>
     
            
      <?php else : ?>
       
      
       <p class="commpadd clearfix">
                <label for="author"><small class="author"><?php echo NAME;?> *</small></label>
                <input type="text" name="author" id="author" tabindex="2" value="Jouw Naam" onblur="if (this.value == '') {this.value = 'Jouw Naam';}" onfocus="if (this.value == 'Jouw Naam') {this.value = '';}"  />
            </p>
            
            <p class="commpadd clearfix">
                <label for="email"><small class="email2"><?php echo EMAIL;?> *</small></label>
                 <input type="text" name="email" id="email" tabindex="3" value="Email" onblur="if (this.value == '') {this.value = 'Email';}" onfocus="if (this.value == 'Email') {this.value = '';}" />
            </p>

            
            <p class="commpadd clearfix commform-textarea">
				<label for="comment"><small class="comment2"><?php echo REVIEW;?></small></label>
				<textarea name="comment" id="comment" cols="50" tabindex="1" rows="7" value="Reactie"  onblur="if (this.value.trim() == '') {this.value = 'Reactie';}" onfocus="if (this.value.trim() == 'Reactie') {this.value = '';}"> <?php echo "Reactie";?>
               </textarea>
			</p>
            
      
      
      <?php endif; ?>
      <div class="submit clear">
        <input name="submit" type="submit" id="submit" tabindex="5" value="<?php echo "Plaats Beoordeling";?>" />
        <p id="cancel-comment-reply">
          <?php cancel_comment_reply_link() ?>
        </p>
      </div>
      <div>
        <?php comment_id_fields(); ?>
        <?php do_action('comment_form', $post->ID); ?>
      </div>
    </form>
    <?php endif; // If registration required and not logged in ?>
  </div>
  <?php endif; // if you delete this the sky will fall on your head ?>
</div>
</div>
<?php endif; // end ! comments_open() ?>
<!-- #comments -->
*/?>