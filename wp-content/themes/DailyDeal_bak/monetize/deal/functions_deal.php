<?php
//function for expire the deal if current date is equal to coupon end date
function deal_expire_process($postid)
{
global $wpdb,$transection_db_table_name,$deal_db_table_name;
$deal_db_table_name = $wpdb->prefix . "posts";
$recent_posts = get_post($postid);
$store_name = get_option('blogname');
$sellsql = "select count(*) from $transection_db_table_name where post_id=".$postid." and status=1";
$sellsqlinfo = $wpdb->get_var($sellsql);
if(get_post_meta($postid,'coupon_end_date_time',true) !="")
if(date("Y-m-d H:i:s")>= date("Y-m-d H:i:s",get_post_meta($postid,'coupon_end_date_time',true)))
{
	if(get_post_meta($postid,'is_expired',true)== '0')
	{
		$recent_posts = update_post_meta($postid,'is_expired',1);
		$fromEmail = get_site_emailId();
		$fromEmailName = get_site_emailName();
		$deal_link = get_permalink($postid);
		$loginurl = get_option('siteurl').'/?ptype=login';
		$siteurl = get_option('siteurl');
		$post_detail = get_post($postid); 
		$to_seller_email= get_post_meta($postid,'owner_email',true);
			$to_seller_name= get_post_meta($postid,'owner_name',true);
		$user_log_details = get_userdata($post_detail->post_author);
		if(get_post_meta($postid,'coupon_end_date_time',true) != ''){
			$post_date = date('Y-m-d H:i:s',get_post_meta($postid,'coupon_end_date_time',true));
		}
		if(get_option('ptthemes_deal_expire_notify_seller')=='Yes' || get_option('ptthemes_deal_expire_notify_seller')=='')
		{
			global $wpdb;
			$expire_email_subject = get_option('deal_exp_success_email_subject');
			$expire_email_content = get_option('deal_exp_success_email_content');
			$search_expire_array = array('[#to_name#]','[#deal_link#]','[#deal_title#]','[#login_url#]','[#user_login#]','[#user_email#]','[#site_url#]','[#from_name#]','[#post_date#]');
			$replace_expire_array = array($to_seller_name,$deal_link,$post_detail->post_title,$loginurl,$user_log_details->user_login,$user_log_details->user_email,$siteurl,$fromEmailName,$post_date);
			$expire_email_content = str_replace($search_expire_array,$replace_expire_array,$expire_email_content);
			
			templ_sendEmail($to_seller_email,$to_seller_name,$fromEmail,$fromEmailName,$expire_email_subject,$expire_email_content,$extra='');
		}
		if(get_option('ptthemes_deal_expire_notify_admin')=='Yes' || get_option('ptthemes_deal_expire_notify_admin')=='')
		{
			global $wpdb;
				$expire_email_subject = get_option('deal_expadmin_success_email_subject');
				$expire_email_content = get_option('deal_expadmin_success_email_content');
			$search_expire_array = array('[#to_name#]','[#deal_link#]','[#deal_title#]','[#site_url#]','[#from_name#]','[#post_date#]');
			$replace_expire_array = array($fromEmailName,$deal_link,$post_detail->post_title,$siteurl,$fromEmailName,$post_date);
			$expire_email_content = str_replace($search_expire_array,$replace_expire_array,$expire_email_content);
			$search_expire_sub_array = array('[#site_name#]');
			$replace_expire_sub_array = array($store_name );
			$expire_email_subject = str_replace($search_expire_sub_array,$replace_expire_sub_array,$expire_email_subject);
			
			if(get_option('pttthemes_send_mail') == 'Enable' || get_option('pttthemes_send_mail') == '') {	
				templ_sendEmail($fromEmail,$fromEmailName,$to_seller_email,$to_seller_name,$expire_email_subject,$expire_email_content,$extra='');
			}
		}
	}
}
}
function get_deal_trans_info($pid)
{
	global $wpdb,$transection_db_table_name;
	$productinfosql = "select * from $transection_db_table_name where trans_id=$pid";
	$productinfo = $wpdb->get_results($productinfosql);
	if($productinfo)
	{
		foreach($productinfo[0] as $key=>$val)
		{
			$productArray[$key] = $val; 
		}
	}
	return $productArray;
}

