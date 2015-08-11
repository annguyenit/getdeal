<?php
global $Cart,$General,$wpdb,$prd_db_table_name,$transection_db_table_name;
global $upload_folder_path;
$orderId = $_GET['trans_id'];

$ordersql = "select * from $transection_db_table_name where trans_id=\"$orderId\"";
$orderinfo = $wpdb->get_results($ordersql);
if($orderinfo)
{
	foreach($orderinfo as $orderinfoObj)
	{
	}
}
	if($_POST['act'] && $_REQUEST['trans_id']) // update order 
	{
	$issendEmail = 0;
	if($orderinfoObj->status != $_POST['status'] && ($_POST['status']=='reject' || $_POST['status']=='approve' || $_POST['status']=='shipping' || $_POST['status']=='delivered') && ($General->is_send_order_approval_email_wpadmin() || $General->is_send_order_reject_email_wpadmin() || $General->is_send_order_shipping_email_wpadmin() || $General->is_send_order_delivered_email_wpadmin()))
	{
		$issendEmail = 1;
	}
	$wpdb->query("update $transection_db_table_name set status='".$_POST['status']."', ord_desc_admin='".addslashes($_POST['ocomments'])."' where trans_id='".$_REQUEST['trans_id']."'");
	$display_message = "Order updated successfully.";
	if($issendEmail)
	{
		$ordersql = "select * from $transection_db_table_name where trans_id=\"$orderId\"";
		$orderinfo = $wpdb->get_results($ordersql);
		if($orderinfo)
		{
			foreach($orderinfo as $orderinfoObj)
			{
			}
		}
		$fromEmail = $General->get_site_emailId();
		$fromEmailName = $General->get_site_emailName();
		$subject_default = "Order ".$_POST['status'] ." Email, Order Number:#".$_REQUEST['trans_id'];
		$message = "";
		global $wpdb,$transection_db_table_name;
		$trans_id = $_REQUEST['trans_id'];
		$user_info = "select u.user_email,u.display_name from $wpdb->users u join $transection_db_table_name ot on ot.uid=u.ID and ot.trans_id=\"$trans_id\"";
		$user_info_arr = $wpdb->get_results($user_info);
		if($user_info_arr)
		{
			$toEmailName = $user_info_arr[0]->display_name;
			$toEmail = $user_info_arr[0]->user_email;
		}
		///////////admin email//////////
		if($_POST['status']=='approve')
		{
			$subject = get_option('order_approval_client_email_subject');
			$admin_message = get_option('order_approval_client_email_content');
		}elseif($_POST['status']=='shipping')
		{
			$subject = get_option('order_shipping_client_email_subject');
			$admin_message = get_option('order_shipping_client_email_content');
		}elseif($_POST['status']=='delivered')
		{
			$subject = get_option('order_shipping_client_email_subject');
			$admin_message = get_option('order_shipping_client_email_content');
		}elseif($_POST['status']=='reject')
		{
			$subject = get_option('order_rejection_client_email_subject');
			$admin_message = get_option('order_rejection_client_email_content');
		}
		$order_info = $General->get_order_detailinfo_tableformat($_REQUEST['trans_id']);
		$store_name = $fromEmailName;
		$search_array = array('[#$user_name#]','[#$to_name#]','[#$order_info#]','[#$store_name#]');
		$replace_array = array($orderinfoObj->billing_name,$orderinfoObj->billing_name,$order_info,$store_name);
		$client_message = apply_filters('order_approved_admin_email_content_filter',str_replace($search_array,$replace_array,$admin_message));
		if($_POST['status']=='approve' && $General->is_send_order_approval_email_wpadmin()){
			$General->sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$client_message,$extra='');///approve/reject email			
		}elseif($_POST['status']=='shipping'){
			$General->sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$client_message,$extra='');///approve/reject email	
		}elseif($_POST['status']=='delivered'){
			$General->sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$client_message,$extra='');///approve/reject email	
		}else
		if($_POST['status']=='reject' && $General->is_send_order_reject_email_wpadmin())
		{
			$General->sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$client_message,$extra='');///approve/reject email	
		}
		
		
		///AFFILIATE START//
		if($General->is_active_affiliate() && $General->is_send_order_app_aff_email_wpadmin())
		{
			if($_POST['status']=='approve')  // send affiliate email
			{
				$aid = $orderinfoObj->aff_uid;
				if($aid)
				{
					$usersql = "SELECT user_nicename,user_email FROM $wpdb->users WHERE ID=\"$aid\"";
					$userinfo = $wpdb->get_results($usersql);
					$toEmailName = $userinfo[0]->user_nicename;
					$toEmail = $userinfo[0]->user_email;
					$user_affiliate_data = get_usermeta($aid,'user_affiliate_data');
					$cart_amt = str_replace(',','',$orderinfoObj->cart_amount);
					foreach($user_affiliate_data as $key => $val)
					{
						$share_amt = ($cart_amt*$val['share_amt'])/100;
					}			
					
					$product_name = $wpdb->get_var("select group_concat(p.post_title) from $wpdb->posts p join $prd_db_table_name op on op.pid=p.ID where op.trans_id='".$_REQUEST['trans_id']."'");
					$product_qty = $wpdb->get_var("select sum(prd_qty) from $prd_db_table_name where trans_id='".$_REQUEST['trans_id']."'");
					
					$subject = __('Your Affiliate Sale');
					$aff_message = __('
					<p>Dear '.$toEmailName.',</p>
					<p>
					New sale has been made by your affiliate link and<br />
					commission credited to your balance.<br />
					</p>
					<p>
					You may find sale details below:
					</p>
					<p>----</p>
					<p>Transaction Id : '.$orderinfoObj->trans_id.'</p>
					<p>Order Amount :       '.$General->get_amount_format($orderinfoObj->cart_amount).'</p>
					<p>Qty :       '.$product_qty.'</p>
					<p>Product ordered: '.$product_name.'</p>
					<p>Your commission: '.$General->get_amount_format($share_amt).'</p>
					<p>----</p>
					');
					$General->sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$aff_message,$extra='');///To affiliate email
				}
			}
		}
		///AFFILIATE END///
		
	}
	wp_redirect("admin.php?page=affiliates&trans_id=".$_REQUEST['oid']."&msg=success#option_order");
}
 ?>
 
 <div id="wrapper">
 <div class="titlebg">
    <span class="head i_order_detail"><?php _e('Order Details of Order'); ?> - <?php echo $_GET['oid'];?></span>  
     <a href="javascript:vtrans_id(0);" onclick="print();" title="Print Order" class="print_order" style="float:right; "><img src="<?php echo get_template_directory_uri(); ?>/images/printer.png" alt="print order" /></a>
    
 </div> <!-- sub heading -->
 <div id="page" >

