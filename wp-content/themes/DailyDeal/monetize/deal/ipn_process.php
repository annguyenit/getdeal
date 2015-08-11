<?php
global $wpdb,$transection_db_table_name;
// read the post from PayPal system and add 'cmd'

$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
//$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
$fp = fsockopen('www.sandbox.paypal.com', 80, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];



if (!$fp) {
	// HTTP ERROR
} else {
		fputs ($fp, $header . $req);
		while (!feof($fp)) 
		{
				$res = fgets ($fp, 1024);
				if (strcmp ($res, "VERIFIED") == 0) 
				{
					$fromEmail = get_site_emailId();
					$fromEmailName = get_site_emailName();
					
			
					// yes valid, f.e. change payment status
					$postid = $_POST['custom'];
					$item_name = $_POST['item_name'];
					$txn_id = $_POST['txn_id'];
					$payment_status       = $_POST['payment_status'];
					$payment_type         = $_POST['payment_type'];
					$payment_date         = $_POST['payment_date'];
					$txn_type             = $_POST['txn_type'];
					$amount             = $_POST['mc_gross'];
					$item_number = $_POST['item_number'];
					$transifo=get_deal_trans_info($item_number);
					
					if($transifo['deal_type']=='3' || $transifo['deal_type']=='4' || $transifo['deal_type']=='5')
					{ 
						$coupon_code_arr=explode(",",get_post_meta($postid,'coupon_code',true));
						$coup=array_shift($coupon_code_arr);
						update_post_meta($postid, "coupon_code",implode(",",$coupon_code_arr));
						if(get_post_meta($postid,'used_coupon_code',true)=="")
						{
							update_post_meta($postid, "used_coupon_code",$coup);
						}
						else
						{
							$old_used_coupon=get_post_meta($postid,'used_coupon_code',true);
							$coupon=$old_used_coupon.",".$coup;
							update_post_meta($postid, "used_coupon_code", $coupon);
						}
					}
					else
					{
						
						$coup=get_post_meta($postid,'single_coupon_code',true);
					}
					// Insert in to Transection Table 
					$transaction_insert = ' update '.$transection_db_table_name.' set 
					deal_coupon="'.$coup.'",
					paypal_transection_id="'.$txn_id.'",status=1 where post_id='.$postid.' and trans_id='.$item_number.'';
					$wpdb->query($transaction_insert);
					$last_trans_id = $item_number;
					
					//
					
					// Start All Transection Details With Deal
					if($transifo['deal_type']=='4' || $transifo['deal_type']=='5')
					{
						$coupon_address=get_post_meta($postid,'coupon_address',true);
						if($coupon_address!="")
						{
							$transaction_details = sprintf(__("
							<p>Payment Details for Deal ID #%s\r</p>
							<p>Deal Title: %s \r	</p>
							<p>Deal Coupon: %s \r	</p>
							<p>Store Address: %s \r	</p>
							<p>Trans ID: %s\r</p> <p>Paypal Trans ID: %s\r</p> <p>Status: %s\r</p>	<p>Type: %s\r</p>	<p>Date: %s\r</p>	<p>Method: %s\r</p>",'templatic'),$postid,$item_name,$coup,$coupon_address,$last_trans_id,$txn_id,$payment_status,$payment_type,$payment_date,$txn_type);
						}
						else
						{
							$transaction_details = sprintf(__("
							<p>Payment Details for Deal ID #%s\r</p>
							<p>Deal Title: %s \r</p>
							<p>Deal Coupon: %s \r	</p>
							<p>Trans ID: %s\r</p> <p>Paypal Trans ID: %s\r</p> <p>Status: %s\r</p>	<p>Type: %s\r</p>	<p>Date: %s\r</p>	<p>Method: %s\r</p>",'templatic'),$postid,$item_name,$coup,$last_trans_id,$txn_id,$payment_status,$payment_type,$payment_date,$txn_type);
						}
					}
					else
					{
						$coupon_link=get_post_meta($postid,'coupon_link',true);
						$post_title_link ="<a href=".$coupon_link.">".$item_name."</a>"; 
						$transaction_details = sprintf(__("
						<p>Payment Details for Deal ID #%s\r	</p>
						<p>Deal Title: %s \r</p>
						<p>Deal Coupon: %s \r	</p>
						<p>Deal Coupon Link: %s \r	</p>
						<p>Trans ID: %s\r</p> <p>Paypal Trans ID: %s\r</p> <p>Status: %s\r</p>	<p>Type: %s\r</p>	<p>Date: %s\r</p>	<p>Method: %s\r</p>",'templatic'),$postid,$item_name,$coup,$post_title_link,$last_trans_id,$txn_id,$payment_status,$payment_type,$payment_date,$txn_type);
					}
					$site_name = get_option('blogname');
					// End All Transection Details With Deal
					
					
					// Start User Details With Deal
					$users_details = sprintf(__("
					<p>User Details for Transaction ID #%s\r</p>
					<p>Name: %s \r	</p>
					<p>Email: %s \r	</p>
					<p>Billing Details\r	</p>
					<p>Billing Name: %s\r</p> <p>Billing Address: %s\r </p>",'templatic'),$last_trans_id,$transifo['user_name'],$transifo['pay_email'],$transifo['billing_name'],$transifo['billing_add']);
					
					if($transifo['deal_type']=='4' || $transifo['deal_type']=='5')
					{
						$users_details = sprintf(__("
					   <p> Shipping  Details\r	</p>
						<p>Shipping Name: %s\r</p> <p>Shipping Address: %s\r </p>",'templatic'),$transifo['shipping_name'],$transifo['shipping_add']);
					}
					// Start User Details With Deal
					
					
					
					// Start  Payment Success To Seller Email 
					if(get_option('ptthemes_deal_pay_notify_seller')=='Yes' || get_option('ptthemes_deal_pay_notify_seller')==''){
					$to_seller_email=get_post_meta($postid,'owner_email',true);
					$to_seller_name=get_post_meta($postid,'owner_name',true);
					$email_seller_content = get_option('deal_payment_success_seller_email_content');
					$email_seller_subject = get_option('deal_payment_success_seller_email_subject');
					if(!$email_seller_subject)
					{
						$email_seller_subject =  __("Acknowledgment for your Deal",'templatic');
						
					}
					if(!$email_seller_content)
					{
						$email_seller_content=__('<p>Dear [#to_name#],</p><p>[#deal_details#]</p><br><p>[#user_details#]</p><br><p>Thanks!</p><p>[#site_name#]</p>','templatic');
					}
					$search_array = array('[#to_name#]','[#deal_details#]','[#user_details#]','[#site_name#]');
					$replace_array = array($to_seller_name,$transaction_details,$users_details,$site_name);
					$email_seller_content = str_replace($search_array,$replace_array,$email_seller_content);	
					templ_sendEmail($fromEmail,$fromEmailName,$to_seller_email,$to_seller_name,$email_seller_subject,$email_seller_content,$extra='');///To admin email
					}
					// End Payment Success To Seller Email
					
					
					// Start  Payment Success To USer Email
					if(get_option('ptthemes_deal_pay_notify_user')=='Yes' || get_option('ptthemes_deal_pay_notify_user')==''){
					$email_user_content = get_option('deal_payment_success_user_email_content');
					$email_user_subject = get_option('deal_payment_success_user_email_subject');
					if(!$email_user_subject)
					{
						$email_user_subject =  __("Acknowledgment for your Payment",'templatic');
						
					}
					if(!$email_user_content)
					{
						$email_user_content=__('<p>Dear [#to_name#],</p><p>[#deal_details#]</p><br><p>We hope you enjoy. Thanks!</p><p>[#site_name#]</p>','templatic');
					}
					$search_array = array('[#to_name#]','[#deal_details#]','[#site_name#]');
					$replace_array = array($transifo['user_name'],$transaction_details,$site_name);
					$email_user_content = str_replace($search_array,$replace_array,$email_user_content);	
					templ_sendEmail($fromEmail,$fromEmailName,$transifo['pay_email'],$transifo['user_name'],$email_user_subject,$email_user_content,$extra='');///To admin email
					}
					// End Payment Success To USer Email
					
					
					
					// Start  Payment Success To Admin Email
					if(get_option('ptthemes_deal_pay_notify_admin')=='Yes' || get_option('ptthemes_deal_pay_notify_admin')==''){
					$email_admin_content = get_option('deal_payment_success_admin_email_content');
					$email_admin_subject = get_option('deal_payment_success_admin_email_subject');
					if(!$email_admin_subject)
					{
						$email_admin_subject =  __("Payment received successfully",'templatic');
						
					}
					if(!$email_admin_content)
					{
						$email_admin_content=__('<p>Dear [#to_name#],</p><p>[#deal_details#]</p><br><p>[#user_details#]</p><br><p>. Thanks!</p><p>[#site_name#]</p>','templatic');
					}
					$search_array = array('[#to_name#]','[#deal_details#]','[#user_details#]','[#site_name#]');
					$replace_array = array($fromEmailName,$transaction_details,$users_details,$site_name);
					$email_admin_content = str_replace($search_array,$replace_array,$email_admin_content);	
					templ_sendEmail($transifo['pay_email'],$transifo['user_name'],$fromEmail,$fromEmailName,$email_admin_subject,$email_admin_content,$extra='');///To admin email
					}
					// End Payment Success To Admin Email		
					
					// Is Expire Check Status 
					deal_expire_process($postid);
					
					
				}
				else if (strcmp ($res, "INVALID") == 0) 
				{
						$log .= "Invalid!!\n";
				// log for manual investigation
				}
		}
		fclose ($fp);
}
?>