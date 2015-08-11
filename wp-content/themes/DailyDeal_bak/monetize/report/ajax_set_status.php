<?php
$file = dirname(__FILE__);
	$file = substr($file,0,stripos($file, "wp-content"));
	require($file . "/wp-load.php");
	
global $wpdb,$table_prefix;
$transection_db_table_name = $table_prefix . "deal_transaction";
	if(isset($_REQUEST['transid']) && $_REQUEST['transid'] !='')
	{
	$status_update_sql = mysql_query("update $transection_db_table_name set status='1' where trans_id=".$_REQUEST['transid']);
	echo "status updated and now user can print the coupon";
	$fromEmail = get_site_emailId();
	$fromEmailName = get_site_emailName();
		$u_data = $wpdb->get_row("select * from $transection_db_table_name where trans_id = '".$_REQUEST['transid']."'");
		$user_fname = $u_data->billing_name;
		$user_login = $u_data->pay_email;
		$user_billing_name = $u_data->pay_email;
		$buser_shipping_name = $u_data->shipping_name;
		$billing_Address = $u_data->shipping_add;
		$store_name = get_option('blogname');
		$did1 = $u_data->post_id;
		$deal_coupon = $u_data->deal_coupon;
		$coupon_type = $u_data->deal_type;
		$deal_title = $u_data->post_title;
		$payable_amount = $u_data->payable_amt;
		$paymentmethod = $u_data->payment_method;
		
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
	
		$transaction_details = sprintf(__("
		<p><h3 >".DEAL_DETAILS_TEXT."</h3></p>
		<p><strong>".DEAL_TITLE_TEXT.":</strong> %s </p>
		<p><strong>".DEAL_COUPON.":</strong> %s	</p>
		<p><strong>".DEAL_TYPE.":</strong> %s </p>
		<p><strong>".PAYABLE_AMOUT.": </strong>%s</p>
		<p><strong>".PAYMENT_METHOD.": </strong>%s</p>
		",'templatic'),$deal_title,$deal_coupon,$coupon_type,get_currency_sym().$payable_amount,$paymentmethod);
	$seller_name = get_post_meta($did1,'owner_name',true);
	$seller_email = get_post_meta($did1,'owner_email',true);
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
		$user_trans = $wpdb->get_row("select * from $transection_db_table_name where post_id ='".$did1."' and user_id = '".$u_data->author_id."' ");
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
echo $email_seller_content;
			if(get_option('pttthemes_send_mail') == 'Enable' || get_option('pttthemes_send_mail') == '') {	
				templ_sendEmail($fromEmail,$fromEmailName,$fromEmail,$fromEmailName,$admin_subject,$email_admin_content,$extra='');
				templ_sendEmail($fromEmail,$fromEmailName,$seller_email,$seller_name,$subject,$email_seller_content,$extra='');
				templ_sendEmail($fromEmail,$fromEmailName,$buyer_email,$buyer_name,$buyer_subject,$filecontent,$extra='');
			}
	exit;

	}
?>