<table width="100%" style="border:0px;" >
<tr><td>
<?php if($orderinfoObj->aff_uid>0){
	$uid = $orderinfoObj->aff_uid;
	$username = $wpdb->get_var("select display_name from $wpdb->users where ID=\"$uid\"");
	?>
<div style="width:50%; float:left;"><?php _e('Affiliate Info. : ');?><a href="<?php echo site_url()?>/wp-admin/admin.php?page=affiliates_settings&user_id=<?php echo $orderinfoObj->aff_uid;?>"><?php echo $username;?></a> (<?php echo $orderinfoObj->aff_commission;?>%)</div>
<?php }?>
<?php if($orderinfoObj->ip_address){?>
<div style="width:50%; float:right;"><?php _e('Order Request IP Address : ','templatic'); echo $orderinfoObj->ip_address;?></div>
<?php }?>
</td></tr>
<?php if($_REQUEST['msg']=='success'){?>
<tr>
  <td style="color:#FF0000;"><?php _e('Order status changed successfuly','templatic');?></td>
</tr>
<?php }?>
<tr>
  <td><table width="100%" class="order_details">
      <tr>
        <td cellpadding="5" ><?php 
		$orderId = $_REQUEST['oid'];
		echo get_order_detailinfo_tableformat($orderId);?> </td>
      </tr>
      <tr>
        <td><form action="<?php echo site_url("/wp-admin/admin.php?page=affiliates&amp;trans_id=".$_GET['trans_id']);?>#option_orders" method="post">
            <input type="hidden" name="act" value="orderstatus">
            <table width="75%" class="widefat post" >
              <tr>
                <td width="10%"><strong><?php _e('Order Status'); ?> :</strong></td>
                <td width="90%">

                <select name="status">
                    <option value="pending" <?php if($orderinfoObj->status=='0'){?> selected<?php }?>><?php echo ORDER_PROCESSING_TEXT;?></option>
                    <option value="approve" <?php if($orderinfoObj->status=='1'){?> selected<?php }?>><?php echo ORDER_APPROVE_TEXT;?></option>
                    <option value="reject" <?php if($orderinfoObj->status=='2'){?> selected<?php }?>><?php echo ORDER_REJECT_TEXT;?></option>
                   
                  </select></td>
              </tr>
              <tr>
                <td><strong><?php _e('Comments','templatic'); ?>:</strong></td>
                <td><textarea name="ocomments" cols="70"><?php echo stripslashes($orderinfoObj->ord_desc_admin);?></textarea></td>
              </tr>
              <tr>
                <td></td>
                <td><input type="submit" name="submit" value="<?php _e('Update'); ?>" class="button-secondary action" ></td>
              </tr>
            </table>
          </form></td>
      </tr>
      <tr>
        <td><a href="<?php echo site_url("/wp-admin/admin.php?page=affiliates#option_orders");?>"><strong><?php _e('Back to Orders Listing'); ?></strong></a></td>
      </tr>
     </table>
     </td></tr></table>	
</div> <!-- page #end -->
 </div>   <!-- wrapper #end -->