function get_payment_optins($method)
{
	global $wpdb;
	$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_$method'";
	$paymentinfo = $wpdb->get_results($paymentsql);
	if($paymentinfo)
	{
		foreach($paymentinfo as $paymentinfoObj)
		{
			$option_value = unserialize($paymentinfoObj->option_value);
			$paymentOpts = $option_value['payOpts'];
			$optReturnarr = array();
			for($i=0;$i<count($paymentOpts);$i++)
			{
				$optReturnarr[$paymentOpts[$i]['fieldname']] = $paymentOpts[$i]['value'];
			}
			return $optReturnarr;
		}
	}
}
function templ_add_template_buy_deal_page($template)
{
	if($_REQUEST['ptype']=='buydeal')
	{
		$template = TEMPL_BUY_DEAL_FOLDER.'pay_form.php';
		
	}elseif($_REQUEST['ptype'] == 'dealpaynow')
	{
		$template = TEMPL_BUY_DEAL_FOLDER . "paynow.php";
	}elseif($_REQUEST['ptype'] == 'cancel_return')
	{
		$template = TEMPL_BUY_DEAL_FOLDER . 'cancel.php';
	}
	elseif($_GET['ptype'] == 'return' || $_GET['ptype'] == 'payment_success')  // PAYMENT GATEWAY RETURN
	{
		$template = TEMPL_BUY_DEAL_FOLDER . 'return.php';
	}
	elseif($_GET['ptype'] == 'success')  // PAYMENT GATEWAY RETURN
	{
		$template = TEMPL_BUY_DEAL_FOLDER . 'success.php';
	}elseif($_GET['ptype'] == 'notifyurl')  // PAYMENT GATEWAY NOTIFY URL
	{
		if($_GET['pmethod'] == 'paypal')
		{
			include_once(TEMPL_BUY_DEAL_FOLDER . 'ipn_process.php');
		}elseif($_GET['pmethod'] == '2co')
		{
			include_once(TEMPL_BUY_DEAL_FOLDER . 'ipn_process_2co.php');
		}
		exit;
	}elseif($_GET['ptype'] == 'trasaction_list')  // PAYMENT GATEWAY NOTIFY URL
	{
		$template = TEMPL_BUY_DEAL_FOLDER.'trasaction_list.php';
	}elseif($_GET['ptype'] == 'dealform')  // PAYMENT GATEWAY NOTIFY URL
	{
			
		$template = TEMPL_BUY_DEAL_FOLDER.'post_deal.php';
	}elseif($_GET['ptype'] == 'postdeal')  // PAYMENT GATEWAY NOTIFY URL
	{
		
		$template = TEMPL_BUY_DEAL_FOLDER.'post_deal_mail.php';
	}elseif($_GET['ptype'] == 'deals')  // PAYMENT GATEWAY NOTIFY URL
	{
		$template = TEMPL_BUY_DEAL_FOLDER.'deals.php';
	}elseif($_GET['ptype'] == 'all_deal_tab')  // PAYMENT GATEWAY NOTIFY URL
	{
		$template = TEMPL_BUY_DEAL_FOLDER.'all_deal_tab.php';
	}elseif($_GET['ptype'] == 'live_deal_tab')  // PAYMENT GATEWAY NOTIFY URL
	{
		$template = TEMPL_BUY_DEAL_FOLDER.'live_deal_tab.php';
	}elseif($_GET['ptype'] == 'expired_deal_tab')  // PAYMENT GATEWAY NOTIFY URL
	{
		$template = TEMPL_BUY_DEAL_FOLDER.'expired_deal_tab.php';
	}elseif($_GET['ptype'] == 'authordetails')  // PAYMENT GATEWAY NOTIFY URL
	{
		$template = TEMPL_BUY_DEAL_FOLDER.'author_details.php';
	}
	elseif($_GET['ptype'] == 'registration')  // PAYMENT GATEWAY NOTIFY URL
	{
		$template = TEMPL_BUY_DEAL_FOLDER.'registration.php';
	}
	elseif($_GET['ptype'] == 'previewdeal')  // PAYMENT GATEWAY NOTIFY URL
	{
		$template = TEMPL_BUY_DEAL_FOLDER.'preview.php';
	}elseif($_GET['ptype'] == 'purchase')  // PAYMENT GATEWAY NOTIFY URL
	{
		$template = TEMPL_BUY_DEAL_FOLDER.'purchase.php';
	}elseif($_GET['ptype'] == 'voucher')  // PAYMENT GATEWAY NOTIFY URL
	{
		$template = TEMPL_BUY_DEAL_FOLDER.'voucher.php';
	}elseif($_GET['ptype'] == 'success_deal')  // PAYMENT GATEWAY NOTIFY URL
	{
			
		$template = TEMPL_BUY_DEAL_FOLDER.'success_deal.php';
	}
	elseif($_GET['ptype'] == 'taxonomy_all_deal_tab')  // PAYMENT GATEWAY NOTIFY URL
	{
			
		$template = TEMPL_BUY_DEAL_FOLDER.'taxonomy_all_deal_tab.php';
	}elseif($_GET['ptype'] == 'taxonomy_live_deal_tab')  // PAYMENT GATEWAY NOTIFY URL
	{
			
		$template = TEMPL_BUY_DEAL_FOLDER.'taxonomy_live_deal_tab.php';
	}elseif($_GET['ptype'] == 'taxonomy_expired_deal_tab')  // PAYMENT GATEWAY NOTIFY URL
	{
			
		$template = TEMPL_BUY_DEAL_FOLDER.'taxonomy_expired_deal_tab.php';
	}elseif($_GET['ptype'] =='response'){
	
	$template = TEMPL_BUY_DEAL_FOLDER.'response.php';
	}elseif($_GET['ptype'] == 'account')
	{
		$template = TEMPLATEPATH . '/monetize/affiliates/check_affiliate.php';
	}elseif($_GET['ptype'] == 'affiliate') //affiliate page start
	{
		$template = TEMPLATEPATH . '/monetize/affiliates/affiliate_page.php';
	}elseif($_GET['ptype'] == 'setasaff')
	{
		global $current_user;
		get_currentuserinfo();
		$user_id = $current_user->ID;
		$current_user->wp_capabilities['affiliate'] = 1;
		update_usermeta($user_id, 'wp_capabilities', $current_user->wp_capabilities);
		wp_redirect(site_url( "/?ptype=myaccount" ));
		exit;
	}
	return $template;
}
//function for creating a thumb image starts here
function make_thumb($src,$dest,$desired_width,$file_name)
{
	$filetype =  substr(strrchr($file_name,'.'),1);
	/* read the source image */
	if($filetype == "gif")
       $source_image = imagecreatefromgif($src);

    if($filetype == "jpg")
       $source_image = imagecreatefromjpeg($src);

    if($filetype == "jpeg")
       $source_image = imagecreatefromjpeg($src);

    if($filetype == "png")
       $source_image = imagecreatefrompng($src);

    if($filetype == "bmp")
       $source_image = imagecreatefromwbmp($src);
	   
	//$source_image = imagecreatefrompng($src);
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	/* find the "desired height" of this thumbnail, relative to the desired width  */
	$desired_height = floor($height*($desired_width/$width));
	
	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width,$desired_height);
	
	/* copy source image at a resized size */
	imagecopyresized($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);
	
	/* create the physical thumbnail image to its destination */
	 if($filetype == "gif")
        imagegif($virtual_image,$dest);

     if($filetype == "jpg")
        imagejpeg($virtual_image,$dest);

     if($filetype == "jpeg")
        imagejpeg($virtual_image,$dest);

     if($filetype == "png")
        imagepng($virtual_image,$dest);

     if($filetype == "bmp")
      	imagewbmp($virtual_image,$dest);
	//imagejpeg($virtual_image,$dest);
}
//function for creating a thumb image ends here


