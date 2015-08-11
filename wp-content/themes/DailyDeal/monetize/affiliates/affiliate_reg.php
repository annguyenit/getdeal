<?php
global $Cart,$General,$wpdb;
$userInfo = $General->getLoginUserInfo();
$_SESSION['checkout_as_guest'] = '';

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
 * Handles registering a new user.
 *
 * @param string $user_login User's username for logging in
 * @param string $user_email User's email address to send password and add
 * @return int|WP_Error Either user's ID or error on failure.
 */
function register_new_user($user_login, $user_email) {
	global $wpdb,$General;
	$errors = new WP_Error();

	$user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );

	// Check the username
	if ( $user_login == '' )
		$errors->add('empty_username', __('ERROR: Please enter a username.'));
	elseif ( !validate_username( $user_login ) ) {
		$errors->add('invalid_username', __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.'));
		$user_login = '';
	} elseif ( username_exists( $user_login ) )
		$errors->add('username_exists', __('<strong>ERROR</strong>: This username is already registered, please choose another one.'));

	// Check the e-mail address
	if ($user_email == '') {
		$errors->add('empty_email', __('<strong>ERROR</strong>: Please type your e-mail address.'));
	} elseif ( !is_email( $user_email ) ) {
		$errors->add('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.'));
		$user_email = '';
	} elseif ( email_exists( $user_email ) )
		$errors->add('email_exists', __('<strong>ERROR</strong>: This email is already registered, please choose another one.'));

	do_action('register_post', $user_login, $user_email, $errors);

	$errors = apply_filters( 'registration_errors', $errors );
	foreach($errors as $errorsObj)
	{
		foreach($errorsObj as $key=>$val)
		{
			for($i=0;$i<count($val);$i++)
			{
				echo "<div class=error_msg>".$val[$i].'</div>';	
			}
		} 
	}
	

	if ( $errors->get_error_code() )
		return $errors;


	$user_pass = wp_generate_password(12,false);
	$user_id = wp_create_user( $user_login, $user_pass, $user_email );
	
	$user_add1 = $_POST['user_add1'];
	$user_add2 = $_POST['user_add2'];
	$user_city = $_POST['user_city'];
	$user_state = $_POST['user_state'];
	$user_country = $_POST['user_country'];
	$user_postalcode = $_POST['user_postalcode'];
	$is_affiliate = $_POST['is_affiliate'];
	$user_address_info = array(
						"user_add1"		=> $user_add1,
						"user_add2"		=> $user_add2,
						"user_city"		=> $user_city,
						"user_state"	=> $user_state,
						"user_country"	=> $user_country,
						"user_postalcode"=> $user_postalcode,
						);
	update_usermeta($user_id, 'user_address_info', $user_address_info); // User Address Information Here
	$userName = $_POST['user_fname'];
	$updateUsersql = "update $wpdb->users set user_nicename=\"$userName\", display_name=\"$userName\"  where ID=\"$user_id\"";
	$wpdb->query($updateUsersql);
	
	if ( !$user_id ) {
		$errors->add('registerfail', sprintf(__('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !'), get_option('admin_email')));
		return $errors;
	}

	if ( $user_id ) 
	{
			if($is_affiliate)
			{
				//$user_role = get_usermeta($user_id,'wp_capabilities');
				$user_role['affiliate'] = 1;
				global $wpdb;
				$wp_capabilities = $wpdb->prefix .'capabilities';
				update_usermeta($user_id, $wp_capabilities, $user_role);
			}
		
		////AFFILIATE END///
		
		//wp_new_user_notification($user_id, $user_pass);
		///////REGISTRATION EMAIL START//////
		global $General,$upload_folder_path;
		$fromEmail = $General->get_site_emailId();
		$fromEmailName = $General->get_site_emailName();
		$store_name = get_option('blogname');
		$order_info = get_order_detailinfo_tableformat($orderInfoArray,1);
	
		$client_message = $filecontent_arr2[1];
		$subject = get_option('registration_success_aff_email_subject');
		$client_message = get_option('registration_success_aff_email_content');
		/////////////customer email//////////////
		$search_array = array('[#$user_name#]','[#$user_login#]','[#$user_password#]','[#$store_name#]');
		$replace_array = array($_POST['user_fname'],$user_login,$user_pass,$store_name);
		$client_message = str_replace($search_array,$replace_array,$client_message);	
		$General->sendEmail($fromEmail,$fromEmailName,$user_email,$userName,$subject,$client_message,$extra='');///To clidne email
		//////REGISTRATION EMAIL END////////
	}
	return array($user_id,$user_pass);
}			
?>
<?php 

$affiliate_login_content_top = get_option('affiliate_login_content_top');
$affiliate_login_content_bottom = get_option('affiliate_login_content_bottom');
$affiliate_terms_conditions = get_option('affiliate_terms_conditions');
?>
  
<?php get_header(); ?>

<div id="wrapper"  class="clearfix">
<div id="page" class="container_16 clearfix " > 
	<div id="content" class="content clearfix content_full affiliate_reg">
		<div class="login_form_l">
	    <h1 class="singleh1"><?php _e(AFFILIATE_LOGIN_PAGE_TITLE); ?></h1>

