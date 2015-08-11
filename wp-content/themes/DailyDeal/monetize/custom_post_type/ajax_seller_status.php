<?php 
	$file = dirname(__FILE__);
	$file = substr($file,0,stripos($file, "wp-content"));
	require($file . "/wp-load.php");
	global $wpdb;
	$seller_entry_table = $wpdb->prefix."deal_entry";
	$statusdeal = trim($_REQUEST['dealstatus']);
	$statusid= trim($_REQUEST['statusid']);
	$deletedeal = trim($_REQUEST['dealdelete']);
	$dealmore = trim($_REQUEST['dealmore']);
	$terminateid = trim($_REQUEST['terminateid']);
	if((isset($_REQUEST['dealstatus'])) || ($_REQUEST['dealstatus'] != 0))
	{
		if($statusid == '1')
		{	
		    $selectifexist = $wpdb->get_row("select * from $seller_entry_table where is_expired = '0' and status= '1'");
			if(mysql_affected_rows() > 0)
			{ 
				$updateseller_req = $wpdb->query("update $seller_entry_table set status = '1' where deal_id='".$statusdeal."'");
				$updateseller_req = $wpdb->query("update $seller_entry_table set status = '3' where deal_id='".$terminateid."'");				
				fetch_newstatus($statusid,'0');
				seller_accept_deal($statusdeal);
			}else{
				$selectifexist = $wpdb->get_row("select * from $seller_entry_table where is_expired = '1' and status= '1'");
				$updateseller_req = $wpdb->query("update $seller_entry_table set status = '".$statusid."' where deal_id='".$statusdeal."'");	
				fetch_newstatus($statusid,$selectifexist->is_expired);
			}
		}else{
			$updateseller_req = $wpdb->query("update $seller_entry_table set status = '".$statusid."' where deal_id='".$statusdeal."'");	
			fetch_newstatus($statusid,'0');
			if($statusid =='1')
			{
				seller_accept_deal($statusdeal);
			}elseif($statusid =='2')
				seller_reject_deal($statusdeal);
			}
		}

	
	if((isset($_REQUEST['dealdelete'])) || ($_REQUEST['dealdelete'] != 0))
	{
		
		$wpdb->query("delete from $seller_entry_table where deal_id = '".$deletedeal."'"); 
		echo "<script> location.href ='admin.php?page=seller&dealreq=deleted';</script>";
		
	}
	
	if((isset($_REQUEST['dealmore'])) || ($_REQUEST['dealmore'] != 0))
	{	
		$counter = 0;
		$countdeals = explode(',',$dealmore);
 		for($d= 0; $d <= count($countdeals); $d ++)
		{
			$wpdb->query("delete from $seller_entry_table where deal_id = '".$countdeals[$d]."'");
			$count = $counter ++;
		}  
		echo "<script>location.href = 'admin.php?page=seller&dealreq=deleted';</script>";
		
	}
	
	if(isset($_REQUEST['allowedit']) || $_REQUEST['allowedit'] != "")
	{
		$tbldealsetup = $wpdb->prefix."deal_setup";
		$wpdb->query("Update $tbldealsetup set allow_edit = '".$_REQUEST['allowedit']."' where ID='1'");
		echo "Updated";
	}
	function fetch_newstatus($sid,$isexpired)
	{	
		if($sid == '0')
		{
			echo "<span class='color_pending'>Pending</span>";
		}elseif($sid == '1')
		{
			if($isexpired == '1')
			{
			echo "<span class='color_expire'>Expired</span>";
			}else
			{
			echo "<span class='color_active'>Active<span>";
			}
		}
		elseif($sid == '2')
		{
			echo "<span class='color_reject'>Rejected<span>";
		}elseif($sid == '3')
		{
			echo "<span class='color_terminate'><b>Terminated</b><span>";
		}elseif($sid == '4')
		{
			echo "<span class=color_schedule'><b>Scheduled</b><span>";
		}
	}
?>
<?php
/*-------Email sent to seller : for accept request --------*/

function seller_accept_deal($deal_id)
{
	global $wpdb;
	/*-------Fetch Email details --------*/
	$email_table = $wpdb->prefix."email_setup";
	$email_data = $wpdb->get_row("select * from $email_table where eid='1412'");
	/*-------Fetch Seller data--------*/
	$deal_table = $wpdb->prefix."deal_entry";
	$deal_id='5';	
	$deal_data = $wpdb->get_row("select * from $deal_table where deal_id='".$deal_id."'");
	/*-------Fetch LOgin data--------*/
	$user_table = $wpdb->prefix."users";
	$user_name= $deal_data->owner_name;
	$user = $wpdb->get_row("select * from $user_table where user_login='".$user_name."'");
	
	$to_name = $deal_data->owner_name;
	$to_email = $deal_data->owner_email;
	$start_date = htmlspecialchars_decode(date('F d,Y H:i:s',$deal_data->coupon_start_date_time));
	$end_date = htmlspecialchars_decode(date('F d,Y H:i:s',$deal_data->coupon_end_date_time));
	$deal_details = "<b>Title : </b>".$deal_data->post_title."<br/><br/>"."<b>Duration : </b>".$start_date." to ".$end_date."<br/><br/>"."<b>Your price : </b>".get_currency_sym().$deal_data->our_price."<br/><br/>"."<b>Current price : </b>".get_currency_sym().$deal_data->current_price."<br/><br/>"."<b>Total Items :</b>".$deal_data->no_of_coupon."<br/><br/><b>Coupon code :</b>".$deal_data->coupon_code;
	$login_details = "<b>Seller details</b><br/>"."<b>User name :</b>".$user->user_login."<br/><b>Email :</b>".$user->user_email;
	
	$senderemail = $email_data->senderemail;
	$sendersub = $email_data->seller_deal_accept_sub;
	$sendercontent = $email_data->seller_deal_accept_content;
	
	$smessage1 = str_replace("[#to_name#]",$to_name.",",$sendercontent ) ;
	$smessage2 = str_replace("[#deal_details#]",$deal_details,$smessage1);
	$smessage3 = str_replace("[#site_name#]","http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],$smessage2);
	$seller_message = str_replace("[#seller_details#]",$login_details,$smessage3);
	$headers = "From :".$senderemail."\r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	
	$mail_success = @mail($to_email,$sendersub,$seller_message,$headers);
}
/*-------Email sent to seller : for reject request --------*/

function seller_reject_deal($deal_id)
{
	global $wpdb;
	/*-------Fetch Email details --------*/
	$email_table = $wpdb->prefix."email_setup";
	$email_data = $wpdb->get_row("select * from $email_table where eid='1412'");
	/*-------Fetch Seller data--------*/
	$deal_table = $wpdb->prefix."deal_entry";
	$deal_id='5';	
	$deal_data = $wpdb->get_row("select * from $deal_table where deal_id='".$deal_id."'");
	
	$to_name = $deal_data->owner_name;
	$to_email = $deal_data->owner_email;
	
	$senderemail = $email_data->senderemail;
	$sendersub = $email_data->seller_deal_reject_sub;
	$sendercontent = $email_data->seller_deal_reject_content;
	
	$smessage1 = str_replace("[#to_name#]",$to_name.",",$sendercontent ) ;
	$seller_message = str_replace("[#site_name#]","http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],$smessage1);
	
	$headers = "From :".$senderemail."\r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	
	$mail_success = @mail($to_email,$sendersub,$seller_message,$headers);
}


?>