//function to generate a random password
 function generatePassword ($length = 8)
  {

    // start with a blank password
    $password = "";

    // define possible characters - any character in this string can be
    // picked for use in the password, so if you want to put vowels back in
    // or add special characters such as exclamation marks, this is where
    // you should do it
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

    // we refer to the length of $possible a few times, so let's grab it now
    $maxlength = strlen($possible);
  
    // check for length overflow and truncate if necessary
    if ($length > $maxlength) {
      $length = $maxlength;
    }
	
    // set up a counter for how many characters are in the password so far
    $i = 0; 
    
    // add random characters to $password until $length is reached
    while ($i < $length) { 

      // pick a random character from the possible ones
      $char = substr($possible, mt_rand(0, $maxlength-1), 1);
        
      // have we already used this character in $password?
      if (!strstr($password, $char)) { 
        // no, so it's OK to add it onto the end of whatever we've already got...
        $password .= $char;
        // ... and increase the counter by one
        $i++;
      }

    }

    // done!
    return $password;

  }
  //function to generate random password ends here

	function display_deal_image($deal_id,$width = '',$height = '') {
		$args = array('post_type' => 'attachment','numberposts' => 1,'post_status' => 'inherit','post_parent' => $deal_id,'orderby' => 'DESC','post_mime_type' => 'image/%');
		$attachments = get_posts($args);
		if (count($attachments) > 0) {
			foreach($attachments as $attachment){ ?>
				<img src="<?php echo templ_thumbimage_filter($attachment->guid,$width,$height);?>" alt="" />
<?php 		}
		}else { ?>
			 <div class="noimg"> <?php echo IMAGE_NOT_AVAILABLE;?></div>
<?php 	}
	}
	
	function display_deal_grid_image($deal_id,$width = '',$height = '') {
		$args = array('post_type' => 'attachment','numberposts' => 1,'post_status' => 'inherit','post_parent' => $deal_id,'orderby' => 'DESC','post_mime_type' => 'image/%');
		$attachments = get_posts($args);
		if ($attachments) {
			foreach($attachments as $attachment){ ?>
				<img src="<?php echo templ_thumbimage_filter($attachment->guid,$width,$height);?>" alt="" />
<?php 		}	
		}else{ ?>
			<div class="noimg"> <?php echo IMAGE_NOT_AVAILABLE;?></div>
<?php 	}
	}
	
	global $wpdb;
	 $table_setup = $wpdb->prefix."deal_setup";
	 if($wpdb->get_var("SHOW TABLES LIKE \"$table_setup\"") != $table_setup)
	{
		$sqlsetup = "CREATE TABLE " . $table_setup . " (
		sid mediumint(9) NOT NULL AUTO_INCREMENT,
		access varchar(200) NOT NULL,
		PRIMARY KEY sid (sid)
		);";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sqlsetup);
	$sql1 = "INSERT INTO " . $table_setup . "(sid,access ) VALUES('','0');";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	 dbDelta($sql1);
	}

	function get_user_table(){
		global $wpdb;
		$user_db_table_name1 = $wpdb->prefix . "users";
		if($wpdb->get_var("SHOW TABLES LIKE \"$user_db_table_name1\"") != $user_db_table_name1) {
			$tbl_users = $wpdb->get_var("SHOW TABLES LIKE \"%users\"");
			$user_db_table_name = $tbl_users;
		}	else{
			$user_db_table_name = $wpdb->prefix . "users";
		}
		return $user_db_table_name;
	}
	
							
	
?>