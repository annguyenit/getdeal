<?php
define('TEMPL_NOTIFICATION_MODULE', __("Manage Notifications",'templatic'));
define('TEMPL_NOTIFICATION_CURRENT_VERSION', '1.0.0');
define('TEMPL_NOTIFICATION_LOG_PATH','http://templatic.com/updates/monetize/notifications/notifications_change_log.txt');
define('TEMPL_NOTIFICATION_ZIP_FOLDER_PATH','http://templatic.com/updates/monetize/notifications/notifications.zip');
define('TT_NOTIFICATION_FOLDER','notifications');
define('TT_NOTIFICATION_MODULES_PATH',TT_MODULES_FOLDER_PATH . TT_NOTIFICATION_FOLDER.'/');

//----------------------------------------------
     //MODULE AUTO UPDATE START//
//----------------------------------------------
add_action('templ_module_auto_update','templ_module_auto_update_notification_fun');
function templ_module_auto_update_notification_fun()
{
	$curversion = TEMPL_NOTIFICATION_CURRENT_VERSION;
	$liveversion = tmpl_current_framework_version(TEMPL_NOTIFICATION_LOG_PATH);
	$is_update = templ_is_updated( $curversion, $liveversion);
	if($is_update)
	{
?>
<table border="0" cellpadding="0" cellspacing="0" style="border:0px; padding:10px 0px;">
<tr>
<td class="module"><h3><?php echo TEMPL_NOTIFICATION_MODULE;?></h3></td>
</tr>
<tr>
<td>
<form method="post"  name="framework_update" id="framework_update">
<input type="hidden" name="action" value="<?php echo TT_NOTIFICATION_FOLDER;?>" />
<input type="hidden" name="zip" value="<?php echo TEMPL_NOTIFICATION_ZIP_FOLDER_PATH;?>" />
<input type="hidden" name="log" value="<?php echo TEMPL_NOTIFICATION_LOG_PATH;?>" />
<input type="hidden" name="path" value="<?php echo TT_NOTIFICATION_MODULES_PATH;?>" />
<?php wp_nonce_field('update-options'); ?>

<?php echo sprintf(__('<h4>A new version of Manage Notifications Module is available.</h4>
<p>This updater will collect a file from the templatic.com server. It will download and extract the files to your current theme&prime;s functions folder. 
<br />We recommend backing up your theme files before updating. Only upgrade related module files if necessary.
<br />If you are facing any problem in auto updating the framework, then please download the latest version of the theme from members area and then just overwrite the "<b>%s</b>" folder.
<br /><br />&rArr; Your version: %s
<br />&rArr; Current Version: %s </p>','templatic'),TT_NOTIFICATION_MODULES_PATH,$curversion,$liveversion); ?>

<input type="submit" class="button" value="<?php _e('Update','templatic');?>" onclick="document.getElementById('framework_upgrade_process_span_id').style.display=''" />
</form>
</td>
</tr>
<tr><td style="border-bottom:5px solid #dedede;">&nbsp;</td></tr>
</table>
<?php
	}
}
//----------------------------------------------
     //MODULE AUTO UPDATE END//
//----------------------------------------------

include_once(TT_NOTIFICATION_MODULES_PATH . 'notification_options.php');

/////////admin menu settings start////////////////
add_action('templ_admin_menu', 'notification_add_admin_menu');
function notification_add_admin_menu()
{
	add_submenu_page('templatic_wp_admin_menu', TEMPL_NOTIFICATION_MODULE, TEMPL_NOTIFICATION_MODULE, TEMPL_ACCESS_USER, 'notification', 'notification');
}

function notification()
{
	include_once(TT_NOTIFICATION_MODULES_PATH . 'admin_notification.php');
}
function legend_notification(){
	$legend_display = '<h4>Legend : </h4>';
	$legend_display .= '<p style="line-height:30px;width:100%;"><label style="float:left;width:180px;">[#to_name#]</label> : Name of the recipient<br />
	<label style="float:left;width:180px;">[#deal_details#]</label> : Details of deal as entered by the seller<br />
	<label style="float:left;width:180px;">[#seller_details#]</label> : Details of seller as filled in by the seller<br />
	<label style="float:left;width:180px;">[#site_name#]</label> : Site name as you provided in General Settings<br />
	<label style="float:left;width:180px;">[#site_login_url#]</label> : Site\'s login page URL<br />
	<label style="float:left;width:180px;">[#user_login#]</label> : Recipient\'s login ID<br />
	<label style="float:left;width:180px;">[#user_password#]</label> : Recepient\'s password<br />
	<label style="float:left;width:180px;">[#site_login_url_link#]</label> : Site login page link<br />
	<label style="float:left;width:180px;">[#deal_link#]</label> : URL of the deal detail page<br />
	<label style="float:left;width:180px;">[#deal_title#]</label> : Title of the deal<br />
	<label style="float:left;width:180px;">[#post_date#]</label> : Date of post<br />
	<label style="float:left;width:180px;">[#transaction_details#]</label> : Transaction details of the deal.<br />
	<label style="float:left;width:180px;">[#frnd_subject#]</label> : Subject for the email to the recipient.<br />
	<label style="float:left;width:180px;">[#frnd_comments#]</label> : Comment for the email to the recipient.<br />
	<label style="float:left;width:180px;">[#your_name#]</label> : Sender\'s name<br />
	<label style="float:left;width:180px;">[#submited_information_link#]</label> : URL of the deal details page<br />
	<label style="float:left;width:180px;">[#payable_amt#]</label> : Payable amount<br />
	<label style="float:left;width:180px;">[#bank_name#]</label> : Bank name<br />
	<label style="float:left;width:180px;">[#account_number#]</label> : Account number<br />
	<label style="float:left;width:180px;">[#submition_Id#]</label> : Submission ID</p>';
	return $legend_display;
}
/////////admin menu settings end////////////////
?>