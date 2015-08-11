<?php 
add_action('admin_menu', 'mp_fb_poster_option_page');

function mp_fb_poster_option_page() {
    add_options_page('Facebook Deals Poster Options', 'Facebook Deals Poster Options', 'manage_options', 'facebook-deal-poster-options', 'mp_fb_poster_setting_page');
}
add_action('admin_init','mp_fb_poster_setting');

function mp_fb_poster_setting() {
    register_setting('mp-fb-deal-poster','mp-getdeal-fb-app-key');
    register_setting('mp-fb-deal-poster','mp-getdeal-fb-app-secret');    
    register_setting('mp-fb-deal-poster','mp-getdeal-fanpage-id');    
	register_setting('mp-fb-deal-poster','mp-enable-fb-deal-poster');    
	register_setting('mp-fb-deal-poster','mp-fb-deal-poster-time');    	
}

function mp_fb_poster_setting_page() {
	global $facebook;
	
	if(isset($_GET['fblogout']) && $_GET['fblogout'] == 1)
	{		
		update_option('mp-getdeal-userid','');
		update_option('mp-getdeal-access-token','');
		//setcookie("fbs_" . get_option('mp-getdeal-fb-app-key'), '', time()-3600, "/", "www.getdeals.nl");				
		$facebook->destroySession();		
	}
	else if(isset($_GET['state']) || (isset($_GET['settings-updated']) && $_GET['settings-updated']=='true'))
	{
		$fbuser = $facebook->getUser();		
		if($fbuser)
		{
			update_option('mp-getdeal-userid', $fbuser);
			update_option('mp-getdeal-access-token', $facebook->getAccessToken());			
		
			$pageId = get_option('mp-getdeal-fanpage-id',true);		
			if(!empty($pageId))
			{			
				$pageInfo = $facebook->api("/$pageId?fields=access_token");
				if(!empty($pageInfo) && isset($pageInfo['access_token']))
				{
					update_option('mp-getdeal-page-access-token',$pageInfo['access_token']);
				}
			}
		}	
	}
?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2>Facebook Settings</h2>
        <form id="origin_setting" method="post" action="options.php">
        <?php settings_fields('mp-fb-deal-poster'); ?>
			<p>Enable Facebook Deal Poster?<br/>
			<select name="mp-enable-fb-deal-poster" id="mp-enable-fb-deal-poster">			
				<option value="YES"<?php if(get_option('mp-enable-fb-deal-poster') == 'YES') echo ' selected'; ?>>YES</option>
				<option value="NO"<?php if(get_option('mp-enable-fb-deal-poster') == 'NO') echo ' selected'; ?>>NO</option>
			</select>
			</p>
			<p>Facebook App ID<br/><input type="text" size="50" value="<?php echo get_option('mp-getdeal-fb-app-key'); ?>" name="mp-getdeal-fb-app-key" /></p>
			<p>Facebook App Secret<br/><input type="text" size="50" value="<?php echo get_option('mp-getdeal-fb-app-secret'); ?>" name="mp-getdeal-fb-app-secret" /></p>
			<p>Current Account</p>
			<?php 
			if(!get_option('mp-getdeal-userid') || !get_option('mp-getdeal-access-token'))
			{
				$params = array('scope' => 'manage_pages,publish_stream,offline_access','redirect_uri'=> get_option('home').'/wp-admin/options-general.php?page=facebook-deal-poster-options');
			?>
			<a href="<?php echo $facebook->getLoginUrl($params); ?>">Click here to connect</a>
			<?php
			}else{
				//$params = array( 'next' => 'http://www.getdeals.nl/wp-admin/options-general.php?page=facebook-deal-poster-options&fblogout=1');
				//$logoutUrl = $facebook->getLogoutUrl($params);
				$logoutUrl = 'http://www.getdeals.nl/wp-admin/options-general.php?page=facebook-deal-poster-options&fblogout=1';
				
				$fb_id = get_option('mp-getdeal-userid');
				$fb_token = get_option('mp-getdeal-access-token');
				$facebook->setAccessToken($fb_token);
				$fbme = $facebook->api('/'.$fb_id);				
				?>
				<p><img src="http://graph.facebook.com/<?php echo $fb_id; ?>/picture" alt="<?php echo $fbme['name']; ?>" style="vertical-align: middle;height: 32px;width: 32px;"/> <strong><?php echo $fbme['name']; ?></strong> (<a href="<?php echo $logoutUrl;?>">Click here to disconnect</a>)</p
				<?php
			}
			?>
			<p>Fanpage ID<br/><input type="text" value="<?php echo get_option('mp-getdeal-fanpage-id'); ?>" name="mp-getdeal-fanpage-id" /></p>
			<p>Schedule Time<br/>
			<select name="mp-fb-deal-poster-time" id="mp-fb-deal-poster-time">			
				<option value="3600"<?php if(get_option('mp-fb-deal-poster-time') == '3600') echo ' selected'; ?>>1 hours</option>				
				<option value="7200"<?php if(get_option('mp-fb-deal-poster-time') == '7200') echo ' selected'; ?>>2 hours</option>
				<option value="10800"<?php if(get_option('mp-fb-deal-poster-time') == '10800') echo ' selected'; ?>>3 hours</option>
				<option value="14400"<?php if(get_option('mp-fb-deal-poster-time') == '14400') echo ' selected'; ?>>4 hours</option>
				<option value="18000"<?php if(get_option('mp-fb-deal-poster-time') == '18000') echo ' selected'; ?>>5 hours</option>
				<option value="21600"<?php if(get_option('mp-fb-deal-poster-time') == '21600') echo ' selected'; ?>>6 hours</option>
			</select>
			<?php submit_button(); ?>
        </form>
    </div>
<?php }
?>