<?php
global $wpdb,$transection_db_table_name;
//$url = 'https://www.paypal.com/cgi-bin/webscr';
$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
$postdata = '';
foreach($_POST as $i => $v) 
{
	$postdata .= $i.'='.urlencode($v).'&amp;';
}
$postdata .= 'cmd=_notify-validate';
 
$web = parse_url($url);
if ($web['scheme'] == 'https') 
{
	$web['port'] = 443;
	$ssl = 'ssl://';
} 
else 
{
	$web['port'] = 80;
	$ssl = '';
}
$fp = @fsockopen($ssl.$web['host'], $web['port'], $errnum, $errstr, 30);
 
if (!$fp) 
{
	echo $errnum.': '.$errstr;
}
else
{
	fputs($fp, "POST ".$web['path']." HTTP/1.1\r\n");
	fputs($fp, "Host: ".$web['host']."\r\n");
	fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
	fputs($fp, "Content-length: ".strlen($postdata)."\r\n");
	fputs($fp, "Connection: close\r\n\r\n");
	fputs($fp, $postdata . "\r\n\r\n");
 
	while(!feof($fp)) 
	{
		$info[] = @fgets($fp, 1024);
	}
	fclose($fp);
	$info = implode(',', $info);
	if (eregi('VERIFIED', $info)) 
	{
		$to = get_site_emailId();
		
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
		$amount             = $_POST['amount'];
		
		$deal_details=explode("|",hexstr($postid));
		 $postid = $deal_details[0];
		if($deal_details[1]=='3' || $deal_details[1]=='4' || $deal_details[1]=='5')
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
		$transaction_insert = ' INSERT INTO '.$transection_db_table_name.' set 
		post_id='.$postid.',
		post_title ="'.$item_name.'",
		deal_coupon="'.$coup.'",
		deal_type='.$deal_details[1].',
		payment_method="'.$deal_details[18].'",
		payable_amt='.$amount.',
		payment_date="'.$payment_date.'",
		paypal_transection_id="'.$txn_id.'",
		user_name="'.$deal_details[2].'",
		pay_email="'.$deal_details[3].'",
		billing_name="'.$deal_details[4].'",';
		if($deal_details[10]!="")
		{
			$Billing_address = $deal_details[5].'<br />'.$deal_details[6].','.$deal_details[7].',<br />'.$deal_details[8].'-'.$deal_details[9].'.<br />Phone:'.$deal_details[10];
			$transaction_insert .= 'billing_add="'.$Billing_address.'",';
		}
		else
		{
			$Billing_address = $deal_details[5].'<br />'.$deal_details[6].','.$deal_details[7].',<br />'.$deal_details[8].'-'.$deal_details[9].'.';
			$transaction_insert .= 'billing_add="'.$Billing_address.'",';
		}
		if($deal_details[1]=='4' || $deal_details[1]=='5')
		{
			$transaction_insert .= 'shipping_name=="'.$deal_details[11].'",';
			if($deal_details[17]!="")
			{
				$Sipping_address=$deal_details[12].'<br />'.$deal_details[13].','.$deal_details[14].',<br />'.$deal_details[15].'-'.$deal_details[16].'.<br />Phone:'.$deal_details[17];
				$transaction_insert .= 'shipping_add="'.$Sipping_address.'"';
			}
			else
			{
				$Sipping_address=$deal_details[12].'<br />'.$deal_details[13].','.$deal_details[14].',<br />'.$deal_details[15].'-'.$deal_details[16].'.';
				$transaction_insert .= 'shipping_add="'.$Sipping_address.'"';
			}
		}
		$wpdb->query($transaction_insert);
		$transql = "select trans_id from $transection_db_table_name order by trans_id desc limit 0,1";
		$last_trans_id = $wpdb->get_var($transql);
		//
		
		// Start All Transection Details With Deal
		if($deal_details[1]=='4' || $deal_details[1]=='5')
		{
			$coupon_address=get_post_meta($postid,'coupon_address',true);
			if($coupon_address!="")
			{
				$transaction_details = sprintf(__("--------------------------------------------------\r
				Payment Details for Deal ID #%s\r	--------------------------------------------------\r
				Deal Title: %s \r	--------------------------------------------------\r
				Deal Coupon: %s \r	--------------------------------------------------\r
				Store Address: %s \r	--------------------------------------------------\r
				Trans ID: %s\r Paypal Trans ID: %s\r Status: %s\r	Type: %s\r	Date: %s\r	Method: %s\r
				--------------------------------------------------\r",'templatic'),$postid,$item_name,$coup,$coupon_address,$last_trans_id,$txn_id,$payment_status,$payment_type,$payment_date,$txn_type);
			}
			else
			{
				$transaction_details = sprintf(__("--------------------------------------------------\r
				Payment Details for Deal ID #%s\r	--------------------------------------------------\r
				Deal Title: %s \r	--------------------------------------------------\r
				Deal Coupon: %s \r	--------------------------------------------------\r
				Trans ID: %s\r Paypal Trans ID: %s\r Status: %s\r	Type: %s\r	Date: %s\r	Method: %s\r
				--------------------------------------------------\r",'templatic'),$postid,$item_name,$coup,$last_trans_id,$txn_id,$payment_status,$payment_type,$payment_date,$txn_type);
			}
		}
		else
		{
			$coupon_link=get_post_meta($postid,'coupon_link',true);
			$post_title_link = '<a href="'.$coupon_link.'">'.$item_name.'</a>'; 
			$transaction_details = sprintf(__("--------------------------------------------------\r
			Payment Details for Deal ID #%s\r	--------------------------------------------------\r
			Deal Title: %s \r	--------------------------------------------------\r
			Deal Coupon: %s \r	--------------------------------------------------\r
			Deal Coupon Link: %s \r	--------------------------------------------------\r
			Trans ID: %s\r Paypal Trans ID: %s\r Status: %s\r	Type: %s\r	Date: %s\r	Method: %s\r
			--------------------------------------------------\r",'templatic'),$postid,$item_name,$coup,$post_title_link,$last_trans_id,$txn_id,$payment_status,$payment_type,$payment_date,$txn_type);
		}
		$site_name = get_option('blogname');
		// End All Transection Details With Deal
		
		
		// Start User Details With Deal
		$users_details = sprintf(__("--------------------------------------------------\r
		User Details for Transaction ID #%s\r	--------------------------------------------------\r
		Name: %s \r	--------------------------------------------------\r
		Email: %s \r	--------------------------------------------------\r
		Billing Details\r	--------------------------------------------------\r
		Billing Name: %s\r Address: %s\r 
		--------------------------------------------------\r",'templatic'),$last_trans_id,$deal_details[2],$deal_details[3],$deal_details[4],$Billing_address);
		
		if($deal_details[1]=='4' || $deal_details[1]=='5')
		{
			$users_details = sprintf(__("
		    Shipping  Details\r	--------------------------------------------------\r
			Shipping Name: %s\r Address: %s\r 
			--------------------------------------------------\r",'templatic'),$deal_details[11],$Sipping_address);
		}
		// Start User Details With Deal
		
		
		
		// Start  Payment Success To Seller Email
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
		templ_sendEmail($to_seller_email,$to_seller_name,$fromEmail,$fromEmailName,$email_admin_subject,$email_admin_content,$extra='');///To admin email
		// End Payment Success To Seller Email
		
		
		// Start  Payment Success To USer Email
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
		$replace_array = array($deal_details[2],$transaction_details,$site_name);
		$email_user_content = str_replace($search_array,$replace_array,$email_user_content);	
		templ_sendEmail($deal_details[3],$deal_details[2],$fromEmail,$fromEmailName,$email_user_subject,$email_user_content,$extra='');///To admin email
		// End Payment Success To USer Email
		
		
		
		// Start  Payment Success To Admin Email
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
		templ_sendEmail($fromEmail,$fromEmailName,$deal_details[3],$deal_details[2],$email_admin_subject,$email_admin_content,$extra='');///To admin email
		// End Payment Success To Admin Email
		
		
		
		
	}
	else
	{
		// invalid, log error or something
	}
}
?>