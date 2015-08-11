<?php
function pt_get_captch()
{
	global $captchaimagepath;
	$captchaimagepath = get_bloginfo('template_url').'/library/functions/captcha/';
?>
<h4><?php echo CAPTCHA_TITLE_TEXT; ?></h4>
<div class="form_row clearfix">
<label><?php _e(CAPTCHA,'templatic'); ?> <span class="indicates">*</span></label>
<input type="text" name="captcha"  class="textfield textfield_m" /> 
<img src="<?php bloginfo('template_url');?>/library/functions/captcha/captcha.php" alt="captcha image" class="captcha_img" />
<?php if($_REQUEST['emsg']=='captch'){echo '<span class="message_error2" id="category_span">'.__('Please enter valid text as you shown in captcha.','templatic').'</span>';}?>
<small><?php _e('Enter the text as you see in the image.','templatic');?></small>
</div>
<?php
}
function pt_check_captch_cond()
{
	if($_SESSION["captcha"]==$_POST["captcha"])
	{
		return true;
	}
	else
	{
		return false;
	}	
}
?>