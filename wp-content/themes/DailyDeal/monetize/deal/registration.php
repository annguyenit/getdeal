<?php
session_start();
ob_start();?>
<?php get_header(); ?>


				
				
				<form id="register_frm" name="register_frm" action="<?php echo site_url('/?ptype=registration');?>" method="post">
                    <input type="hidden" name="did" value="<?php echo $did;?>" />
                   		<div class="address_info">                    
						<h4><?php echo REGISTRATION;?></h4>
						<div class="form_row clearfix"><label><?php echo POST_DEAL_USER_NAME;?><span>*</span></label><input type="text" class="textfield" id="user_fname" name="user_fname" value="<?php echo $_SESSION['deal_info']['user_fname'];?>"><span id="user_fname_Info" class="error"></span></div>
    					<div class="form_row clearfix"><label><?php echo POST_DEAL_EMAIL_TEXT;?><span>*</span></label> <input type="text" class="textfield" id="user_email" name="user_email" value="<?php echo $_SESSION['deal_info']['user_email'];?>"><span id="user_emailInfo"  class="error"></span></div>
          				<input type="submit" id="submit" value="<?php echo POST_DEAL_BUTTON_TEXT; ?>"/>
						</div>
				</form>
    <script type="text/javascript" src="<?php echo TT_INCLUDES_FOLDER_URL; ?>deal/registration_validation.js"></script>