<?php
if($affiliate_login_content_top)
{
	echo '<p>'.$affiliate_login_content_top.'</p>';
}
?>
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
case 'register' :
	if ( !get_option('users_can_register') ) {
		wp_redirect(site_url().'/?ptype=affiliate&registration=disabled');
		exit();
	}

	$user_login = '';
	$user_email = '';
	if ( $http_post ) {
		//require_once( ABSPATH . WPINC . '/registration.php');

		$user_login = $_POST['user_email'];
		$user_email = $_POST['user_email'];
		$user_fname = $_POST['user_fname'];
		$user_lname = $_POST['user_lname'];		  
		$user_add1 = $_POST['user_add1'];
		$user_add2 = $_POST['user_add2'];
		$user_city = $_POST['user_city'];
		$user_state = $_POST['user_state'];
		$user_country = $_POST['user_country'];
		$user_postalcode = $_POST['user_postalcode'];
		
		$errors = register_new_user($user_login, $user_email);
		
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
if($General->get_loginpage_top_statement())
{
	$topcontent = $General->get_loginpage_top_statement();
	$store_name = get_option('blogname');
	$search_array = array('[#$store_name#]');
	$replace_array = array($store_name);
	$instruction = str_replace($search_array,$replace_array,$topcontent);
}
?>
		<p><span class="forgot_password fr"> <?php echo ALREADY_MEMBER_TEXT;?><a href="<?php echo site_url();?>/?ptype=affiliate"><?php echo ALREADY_MEMBER_LINK;?></a></span></p>
        <div class="clearfix"></div>
         <form name="registerform" id="registerform" action="<?php echo site_url().'/?ptype=affiliate&amp;action=register&amp;type=reg'; ?>" method="post">
        <?php
		if(strstr($_SESSION['redirect_page'],'ptype=checkout'))
		{
			global $General;
			$reg_redirect_link = $General->get_ssl_normal_url(site_url()).'/?ptype=checkout';
		}else
		{
			$reg_redirect_link = site_url().'/?ptype=affiliate&action=register';
		}
		?>
        <input type="hidden" name="reg_redirect_link" value="<?php echo $reg_redirect_link;?>" />
        <div class="form form_col_2  ">
          <p class="mandatory"> <span class="indicates">*</span> Indicates mandatory fields</p>
			<table>
            	<tr>
                	<td>
            <div class="form_row clearfix">
              <label>
              <?php echo USERNAME_TEXT; ?>
              <span class="indicates">*</span></label>
              <input type="text" name="user_login" id="user_login1reg" class="textfield" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="20"/>
            </div>
            <div class="form_row clearfix">
              <label>
              <?php echo EMAIL_TEXT; ?>
              <span class="indicates">*</span></label>
              <input type="text" name="user_email" id="user_email" class="textfield" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" />
            </div>
                    </td>
                	<td>
			<div class="form_row clearfix">
              <label>
              <?php echo FIRST_NAME_TEXT; ?>
              <span class="indicates">*</span></label>
              <input type="text" name="user_fname" id="user_fname" class="textfield" value="<?php echo esc_attr(stripslashes($user_fname)); ?>" size="25"  />
            </div>
            <div class="form_row clearfix">
              <label>
              <?php echo LAST_NAME_TEXT; ?>
              </label>
              <input type="text" name="user_lname" id="user_lname" class="textfield" value="<?php echo esc_attr(stripslashes($user_lname)); ?>" size="25"  />
            </div>
                    </td>
                </tr>
            </table>

            <div class="fix"></div>
              <div class="form_row clearfix">
              <label>
              <input type="checkbox" name="termandconditons" id="termandconditons">&nbsp;
			  <?php 
			if($affiliate_terms_conditions)
			{
				$term_and_conditions = stripslashes($affiliate_terms_conditions);
			}else
			{
				 $term_and_conditions = TERMS_CONDITIONS_TITLE;
			}
			 $store_name = get_option('blogname');
			$search_array = array('[#$store_name#]');
			$replace_array = array($store_name);
			$term_and_conditions = str_replace($search_array,$replace_array,$term_and_conditions);	
			  _e($term_and_conditions) ?>               
              </label>
            </div>
            <div class="fix"></div>
           
            <input type="hidden" name="is_affiliate" value="1" />
            <?php do_action('register_form'); ?>
            <div id="reg_passmail">
              <?php echo AFFILIATE_LOGIN_REG_PAGE_INSTRUCTION; ?>
            </div>
           <!-- <a  href="javascript:void(0);" onclick="return chk_form_reg();" class="highlight_button fr " >Register Now </a>-->
           <div class="form_row clearfix">
           <input type="submit" name="registernow" value="<?php echo CREATE_ACCOUNT_BUTTON; ?>" onClick="return chk_form_reg();" class="b_signin_n" />
           </div>
           
        </div>
           </form>
        <script  type="text/javascript" >
function chk_form_reg()
{
	if(document.getElementById('user_login1reg').value == '')
	{
		alert("<?php _e('Please enter '.USERNAME_TEXT) ?>");
		document.getElementById('user_login1reg').focus();
		return false;
	}
	if(document.getElementById('user_email').value == '')
	{
		alert("<?php _e('Please enter '.EMAIL_TEXT) ?>");
		document.getElementById('user_email').focus();
		return false;
	}
	if(document.getElementById('user_fname').value == '')
	{
		alert("<?php _e('Please enter '.FIRST_NAME_TEXT) ?>");
		document.getElementById('user_fname').focus();
		return false;
	}
	if(document.getElementById('termandconditons').checked)
	{
		
	}else
	{
		alert("<?php _e(AFF_REGISTRATION_JS_MSG) ?>");
		document.getElementById('termandconditons').focus();
		return false;
	}
	document.registerform.submit();
}

try{document.getElementById('user_login').focus();}catch(e){}
</script>
       
     	<?php
        if($affiliate_login_content_bottom)
		{
			echo $affiliate_login_content_bottom;
		}
		?>
    	</div>
    </div>
    <!-- content-in #end -->
</div> <!-- page #end -->
</div><!-- wrapper #end -->
<?php get_footer(); ?>