<?php
$notification_email = array();

$content = array();
$content['title'] = 'Deal submitted notification to administrator';
$content['subject'] = array('post_submited_success_email_subject','A new deal is submitted');
$content['content'] = array('post_submited_success_email_content','<p>Dear [#to_name#]</p><p>A new deal has been submitted, details of which are as below:</p><p>[#deal_details#]</p><br /><p>[#seller_details#]</p><br /><br /><p>Thanks!</p><p>[#site_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;

$content = array();
$content['title'] = 'Successful registration notification to the seller';
$content['subject'] = array('registration_success_email_subject','Registration completed successfully.');
$content['content'] = array('registration_success_email_content','<p>Dear [#user_name#],</p>
<p>Your registration completed successfully. You can now login here [#site_login_url#] using the following credentials:</p><p>Username: [#user_login#]</p><p>Password: [#user_password#]</p>
<p>Or using the URL: [#site_login_url_link#] .</p><br /><p>Thanks!</p>
<p>[#site_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;

$content = array();
$content['title'] = 'Deal request accepted notification to seller.';
$content['subject'] = array('req_accept_success_email_subject','Your deal request is approved');
$content['content'] = array('req_accept_success_email_content','<p>Dear [#to_name#]</p><p>This is to notify you that the deal you posted on [#site_name#] has been approved. Good luck with the sales! Your deal details are as below:</p><p>[#deal_details#]</p><br><p>[#seller_details#]</p><br><br><p> Thanks!</p><p>[#site_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;

$content = array();
$content['title'] = 'Deal request rejected notification to seller';
$content['subject'] = array('req_reject_success_email_subject','Sorry, your deal request could not be approved');
$content['content'] = array('req_reject_success_email_content','<p>Dear [#to_name#]</p><p>We regret to inform you that your deal request could not be accepted. Try again and make sure the deal you post does not violate our terms and conditions.</p><p> Thanks!</p><p>[#site_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;

$content = array();
$content['title'] = 'Deal Expiration Email to seller';
$content['subject'] = array('deal_exp_success_email_subject','Your deal has expired');
$content['content'] = array('deal_exp_success_email_content','<p>Dear [#to_name#],<p><p>Your deal - <a href="[#deal_link#]"><b>[#deal_title#]</b></a> posted on <u>[#post_date#]</u> has has expired. It is now listed as &lsquo;Past Deals&rsquo; on our site.</p>
					
					<p>You may login to our site: <a href="[#login_url#]">[#login_url#]</a></p>
					<p>Your login ID is <b>[#user_login#]</b> and email is <b>[#user_email#]</b></p>
					<p>Thank you,<br /><a href="[#site_url#]">[#from_name#]</a></p>');
$content['status'] = '1';
$notification_email[] = $content;

$content = array();
$content['title'] = 'Deal expiration email to administrator';
$content['subject'] = array('deal_expadmin_success_email_subject','A deal on [#site_name#] has expired');
$content['content'] = array('deal_expadmin_success_email_content','<p>Dear [#to_name#]<p><p>This is to notify you that a deal with the following details has expired. </p><p><a href="[#deal_link#]"><b>[#deal_title#]</b></a> posted on  <u>[#post_date#]</u> .</p>');
$content['status'] = '1';
$notification_email[] = $content;

$content = array();
$content['title'] = 'Payment successful notification email to the administrator';
$content['subject'] = array('post_payment_success_admin_email_subject','Payment received successfully');
$content['content'] = array('post_payment_success_admin_email_content','<p>Dear [#to_name#],</p><p>Payment has been received successfully. The following are the transaction details:</p><p>[#transaction_details#]</p><br /><p>Thanks!</p><p>[#site_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;


$content = array();
$content['title'] = 'Payment successful notification to the seller';
$content['subject'] = array('post_payment_seller_client_email_subject','Payment acknowledgement');
$content['content'] = array('post_submited_seller_admin_email_content','<p>Dear [#to_name#],</p> This is the acknowledgement for the payment you made. The following are the transaction details for the same<p>[#transaction_details#]</p><br><p>We hope you enjoy. Thanks!</p><p>[#site_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;



$content = array();
$content['title'] = 'Send inquiry email';
$content['subject'] = array('send_inquiry_email_subject','Inquiry email');
$content['content'] = array('send_inquiry_email_content','<p>Here is an inquiry for <b>[#post_title#]</b>. </p><p><b>Subject : [#frnd_subject#]</b>.</p><p>[#frnd_comments#]</p><p>Thank you,<br> [#your_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;

$notification_email = apply_filters('templ_email_notifications_filter',$notification_email);  //wp-admin email notification content controller filter

//////////////////////////////////////////////////////////////////////////
$notification_msg = array();

$content = array();
$content['title'] = 'Post submission notification';
$content['content'] = array('post_added_success_msg_content','<p>Thank you, your post has been successfully submitted.</p><p><a href="[#submited_information_link#]" >View your submitted information &raquo;</a></p>
<p>Thank you for visiting us at [#site_name#].</p>');
$notification_msg[] = $content;

$content = array();
$content['title'] = 'Payment successfully received notification';
$content['content'] = array('post_payment_success_msg_content','<h4>Your payment has been received and your post is now published.</h4><p><a href="[#submited_information_link#]" >View your submitted information &raquo;</a></p>
<h5>Thank you for becoming a member at [#site_name#].</h5>');
$notification_msg[] = $content;

$content = array();
$content['title'] = 'Payment canceled notification';
$content['content'] = array('post_payment_cancel_msg_content','<h3>Your payment has been cancelled and your post is not published.</h3>
<h5>Thank you for visiting us at [#site_name#].</h5>');
$notification_msg[] = $content;

$content = array();
$content['title'] = 'Pre Bank Transfer Payment Success';
$content['content'] = array('post_pre_bank_trasfer_msg_content','<p>Thank you, your request has been received successfully.</p>
<p>To publish the property please transfer the amount of <u>[#payable_amt#] </u> at our bank with the following information :</p><p>Bank Name : [#bank_name#]</p><p>Account Number : [#account_number#]</p><br><p>Please include the ID as reference :#[#submition_Id#]</p><p><a href="[#submited_information_link#]" >View your submitted listing &raquo;</a>
<br><p>Thank you for visit at [#site_name#].</p>');
$notification_msg[] = $content;

$notification_msg = apply_filters('templ_msg_notifications_filter',$notification_msg);  //wp-admin message notification content controller filter
?>