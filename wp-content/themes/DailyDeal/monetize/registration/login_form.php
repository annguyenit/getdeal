<h4>
  <?php 
			 if($_REQUEST['page']=='login' && $_REQUEST['page1']=='sign_up')
			{
				echo REGISTRATION_NOW_TEXT;
			}else
			{
				echo SIGN_IN_PAGE_TITLE;
			}
			 ?>
</h4>

<?php error_reporting(0);
global $General,$wpdb;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';

$errors = new WP_Error();

if ( isset($_GET['key']) )
	$action = 'resetpass';

// validate action so as to default to the login screen
if ( !in_array($action, array('logout', 'lostpassword', 'retrievepassword', 'resetpass', 'rp', 'register', 'login')) && false === has_filter('login_form_' . $action) )
	$action = 'login';

nocache_headers();

header('Content-Type: '.get_bloginfo('html_type').'; charset='.get_bloginfo('charset'));

if ( defined('RELOCATE') ) { // Move flag is set
	if ( isset( $_SERVER['PATH_INFO'] ) && ($_SERVER['PATH_INFO'] != $_SERVER['PHP_SELF']) )
		$_SERVER['PHP_SELF'] = str_replace( $_SERVER['PATH_INFO'], '', $_SERVER['PHP_SELF'] );

	$schema = ( isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ) ? 'https://' : 'http://';
	if ( dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) != site_url() )
		update_option('siteurl', dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) );
}

//Set a cookie now to see if they are supported by the browser.
setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
if ( SITECOOKIEPATH != COOKIEPATH )
	setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);

// allow plugins to override the default actions, and to add extra actions if they want
do_action('login_form_' . $action);

$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
switch ($action) {

case 'logout' :
	//check_admin_referer('log-out');
	wp_logout();

	$redirect_to =  $_SERVER['HTTP_REFERER'];
	//$redirect_to = site_url().'/?ptype=login&loggedout=true';
	if ( isset( $_REQUEST['redirect_to'] ) )
		$redirect_to = $_REQUEST['redirect_to'];

	wp_safe_redirect($redirect_to);
	exit();

break;

case 'lostpassword' :
case 'retrievepassword' :
	if ( $http_post ) {
		$errors = retrieve_password();
		$error_message = $errors->errors['invalid_email'][0];
		if ( !is_wp_error($errors) ) {
			global $General;
			wp_redirect($General->get_url_login(site_url()).'/?ptype=login&action=login&checkemail=confirm');
			exit();
		}
	}

	if ( isset($_GET['error']) && 'invalidkey' == $_GET['error'] ) $errors->add('invalidkey', __('Sorry, that key does not appear to be valid.'));

	do_action('lost_password');
	$message = '<div class="sucess_msg">Please enter your username or e-mail address. You will receive a new password via e-mail.</div>';
	//login_header(__('Lost Password'), '<p class="message">' . __('Please enter your username or e-mail address. You will receive a new password via e-mail.') . '</p>', $errors);

	$user_login = isset($_POST['user_login']) ? stripslashes($_POST['user_login']) : '';

break;

case 'resetpass' :
case 'rp' :
	$errors = reset_password($_GET['key'], $_GET['login']);
	global $General;
	if ( ! is_wp_error($errors) ) {
		wp_redirect($General->get_url_login(site_url()).'/?ptype=login&action=login&checkemail=newpass');
		exit();
	}

	wp_redirect($General->get_url_login(site_url()).'/?ptype=login&action=lostpassword&error=invalidkey');
	exit();

break;

case 'register' :
	if ( !get_option('users_can_register') ) {
		wp_redirect(site_url().'/?ptype=login&registration=disabled');
		exit();
	}

	$user_login = '';
	$user_email = '';
	if ( $http_post ) {
		//require_once( ABSPATH . WPINC . '/registration.php');

		$user_login = $_POST['user_login'];
		$user_email = $_POST['user_email'];
		$user_fname = $_POST['user_fname'];
		$user_lname = $_POST['user_lname'];		  
		$user_add1 = $_POST['user_add1'];
		$user_add2 = $_POST['user_add2'];
		$user_city = $_POST['user_city'];
		$user_state = $_POST['user_state'];
		$user_country = $_POST['user_country'];
		$user_postalcode = $_POST['user_postalcode'];
		$phone = $_POST['phone'];
		
		$errors = register_new_user($user_login, $user_email);
		if($General->allow_autologin_after_reg())
		{
			if ( !is_wp_error($errors) ) 
			{
			$_POST['log'] = $user_login;
			$_POST['pwd'] = $errors[1];
			$_POST['testcookie'] = 1;
			
			$secure_cookie = '';
			// If the user wants ssl but the session is not ssl, force a secure cookie.
			if ( !empty($_POST['log']) && !force_ssl_admin() ) {
				$user_name = sanitize_user($_POST['log']);
				if ( $user = get_userdatabylogin($user_name) ) {
					if ( get_user_option('use_ssl', $user->ID) ) {
						$secure_cookie = true;
						force_ssl_admin(true);
					}
				}
			}
		
			$redirect_to = $_REQUEST['reg_redirect_link'];
			if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
				$secure_cookie = false;
		
			$user = wp_signon('', $secure_cookie);
		
			$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['reg_redirect_link'] ) ? $_REQUEST['reg_redirect_link'] : '', $user);
		
			if ( !is_wp_error($user) ) 
			{
				wp_safe_redirect($redirect_to);
				exit();
			}
			exit();
		}
		
		}else
		{
			if ( !is_wp_error($errors) ) {
				global $General;
				wp_redirect($General->get_url_login(site_url()).'/?ptype=login&action=login&checkemail=registered');
				exit();
			}	
		}
		
	}

	//login_header(__('Registration Form'), '<p class="message register">' . __('Register For This Site') . '</p>', $errors);
