<?php
global $wpdb,$transection_db_table_name;
foreach ($_POST as $field=>$value)
{
	$ipnData["$field"] = $value;
}

$transid    = intval($ipnData['x_invoice_num']);
$pnref      = $ipnData['x_trans_id'];
$amount     = doubleval($ipnData['x_amount']);
$result     = intval($ipnData['x_response_code']);
$respmsg    = $ipnData['x_response_reason_text'];
$customer_email    = $ipnData['x_email'];
$customer_name = $ipnData['x_first_name'];
$item_name = $ipnData['c_name'];

$fromEmail = get_site_emailId();
$fromEmailName = get_site_emailName();

if ($result == '1')
{
	// Valid IPN transaction.
	$transifo=get_deal_trans_info($transid);
	$postid=$transifo['post_id'];
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
	paypal_transection_id="'.$pnref.'",status=1 where post_id='.$postid.' and trans_id='.$transid.'';
	$wpdb->query($transaction_insert);
	$last_trans_id = $transid;
	
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
			<p>Trans ID: %s\r</p> <p>2co Trans ID: %s\r</p> <p>Response Code: %s\r</p>	<p>Response Text: %s\r</p>	<p>Date: %s\r</p>",'templatic'),$postid,$item_name,$coup,$coupon_address,$last_trans_id,$pnref,$result,$respmsg,date("Y-m-d H:i:s"));
		}
		else
		{
			$transaction_details = sprintf(__("
			<p>Payment Details for Deal ID #%s\r</p>
			<p>Deal Title: %s \r</p>
			<p>Deal Coupon: %s \r	</p>
			<p>Trans ID: %s\r</p> <p>2co Trans ID: %s\r</p> <p>Response Code: %s\r</p>	<p>Response Text: %s\r</p>	<p>Date: %s\r</p>",'templatic'),$postid,$item_name,$coup,$last_trans_id,$pnref,$result,$respmsg,date("Y-m-d H:i:s"));
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
		<p>Trans ID: %s\r</p> <p>2co Trans ID: %s\r</p> <p>Response Code: %s\r</p>	<p>Response Text: %s\r</p>	<p>Date: %s\r</p>",'templatic'),$postid,$item_name,$coup,$post_title_link,$last_trans_id,$pnref,$result,$respmsg,date("Y-m-d H:i:s"));
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

	return true;
}
else if ($result != '1')
{
	
	return false;
}
?>