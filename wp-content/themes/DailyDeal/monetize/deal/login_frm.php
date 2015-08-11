<?php /*?><p class="note"><span class="indicates">*</span> <?php _e(INDICATES_MANDATORY_FIELDS_TEXT);?></p><?php */?>
<div class="address_info">   
<h4><?php 
			 if($_REQUEST['page']=='login' && $_REQUEST['page1']=='sign_up')
			{
				_e(REGISTRATION_NOW_TEXT);
			}else
			{
				_e(SIGN_IN_PAGE_TITLE);
			}
			 ?></h4>

<?php
if ( $_REQUEST['emsg']=='fw')
{
	echo "<p class=\"error_msg\"> ".INVALID_USER_FPW_MSG." </p>";
}else
if ( $_REQUEST['logemsg']==1)
{
	echo "<p class=\"error_msg\"> ".INVALID_USER_PW_MSG." </p>";
}
if($_REQUEST['checkemail']=='confirm')
{
	echo '<p class="sucess_msg">'.PW_SEND_CONFIRM_MSG.'</p>';
}
?>
<div class="login_content" >
<?php echo stripslashes(get_option('ptthemes_logoin_page_content'));?>
</div>

<div class="login_form_box">

<form name="loginform" id="loginform" action="<?php echo get_settings('home').'/index.php?ptype=login&amp;ptype1='.$_REQUEST['ptype']; ?>" method="post" >
<input type="hidden" name="redirect_to" value="<?php echo get_settings('home').'/?ptype='.$_GET['ptype'].'&did='.$_GET['did']; ?>" />
  <div class="form_row clearfix">
	<label><?php _e(USERNAME_TEXT) ?> <span class="indicates">*</span> </label>
	<input type="text" name="log" id="user_login" value="<?php echo esc_attr($user_login); ?>" size="20" class="textfield" />
	<span id="user_loginInfo"></span>
 </div> 
  <div class="form_row clearfix">
	<label>
	<?php _e(PASSWORD_TEXT) ?> <span class="indicates">*</span>
	</label>
	<input type="password" name="pwd" id="user_pass" class="textfield" value="" size="20"  />
	<span id="user_passInfo"></span>
  </div>
 <!-- <a  href="javascript:void(0);" onclick="chk_form_login();" class="highlight_button fl login" >Sign In</a>-->
   <div class="form_row clearfix">
  <input class="b_signin_n" type="submit" value="<?php _e(SIGN_IN_BUTTON);?>"  name="submit" />
  </div>
  <div class="form_row clearfix">
			<div class="b_facebook">
			  <?php do_action('login_form'); ?>
		</div>
	  </div>
	<div class="form_row clearfix"><label>
	</label><a href="javascript:void(0);showhide_forgetpw();"><?php echo FORGOT_PW_TEXT;?></a></div>
  <input type="hidden" name="testcookie" value="1" />
	  
</form>
 <div id="lostpassword_form" style="display:none;">
<h4><?php _e(FORGOT_PW_TEXT);?></h4> 
<form name="lostpasswordform" id="lostpasswordform" action="<?php echo site_url().'/?ptype=login&amp;action=lostpassword'; ?>" method="post">
   <div class="form_row clearfix"> <label>
  <?php _e(USERNAME_EMAIL_TEXT) ?>: </label>
  <input type="text" name="user_login" id="user_login1" value="<?php echo esc_attr($user_login); ?>" size="20" class="textfield" />
  <?php do_action('lostpassword_form'); ?>
  </div>
  <input type="hidden" name="pwdredirect_to" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
  
  <input type="submit" name="get_new_password" value="<?php _e(GET_NEW_PW_TEXT);?>" class="b_signin_n " />


</form>
</div>
</div>
<script  type="text/javascript" >
function showhide_forgetpw()
{
	if(document.getElementById('lostpassword_form').style.display=='none')
	{
		document.getElementById('lostpassword_form').style.display = ''
	}else
	{
		document.getElementById('lostpassword_form').style.display = 'none';
	}	
}
</script>
</div>