break;

case 'login' :
default:
	$secure_cookie = '';

	// If the user wants ssl but the session is not ssl, force a secure cookie.
	if ( !empty($_POST['log']) && !force_ssl_admin() ) {
		$user_name = sanitize_user($_POST['log']);
		if ( $user = get_userdatabylogin($user_name) ) {
			if ( get_user_option('use_ssl', $user->ID) ) {
				$secure_cookie = true;
				force_ssl_admin(true);
			}
		}
	}
	} ?>
<?php

if ( $_REQUEST['logemsg']==1)
{
	echo "<p class=\"error_msg\"> ".INVALID_USER_PW_MSG." </p>";
}
if($_REQUEST['checkemail']=='confirm')
{
	echo '<p class="sucess_msg">'.PW_SEND_CONFIRM_MSG.'</p>';
}
?>
<div class="login_content"> <?php echo stripslashes(get_option('ptthemes_logoin_page_content'));?> </div>
<div class="login_form_box">
  <form name="loginform" id="loginform" action="<?php echo get_settings('home').'/index.php?ptype=login&amp;ptype1='.$_REQUEST['ptype']; ?>" method="post" >
    <div class="form_row clearfix">
      <label><?php echo USERNAME_TEXT; ?> <span class="indicates">*</span> </label>
      <input type="text" name="log" id="user_login" value="<?php echo esc_attr($user_login); ?>" size="20" class="textfield" />
      <span id="user_loginInfo"></span> </div>
    <div class="form_row clearfix">
      <label> <?php echo PASSWORD_TEXT; ?> <span class="indicates">*</span> </label>
      <input type="password" name="pwd" id="user_pass" class="textfield" value="" size="20"  />
      <span id="user_passInfo"></span> </div>
	
	

    <p class="rember">
      <input name="rememberme" type="checkbox" id="rememberme" value="forever" class="fl" />
      <?php echo REMEMBER_ON_COMPUTER_TEXT; ?> </p>
    <!-- <a  href="javascript:void(0);" onclick="chk_form_login();" class="highlight_button fl login" >Sign In</a>-->
	
	<div class="form_row clearfix">
    <input class="b_signin_n" type="submit" value="<?php echo SIGN_IN_BUTTON;?>"  name="submit" />
	</div>
	<div class="form_row clearfix">

			  <?php do_action('login_form'); ?>

	  </div>
  <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['HTTP_REFERER'];  ?>" />
    <input type="hidden" name="testcookie" value="1" />
    <a href="javascript:void(0);showhide_forgetpw();"><?php echo FORGOT_PW_TEXT;?></a>
    	
  </form>
  <?php 
  	
	if ( $_REQUEST['emsg']=='fw' && $_REQUEST['action'] != 'register'){
		echo "<p class=\"error_msg\"> ".INVALID_USER_FPW_MSG." </p>";
		$display_style = 'style="display:block;"';
	} else if($_REQUEST['action'] == 'register'){
		$display_style = 'style="display:none;"';
	}
	else{
		$display_style = 'style="display:none;"';
	}
	
  ?>
  
  <div id="lostpassword_form" <?php if($display_style == '') { echo $display_style; } else { echo 'style="display:none;"';} ?> >
    <h4><?php echo FORGOT_PW_TEXT;?></h4>
    <form name="lostpasswordform" id="lostpasswordform" action="<?php echo site_url().'/?ptype=login&amp;action=lostpassword'; ?>" method="post">
      <div class="form_row clearfix">
        <label> <?php echo USERNAME_EMAIL_TEXT; ?>: </label>
        <input type="text" name="user_login" id="user_login1" value="<?php echo esc_attr($user_login); ?>" size="20" class="textfield" />
        <?php do_action('lostpassword_form'); ?>
      </div>
	  <input type="hidden" name="pwdredirect_to" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
      <input type="submit" name="get_new_password" value="<?php echo GET_NEW_PW_TEXT;?>" class="b_signin_n " />
    </form>
  </div>
</div>
<script  type="text/javascript" >
function showhide_forgetpw()
{
	if(document.getElementById('lostpassword_form').style.display=='none')
	{
		document.getElementById('lostpassword_form').style.display = 'block';
	}else
	{
		document.getElementById('lostpassword_form').style.display = 'none';
	}	
}
</script>
