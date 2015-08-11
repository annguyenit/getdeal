<?php
session_start();
ob_start();
global $wpdb;
$did1 =$_POST['did_deal'];
global $did1;
$orderInfoArray = array();
$aff_commission = 0;
if($_POST)
{
	$_SESSION['deal_info'] = $_POST;
	
	$sellsql = "select count(*) from $transection_db_table_name where post_id=".$did1." and status=1";
	$sellsqlinfo = $wpdb->get_var($sellsql);
	if(get_post_meta($did1,'is_expired',true)=='1' || get_post_meta($did1,'no_of_coupon',true)==$sellsqlinfo )
	{
		if(get_post_meta($did1,'coupon_end_date_time',true) != '' && date("Y-m-d H:i:s")>= date("Y-m-d H:i:s",get_post_meta($did1,'coupon_end_date_time',true))) {
			wp_redirect(site_url());
			exit;
		} else {
			wp_redirect(site_url());
			exit;
		}
	}
	$coupon_code_arr=explode(",",get_post_meta($did1,'coupon_code',true));
	if(count($coupon_code_arr)==0)
	{
		wp_redirect(site_url());
		exit;
	}
	if(file_exists(ABSPATH.'wp-content/plugins//wp-recaptcha/recaptchalib.php')){
		require_once( ABSPATH.'wp-content/plugins//wp-recaptcha/recaptchalib.php');
		$a = get_option("recaptcha_options");
		$privatekey = $a['private_key'];
  						$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
	}
	if (!$resp->is_valid && isset($_POST['recaptcha_response_field']) && isset($_POST['recaptcha_challenge_field'])) {
		// What happens when the CAPTCHA was entered incorrectly
		wp_redirect(site_url("/?ptype=buydeal&amp;did=".$did1."&amp;emsg=captch"));
		exit;
	}
	
	
	$payable_amount = get_post_meta($did1,'our_price',true) + get_post_meta($did1,'shipping_cost',true) ;
	if($payable_amount>0 && $_REQUEST['paymentmethod']=='')
	{
		wp_redirect(site_url("/?ptype=buydeal&amp;did=".$did1."&amp;msg=nopaymethod"));
		exit;
	}
	$coupon_type = get_post_meta($did1,'coupon_type',true);
	$deal_coupon_1 = get_post_meta($did1,'coupon_code',true);
		$pos = strpos($deal_coupon_1,',');
		if($pos == true)
		{
			$deal_coupon_exp = explode(',',$deal_coupon_1);
			
			$samecoupon = "";
			for($c= 0 ; $c <= count($deal_coupon_exp) ; $c++)
			{
				$transql = $wpdb->get_row("select * from $transection_db_table_name where post_id = '".$did1."' and deal_coupon LIKE '".$deal_coupon_exp[$c]."' and status = '1'");
				//echo "select * trans_id from $transection_db_table_name where post_id = '".$did1."' and deal_coupon LIKE '".$deal_coupon_exp[$c]."'";
				$samecoupon = $transql;
				if($samecoupon == 0)
				{
					$deal_coupon = $deal_coupon_exp[$c];
					break;
				}
			}
		}
		else
		{
			$deal_coupon = get_post_meta($did1,'coupon_code',true);
		}
	    $user_billing_name=$_POST['user_billing_name'];
		if($_POST['user_phone'])
		$billing_Address=$_POST['user_add1'].'<br />'.$_POST['user_city'].','.$_POST['user_state'].',<br />'.$_POST['user_country'].'-'.$_POST['user_postalcode'].'.<br />Phone:'.$_POST['user_phone'];
		else
		$billing_Address=$_POST['user_add1'].'<br />'.$_POST['user_city'].','.$_POST['user_state'].',<br />'.$_POST['user_country'].'-'.$_POST['user_postalcode'];
		
		
		if(isset($_POST['copybilladd']) && $_POST['copybilladd'] == 'Y' ){
			$buser_shipping_name = $_POST['user_billing_name'];
			$ship_add = $_POST['user_add1'].'<br />';
			$ship_add .= $_POST['user_city'].',';
			$ship_add .= $_POST['user_state'].',<br />';
			$ship_add .= $_POST['user_country'].'-';
			$ship_add .= $_POST['user_postalcode'].'.<br />Phone:';
			$ship_add .= $_POST['user_phone'];	
		} else {
			$buser_shipping_name = $_POST['buser_shipping_name'];
			$ship_add =$_POST['buser_add1'].'<br />';
			$ship_add .= $_POST['buser_city'].',';
			$ship_add .= $_POST['buser_state'].',<br />';
			$ship_add .= $_POST['buser_country'].'-';
			$ship_add .= $_POST['buser_postalcode'].'.<br />Phone:';
			$ship_add .= $_POST['buser_phone'];
			
		}	

	$user_baddr = $_POST['user_add1'];
	$user_bcity = $_POST['user_city'];
	$user_bstate = $_POST['user_state'];
	$user_bcountry = $_POST['user_country'];
	$user_bpostalcode = $_POST['user_postalcode'];
	$user_bphone = $_POST['user_phone'];
	
	$user_saddr = $_POST['buser_add1'];
	$user_scity = $_POST['buser_city'];
	$user_sstate = $_POST['buser_state'];
	$user_scountry = $_POST['buser_country'];
	$user_spostalcode = $_POST['buser_postalcode'];
	$user_sphone = $_POST['buser_phone'];
	global $user_baddr,$user_bcity,$user_bstate,$user_bcountry,$user_bphone,$user_bpostalcode,$user_saddr,$user_scity ,$user_sstate,$user_scountry,$user_spostalcode,$user_sphone,$user_billing_name,$buser_shipping_name;
	
	$password = wp_generate_password(12,false);
	$fromEmail = get_site_emailId();
	$fromEmailName = get_site_emailName();
	$user_registered = date("Y-m-d h:i:s");
	$user_db_table_name = get_user_table();
	if($current_user->ID == " " || !isset($current_user->ID)) {
		$is_login = 'N';
		$user_a_id = wp_create_user( $_POST['owner_email'], $password, $_POST['owner_email'] );
		$user_qry = "select ID from $user_db_table_name order by ID desc limit 0,1";
		$user_id = $wpdb->get_var($user_qry);
		$userName = $_POST['owner_name'];
		update_usermeta($user_id, 'first_name', $_POST['owner_name']); // User First Name Information Here
		$user_nicename = $_POST['owner_name']; //generate nice name
		$updateUsersql = "update $user_db_table_name set user_nicename='".$user_nicename."' , display_name='".$userName."'  where ID='".$user_id."'";
		$wpdb->query($updateUsersql);
		///////REGISTRATION EMAIL START//////
		$user_fname = $_POST['owner_name'];
		$user_login = $_POST['owner_email'];
		$store_name = get_option('blogname');
		$client_message = get_option('registration_success_email_content');
		$subject = get_option('registration_success_email_subject');
		if($client_message == "")
		{
			$client_message = "<p>Dear [#user_name#],</p>
<p>Your registration completed successfully. You can now login here [#site_login_url#] using the following credentials:</p><p>Username: [#user_login#]</p><p>Password: [#user_password#]</p>
<p>Or using the URL: [#site_login_url_link#] .</p><br /><p>Thanks!</p>
<p>[#site_name#]</p>";
		}
		
		if($subject == "")
		{
			$subject = "Registration completed successfully";
		}
		
			$store_login = '<a href="'.site_url().'/?ptype=login">'.site_url().'/?ptype=login</a>';
			$store_login_link = site_url().'/?ptype=login';
			/////////////customer email//////////////
			$search_array = array('[#user_name#]','[#user_login#]','[#user_password#]','[#site_name#]','[#site_login_url#]','[#site_login_url_link#]');
		$replace_array = array($user_fname,$user_login,$password,$store_name,$store_login,$store_login_link);
		$client_message = str_replace($search_array,$replace_array,$client_message);
		if(get_option('pttthemes_send_mail') == 'Enable' || get_option('pttthemes_send_mail') == '') {	
			templ_sendEmail($fromEmail,$fromEmailName,$user_login,$user_fname,$subject,$client_message,$extra='');
		} ///To clidnt email
		//////REGISTRATION EMAIL END////////
		
	} else {
		$user_id = $current_user->data->ID;
		$is_login = 'Y';
	}
	global $is_login;
	
		$paymentmethod = $_REQUEST['paymentmethod'];
		$post_title = get_the_title($did1);
		
		if($_POST['buser_add1'])
		$ship_add = $ship_add;
		else
		$ship_add=$_POST['user_add1'].'<br />'.$_POST['user_city'].','.$_POST['user_state'].',<br />'.$_POST['user_country'].'-'.$_POST['user_postalcode'];
		
	global $wpdb,$General;
	$wpdbpost = $wpdb->prefix."posts";
	$author_id = $wpdb->get_row("select * from $wpdbpost where ID = '".$did1."'");

	if($payable_amount > 0 && $_COOKIE['affiliate-settings'] != '')
	{ 
		$aff_info_array = explode('|',$_COOKIE['affiliate-settings']);
		$aid = $aff_info_array[0];
		$lkey = $aff_info_array[1];
		$affliate_info =  array(
								"aid"	=>	$aid,
								);
								
		$orderInfoArray['affliate_info'] = $affliate_info;
		if(get_option('aff_share_amt')>0)
		{
			$aff_commission = get_option('aff_share_amt');
		}
	}
	$aff_uid = $orderInfoArray['affliate_info']['aid'];
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$post_author = $author_id->post_author;
	// Insert in to Transection Table 

	$transaction_insert = 'INSERT INTO '.$transection_db_table_name.' set 
	post_id="'.$did1.'",
	author_id = "'.$post_author.'",
	user_id = "'.$user_id.'",
	post_title ="'.$post_title.'",
	deal_coupon = "'.$deal_coupon.'",
	deal_type="'.$coupon_type.'",
	payment_method="'.$paymentmethod.'",
	payable_amt='.$payable_amount.',
	payment_date="'.date("Y-m-d H:i:s").'",
	status="0",
	user_name="'.$user_fname.'",
	pay_email="'.$user_email.'",
	billing_name="'.$user_billing_name.'",
	billing_add="'.$billing_Address.'",
	shipping_name ="'.$buser_shipping_name.'",
	shipping_add="'.$ship_add.'",
	aff_uid="'.$aff_uid.'",
	aff_commission="'.$aff_commission .'",
	ip_address="'.$ip_address.'",
	ord_date= "'.date('Y-m-d').'"';

	/* Mail To Buyer BOF */
	$seller_name = get_post_meta($did1,'owner_name',true);
	$seller_email = get_post_meta($did1,'owner_email',true);
	
	$deal_title = $post_title;
	
	if($coupon_type=='1')
	   $coupon_type='Custom Link Deal';
	 elseif($coupon_type=='2')
	   $coupon_type='Fixed Deal';
	 elseif($coupon_type=='3')
	   $coupon_type='Custom Generated Deal';
	 elseif($coupon_type=='4')
	   $coupon_type='Physical Barcode Deal';
	 elseif($coupon_type=='5')
	$coupon_type='Physical Product Deal';
	
	// Start All Transection Details With Deal
		
		$transaction_details = sprintf(__("
		<p><h3 >".DEAL_DETAILS_TEXT."</h3></p>
		<p><strong>".DEAL_TITLE_TEXT.":</strong> %s </p>
		<p><strong>".DEAL_COUPON.":</strong> %s	</p>
		<p><strong>".DEAL_TYPE.":</strong> %s </p>
		<p><strong>".PAYABLE_AMOUT.": </strong>%s</p>
		<p><strong>".PAYMENT_METHOD.": </strong>%s</p>
		",'templatic'),$deal_title,$deal_coupon,$coupon_type,get_currency_sym().$payable_amount,$paymentmethod);
	
	// End All Transection Details With Deal
	
	// Start User Details With Deal
	$users_details = sprintf(__("
	<p><h3 >".SELLER_DETAIL."</h3> \r</p>
	<p><strong>".NAME.":</strong> %s \r	</p>
	<p><strong>".EMAIL.":</strong> %s \r	</p>",'templatic'),$seller_name,$seller_email);
	 $buyer_detail = sprintf(__("
	<p><h3 >Buyer Details</h3> \r</p>
	<table border='0'>
		<tr>
			<td valign='top'><strong>".BILLING_NAME."</strong></td>
			<td valign='top'>%s</td>
		</tr>
		<tr>
			<td valign='top'><strong>".BILLING_ADDRESS."</strong></td>
			<td valign='top'>%s</td>
		</tr><tr>
			<td valign='top'><strong>".SHIPPING_NAME."</strong></td>
			<td valign='top'>%s</td>
		</tr>
		<tr>
			<td valign='top'><strong>".SHIPPING_ADDRESS."</strong></td>
			<td valign='top'>%s</td>
		</tr>
	</table>",'templatic'),$user_billing_name,$billing_Address,$buser_shipping_name,$ship_add);
	
	/*-------Fetch Email details --------*/
		$client_message = '<p>Dear [#to_name#]</p><p>A buyer with the following details bought your deal [#deal_title#] on [#site_name#]</p><p>[#buyer_detail#]</p> <p>[#deal_details#]</p><br /><br /><p>Thanks!</p><p>[#site_name#]</p>';
		$subject = 'Congratulations, a new sale has occured to your deal '.$deal_title;
		$site_name = get_option('blogname');
		$search_array = array('[#to_name#]','[#deal_title#]','[#buyer_detail#]','[#deal_details#]','[#site_name#]');
		$replace_array = array($seller_name.",",$deal_title,$buyer_detail,$transaction_details,$site_name);
		$email_seller_content = str_replace($search_array,$replace_array,$client_message);	
		
		$admin_message = '<p>Dear [#to_name#]</p>
		<p>A buyer with the following details bought a deal [#deal_title#] on [#site_name#]</p><p>[#buyer_detail#]</p> <p>[#deal_details#]</p><p>[#seller_details#]</p><br /><br /><p>Thanks!</p><p>[#site_name#]</p>';
		$admin_subject = 'A buyer has just bought the deal '.$deal_title;
		
		$search_array = array('[#to_name#]','[#deal_title#]','[#buyer_detail#]','[#deal_details#]','[#site_name#]','[#seller_details#]');
		$replace_array = array($fromEmailName.",",$deal_title,$buyer_detail,$transaction_details,$site_name,$users_details);
		$email_admin_content = str_replace($search_array,$replace_array,$admin_message);	
		global $current_user;
		$max_pur = get_post_meta($did1,'max_purchases_user',true);
		$user_trans = $wpdb->get_row("select * from $transection_db_table_name where post_id ='".$did1."' and user_id = '".$current_user->ID."' ");
		$user_trans_obj = mysql_affected_rows(); 
		if($current_user->data->ID == "")
		{
				$user_qry = "select * from $user_db_table_name order by ID desc limit 0,1";
				$users = $wpdb->get_row($user_qry);
				$buyer_email = $users->user_email;
				$buyer_name = $users->display_name;
				$user_id = $users->ID;
		}
		else
		{
				$buyer_email = $current_user->data->user_email;
				$buyer_name = $current_user->data->display_name;
				$user_id = $current_user->data->ID;
		}
		
	
		$deal_title = $user_trans->post_title;
		$buyer_subject = "You have just purchased the deal: ". $deal_title;
		$filecontent = stripslashes(get_option('deal_payment_success_msg_content'));
		if($filecontent==""){
			$filecontent = __('<h4>Your payment received successfully and your Coupon information is as below</h4><p>[#deal_details#]</p><br>
			<h5>Thank you for becoming a member at [#site_name#].</h5>');
		}
		$search_array = array('[#deal_details#]','[#site_name#]');
		$replace_array = array($transaction_details,$site_name);
		$filecontent = str_replace($search_array,$replace_array,$filecontent);
			if($user_trans_obj < $max_pur && $max_pur !="" && $max_pur !='0'){
		if($paymentmethod == 'prebanktransfer' || $paymentmethod == 'payondelevary') { 
			if(get_option('pttthemes_send_mail') == 'Enable' || get_option('pttthemes_send_mail') == '') {	
				templ_sendEmail($fromEmail,$fromEmailName,$fromEmail,$fromEmailName,$admin_subject,$email_admin_content,$extra='');
				templ_sendEmail($fromEmail,$fromEmailName,$seller_email,$seller_name,$subject,$email_seller_content,$extra='');
				//templ_sendEmail($fromEmail,$fromEmailName,$buyer_email,$buyer_name,$buyer_subject,$filecontent,$extra='');
			}
		}
	}
	/* Mail To Buyer EOF */
	
	if($user_trans_obj >= $max_pur && $max_pur !="" && $max_pur !='0'){
		wp_redirect(site_url().'/?ptype=buydeal&dealerror=1');
	}else {
	   $wpdb->query($transaction_insert);
	
		$transql = "select trans_id from $transection_db_table_name order by trans_id desc limit 0,1";
		$last_postid = $wpdb->get_var($transql);
		global $last_postid,$payable_amount;
		$_SESSION['deal_info']="";
		$paymentSuccessFlag = 0;
		if($paymentmethod == 'prebanktransfer' || $paymentmethod == 'payondelevary')
		{
			$suburl .= "&pid=$last_postid&is_login=$is_login";
			wp_redirect(site_url().'/?ptype=success&paydeltype='.$paymentmethod.$suburl);
		}
		else
		{
			if(file_exists( TT_INCLUDES_FOLDER_PATH.'payment/'.$paymentmethod.'/'.$paymentmethod.'_response.php'))
			{
				include_once(TT_INCLUDES_FOLDER_PATH.'payment/'.$paymentmethod.'/'.$paymentmethod.'_response.php');
			}
		}
	}
	exit;	
}
?>