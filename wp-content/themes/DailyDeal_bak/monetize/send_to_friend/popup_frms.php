<script type='text/javascript' src='<?php bloginfo('template_directory'); ?>/monetize/send_to_friend/jquery.simplemodal.js'></script>
<script type='text/javascript' src='<?php bloginfo('template_directory'); ?>/monetize/send_to_friend/basic.js'></script>
<?php
if ( force_ssl_admin() && !is_ssl() ) {
		if ( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ) {
			$request_uri = preg_replace('|^http://|', 'https://', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			
		} else { 
			$request_uri = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		}
	}
?>
<div id="basic-modal-content" class="clearfix" style="display:none;">
<form name="send_to_frnd" id="send_to_frnd" action="<?php echo get_option('siteurl')."/";?>" method="post">
 
<input type="hidden" id="deal_id" name="deal_id" value="<?php	echo $home_deal_id;?>"/>
<input type="hidden" id="request_uri" name="request_uri" value="<?php echo $request_uri;?>"/>
<input type="hidden" id="link_url" name="link_url" value="<?php	the_permalink();?>"/>
<input type="hidden" id="send_to_Frnd_pid" name="pid" />
<input type="hidden" name="sendact" value="email_frnd" />
	<h3><?php echo SEND_TO_FRIEND;?></h3>
	
			<p id="reply_send_success" class="sucess_msg" style="display:none;"></p>
		
			<div class="row clearfix" ><label><?php echo FRIEND_NAME;?> : <span>*</span></label> <input name="to_name" id="to_name" type="text"  /><span id="to_nameInfo"></span></div>
	
		 	<div class="row  clearfix" ><label> <?php echo FRIEND_EMAIL;?> : <span>*</span></label> <input name="to_email" id="to_email" type="text"  /><span id="to_emailInfo"></span></div>
		
			<div class="row  clearfix" ><label><?php echo YOUR_NAME;?> : <span>*</span></label> <input name="yourname" id="yourname" type="text"  /><span id="yournameInfo"></span></div>
		
		 	<div class="row  clearfix" ><label> <?php echo YOUR_EMAIL;?> : <span>*</span></label> <input name="youremail" id="youremail" type="text"  /><span id="youremailInfo"></span></div>
		
			<div class="row  clearfix" ><label><?php echo SUBJECT;?> : <span>*</span></label> <input name="frnd_subject" value="<?php echo __('Over.. ');?>" id="frnd_subject" type="text"  /></div>
		

			<div class="row textarea_row  clearfix" ><label><?php echo COMMENTS;?> : <span>*</span></label> <textarea name="frnd_comments" id="frnd_comments" cols="10" rows="5" ><?php echo SEND_DESC; ?></textarea></div>

			<div class="row  clearfix" >
				<input name="Send" type="submit" value="<?php echo SEND_TEXT;?> " class="button " /></div>
		
</form>
</div>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/monetize/send_to_friend/email_frnd_validation.js"></script>
<!-- here -->