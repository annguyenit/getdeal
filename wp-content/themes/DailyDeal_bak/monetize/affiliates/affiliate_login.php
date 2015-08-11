<?php
global $Cart,$General,$wpdb;
$userInfo = $General->getLoginUserInfo();
$_SESSION['checkout_as_guest'] = '';
if($userInfo && $_GET['action'] != 'logout')
{
	wp_redirect(site_url().'/?ptype=myaccount');
	exit;
}
require( 'wp-load.php' );
require(ABSPATH.'wp-includes/registration.php');

// Redirect to https login if forced to use SSL
if ( force_ssl_admin() && !is_ssl() ) {
	if ( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ) {
		wp_redirect(preg_replace('|^http://|', 'https://', $_SERVER['REQUEST_URI']));
		exit();
	} else {
		wp_redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		exit();
	}
}

	$message = apply_filters('login_message', $message);
	if ( !empty( $message ) ) echo $message . "\n";


/**
 * Handles sending password retrieval email to user.
 *
 * @uses $wpdb WordPress Database object
 *
 * @return bool|WP_Error True: when finish. WP_Error on error
 */
function retrieve_password() {
	global $wpdb;

	$errors = new WP_Error();

	if ( empty( $_POST['user_login'] ) && empty( $_POST['user_email'] ) )
		$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.'));

	if ( strpos($_POST['user_login'], '@') ) {
		$user_data = get_user_by_email(trim($_POST['user_login']));
		if ( empty($user_data) )
			$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
	} else {
		$login = trim($_POST['user_login']);
		$user_data = get_userdatabylogin($login);
	}

	do_action('lostpassword_post');

	if ( $errors->get_error_code() )
		return $errors;

	if ( !$user_data ) {
		$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.'));
		return $errors;
	}

	// redefining user_login ensures we return the right case in the email
	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	do_action('retreive_password', $user_login);  // Misspelled and deprecated
	do_action('retrieve_password', $user_login);

	$allow = apply_filters('allow_password_reset', true, $user_data->ID);

	if ( ! $allow )
		return new WP_Error('no_password_reset', __('Password reset is not allowed for this user'));
	else if ( is_wp_error($allow) )
		return $allow;

	$user_email = $_POST['user_email'];
	$user_login = $_POST['user_login'];
	$user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->users WHERE user_login = %s", $user_login));
	if ( empty( $user ) )
		return new WP_Error('invalid_key', __('Invalid key'));
		
	$new_pass = wp_generate_password(12,false);

	do_action('password_reset', $user, $new_pass);

	wp_set_password($new_pass, $user->ID);
	update_usermeta($user->ID, 'default_password_nag', true); //Set up the Password change nag.
	$message  = sprintf(__('Username: %s'), $user->user_login) . "\r\n";
	$message .= sprintf(__('Password: %s'), $new_pass) . "\r\n";
	$message .= site_url().'/?ptype=affiliate' . "\r\n";

	$title = sprintf(__('[%s] Your new password'), get_option('blogname'));

	$title = apply_filters('password_reset_title', $title);
	$message = apply_filters('password_reset_message', $message, $new_pass);
	if ( $message && !wp_mail($user_email, $title, $message) )
		die('<p>' . __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') . '</p>');

	return true;
}

/**
 * Handles resetting the user's password.
 *
 * @uses $wpdb WordPress Database object
 *
 * @param string $key Hash to validate sending user's password
 * @return bool|WP_Error
 */
?>
<?php //get_header(); 
$affiliate_settings = get_option('affiliate_settings');
$affiliate_login_content_top = $affiliate_settings['affiliate_login_content_top'];
$affiliate_login_content_bottom = $affiliate_settings['affiliate_login_content_bottom'];
?>
<?php get_header(); ?>

<div id="wrapper"  class="clearfix">
<div id="page" class="container_16 clearfix">
	<div id="content" class="content clearfix content_full affiliate_reg">
     	<div class="login_form_l">

        <h1 class="singleh1"><?php echo AFFILIATE_LOGIN_PAGE_TITLE; ?></h1>

        <?php
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
	//$redirect_to = site_url().'/?ptype=affiliate&loggedout=true';
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
			wp_redirect(site_url().'/?ptype=affiliate&amp;action=login&amp;checkemail=confirm');
			exit();
		}
	}

	if ( isset($_GET['error']) && 'invalidkey' == $_GET['error'] ) $errors->add('invalidkey', __('Sorry, that key does not appear to be valid.'));

	do_action('lost_password');
	$message = '<div class="sucess_msg">'.AFFILIATE_LOGIN_FORGETPW_MSG.'</div>';
	//login_header(__('Lost Password'), '<p class="message">' . __('Please enter your username or e-mail address. You will receive a new password via e-mail.') . '</p>', $errors);

	$user_login = isset($_POST['user_login']) ? stripslashes($_POST['user_login']) : '';

break;

case 'resetpass' :
case 'rp' :
	$errors = reset_password($_GET['key'], $_GET['login']);

	if ( ! is_wp_error($errors) ) {
		wp_redirect(site_url().'/?ptype=affiliate&amp;action=login&amp;checkemail=newpass');
		exit();
	}

	wp_redirect(site_url().'/?ptype=affiliate&amp;action=lostpassword&amp;error=invalidkey');
	exit();

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

	if ( isset( $_REQUEST['redirect_to'] ) ) {
		$redirect_to = $_REQUEST['redirect_to'];
		// Redirect to https if user wants ssl
		if ( $secure_cookie && false !== strpos($redirect_to, 'wp-admin') )
			$redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
	} else {
		$redirect_to = admin_url();
	}

	if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
		$secure_cookie = false;

	$user = wp_signon('', $secure_cookie);

	$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);

	if ( !is_wp_error($user) ) {
		// If the user can't edit posts, send them to their profile.
		if ( !$user->has_cap('edit_posts') && ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' || $redirect_to == admin_url() ) )
			$redirect_to = admin_url('profile.php');
		wp_safe_redirect($redirect_to);
		exit();
	}

	$errors = $user;
	// Clear errors if loggedout is set.
	if ( !empty($_GET['loggedout']) )
		$errors = new WP_Error();

	// If cookies are disabled we can't log in even with a valid user+pass
	if ( isset($_POST['testcookie']) && empty($_COOKIE[TEST_COOKIE]) )
		$errors->add('test_cookie', __("<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a> to use WordPress."));

	// Some parts of this script use the main login form to display a message
	if( isset($_GET['loggedout']) && TRUE == $_GET['loggedout'] )
	{
		$successmsg = '<div class="sucess_msg">'.AFFILIATE_LOGIN_LOGOUT_MSG.'</div>';
	}
	elseif( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )
	{
		$successmsg = AFFILIATE_LOGIN_REG_NOT_ALLOW_MSG;
	}
	elseif( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )
	{
		$successmsg = AFFILIATE_LOGIN_CONFIRM_LINK_MSG;
	}
	elseif( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )
	{
		$successmsg = AFFILIATE_LOGIN_NEWPW_EMAIL_MSG;
	}
	elseif( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )
	{
		$successmsg = AFFILIATE_LOGIN_REG_COMPLETED_MSG;
	}

echo "<p style=\"color:green\">".$successmsg.'</p>';	
//	login_header(__('Log In'), '', $errors);
?>
        <script type="text/javascript" >
<?php if ( $user_login ) { ?>
setTimeout( function(){ try{
d = document.getElementById('user_pass');
d.value = '';
d.focus();
} catch(e){}
}, 200);
<?php } else { ?>
try{document.getElementById('user_login').focus();}catch(e){}
<?php } ?>
</script>
        <?php

break;
} // end action switch
?>
        <?php
if($error_message)
{
	echo "<div class=error_msg>".$error_message.'</div>';
}
if($message)
{
	echo "".$message.'';
}
?>
        <div class="fr"><p><span class="forgot_password"><?php _e(NEW_USER_REGISTRATION_TEXT);?><a href="<?php echo site_url().'/?ptype=affiliate&amp;type=reg';?>"><?php _e(NEW_USER_REGISTRATION_LINK);?></a></span></p></div>
        <div class="clearfix"></div>
        <div class="form_col_1  ">
          <div class="form login_form" >
            <h4 style="padding-top:15px;"> <?php _e('Sign In'); ?> </h4>
            <?php
	if ( isset($_POST['log']) )
	{
		if( 'incorrect_password' == $errors->get_error_code() || 'empty_password' == $errors->get_error_code() || 'invalid_username' == $errors->get_error_code() )
		{
			echo "<div class=\"error_msg\"> Invalid Username/Password. </div>";
		}
	}
?>
            <form name="loginform" id="loginform" action="<?php echo site_url().'/?ptype=affiliate'; ?>" method="post" >
              <div class="form_row">
                <label>
                <?php _e('Username') ?>
                </label>
                <input type="text" name="log" id="user_login" value="" size="20" class="textfield"  />
              </div>
              <div class="form_row">
                <label>
                <?php _e('Password') ?>
                </label>
                <input type="password" name="pwd" id="user_pass" class="textfield" value="" size="20" />
              </div>
              <?php do_action('login_form'); ?>
              <p class="forgetmenot">
                <input name="rememberme" type="checkbox" id="rememberme" value="forever" class="fl" />
                <?php esc_attr_e('Remember me on this computer'); ?>
              </p>
             <!-- <a  href="javascript:void(0);" onclick="chk_form_login();" class="highlight_button fl login" >Sign In</a>-->
             <div class="form_row clearfix">
              <input class="b_signin_n login" type="submit" value="<?php _e('Sign In'); ?>" onclick="return chk_form_login();"  name="submit" />
             </div>
        <?php
		if(strstr($_SESSION['redirect_page'],'ptype=checkout'))
		{
			global $General;
			$login_redirect_link = $General->get_ssl_normal_url(site_url()).'/?ptype=checkout';
			//session_unregister(redirect_page);
		}else
		{
			$login_redirect_link = site_url().'/?ptype=affiliate&amp;action=register';
		}
		?>
              <input type="hidden" name="redirect_to" value="<?php echo $login_redirect_link; ?>" />  
              <span class="forgot_password"> <a href="javascript:void(0);showhide_forgetpw();"><?php _e(FORGET_PW_TEXT);?></a></span>
              <input type="hidden" name="testcookie" value="1" />
              
            </form>
          </div>
          <!-- login form #end -->
<script type="text/javascript" >
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
function chk_form_login()
{
	if(document.getElementById('user_login').value=='')
	{
		alert('Please enter <?php _e('Username') ?>');
		document.getElementById('user_login').focus();
		return false;
	}
	if(document.getElementById('user_pass').value=='')
	{
		alert('Please enter <?php _e('Password') ?>');
		document.getElementById('user_pass').focus();
		return false;
	}
	document.loginform.submit();
}
</script>
          <div class="lostpassword_form" id="lostpassword_form" style="display:none;">
            <h3><?php _e(FORGOT_PASSWORD_TEXT); ?></h3>
            <form name="lostpasswordform" id="lostpasswordform" action="<?php echo site_url().'/?ptype=affiliate&amp;action=lostpassword'; ?>" method="post">
              <label>
              <?php _e('Username or E-mail') ?> :
              </label>
              <input type="text" name="user_login" id="user_login1" value="" size="20" class="lostpass_textfield" />
              <?php do_action('lostpassword_form'); ?> <br />
             <!-- <a  href="javascript:void(0);" onclick="document.lostpasswordform.submit();" class="highlight_button fl " >Get New Password</a>-->
              <input type="submit" name="get_new_password" value=" <?php _e('Get New Password') ?> " class="highlight_input_btn" />
            </form>
          </div>
        </div>
        
<script type="text/javascript">
try{document.getElementById('user_login').focus();}catch(e){}
</script>
 
        </div>
    </div>
    <!-- content-in #end -->
	</div> <!-- page #end -->
</div><!-- wrapper #end -->
  <!-- container 16-->
<?php get_footer(); ?>

	 
	 