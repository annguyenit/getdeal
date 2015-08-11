<?php get_header(); ?>
<?php $title = PAYMENT_SUCCESS_TITLE;
global $upload_folder_path,$transection_db_table_name,$last_postid,$did1;
global $user_baddr,$user_bcity,$user_bstate,$user_bcountry,$user_bphone,$user_bpostalcode,$user_saddr,$user_scity ,$user_sstate,$user_scountry,$user_spostalcode,$user_sphone;
global $wpdb,$current_user;
$user_db_table_name = get_user_table();
$transql = $wpdb->query("update $transection_db_table_name set status = '1' where trans_id = '".$_GET['atransid']."'");
$select_transql = $wpdb->get_row("select * from $transection_db_table_name where trans_id = '".$_GET['atransid']."' and status = '1' ");
$redirect_url = get_post_meta($select_transql->post_id,'thankyou_page_url',true);
$transifo=get_deal_trans_info($_GET['atransid']);
$filecontent = stripslashes(get_option('deal_payment_success_msg_content'));
if($_REQUEST['atransid'] !="" && $_REQUEST['did'] == $select_transql->post_id)
{
if($filecontent==""){
	$filecontent = __('<h4>Your payment received successfully and your Coupon information is as below</h4><p>[#deal_details#]</p><br>
<h5>Thank you for becoming a member at [#site_name#].</h5>');
}
	$site_name = get_option('blogname');
	$did1 = $_GET['atransid'];
	$min_purchase = get_post_meta($select_transql->post_id,'min_purchases',true);
	global $wpdb;
	$trans_tbl = $wpdb->prefix."deal_transaction";
	$trnsfordeal = $wpdb->get_results("select * from $trans_tbl where trans_id = '".$did1."'");
	$tpid = mysql_affected_rows(); 
			
if($transifo['deal_type']=='4' || $transifo['deal_type']=='5')
{  
	$coupon_address=get_post_meta($transifo['post_id'],'coupon_address',true);
	$trnsfordeal1 = $wpdb->get_results("select * from $trans_tbl where post_id = '".$select_transql->post_id."'");
	$countdeal =  count($trnsfordeal1);
	if($countdeal >= $min_purchase)
	{
		$transifo['deal_coupon'] = $transifo['deal_coupon']; 
	}else
	{
		$transifo['deal_coupon'] ="Coupon code will be made available after it reaches its purchase minimum limit"; 
	}
	if($coupon_address!="")
	{
		$transaction_details = sprintf(__("
		<p>".PAYMENT_DEAL." #%s\r</p>
		<p>".DEAL_TITLE_TEXT.": %s \r</p>
		<p>".DEAL_COUPON.": %s \r	</p>
		<p>".STORE_ADDRESS.": %s \r	</p>
		<p>Trans ID: %s\r</p>  <p>Status: %s\r</p>	<p>Date: %s\r</p>",'templatic'),$transifo['post_id'],$transifo['post_title'],$transifo['deal_coupon'],$coupon_address,$_GET['atransid'],'Success',date("Y-m-d",strtotime($transifo['payment_date'])));
	}
	else
	{
		
		if($tpid > 0)
		{
			$transaction_details = sprintf(__("
			<p>".PAYMENT_DEAL." #%s\r</p>
			<p>".DEAL_TITLE_TEXT.": %s \r</p>
			<p>".DEAL_COUPON.": %s \r	</p>
			<p>Trans ID: %s\r</p>  <p>Status: %s\r</p>	<p>Date: %s\r</p>",'templatic'),$transifo['post_id'],$transifo['post_title'],$transifo['deal_coupon'],$_GET['atransid'],'Success',date("Y-m-d",strtotime($transifo['payment_date'])));
		}else{
			$transaction_details = sprintf(__("
			<p>".PAYMENT_DEAL." #%s\r</p>
			<p>".DEAL_TITLE_TEXT.": %s \r</p>
			<p>".DEAL_COUPON.": %s \r	</p>
			<p>".INSTRUCTION."</p>
			<p>Trans ID: %s\r</p>  <p>Status: %s\r</p>	<p>Date: %s\r</p>",'templatic'),$transifo['post_id'],$transifo['post_title'],$_GET['atransid'],'Success',date("Y-m-d",strtotime($transifo['payment_date'])));
		}
	}
}
else
{
	$trnsfordeal1 = $wpdb->get_results("select * from $trans_tbl where post_id = '".$select_transql->post_id."'");
	$countdeal =  count($trnsfordeal1);

	if($countdeal >= $min_purchase)
	{
		$coupon_link = site_url()."/?ptype=voucher&transaction_id=".$transifo['trans_id'];
		$post_title_link ="<a href=".$coupon_link.">".$transifo['post_title']."</a>"; 
	}else
	{
		$post_title_link ="Coupon code will be made available after it reaches its purchase minimum limit"; 
	}
	
	if($countdeal >= $min_purchase)
	{
		$transifo['deal_coupon'] = $transifo['deal_coupon']; 
	}else
	{
		$transifo['deal_coupon'] ="Coupon code will be made available after it reaches its purchase minimum limit"; 
	}
	$coupon_link = site_url()."/?ptype=voucher&transaction_id=".$transifo['trans_id'];
	$post_title_link ="<a href=".$coupon_link.">".DEAL_COUPON_LINK."</a>"; 
	$link = "Coupon LInk";
	if($tpid > 0)
	{
		$transaction_details = sprintf(__("
		<p>".PAYMENT_DEAL." #%s\r	</p>
		<p>".DEAL_TITLE_TEXT.": %s \r</p>
		<p>".DEAL_COUPON.": %s \r	</p>
		<p>".$link.": %s \r	</p>
		<p>Trans ID: %s\r</p> <p>Status: %s\r</p>	<p>Date: %s\r</p>",'templatic'),$transifo['post_id'],$transifo['post_title'],$transifo['deal_coupon'],$post_title_link,$_GET['atransid'],'Success',date("Y-m-d",strtotime($transifo['payment_date'])));
	}else{
		$transaction_details = sprintf(__("
		<p>".PAYMENT_DEAL." #%s\r	</p>
		<p>".DEAL_TITLE_TEXT.": %s \r</p>
		<p>".DEAL_COUPON.": %s \r	</p>
		<p>".$link.": %s \r	</p>
		<p>".INSTRUCTION."</p>
		<p>Trans ID: %s\r</p>  <p>Status: %s\r</p>	<p>Date: %s\r</p>",'templatic'),$transifo['post_id'],$transifo['post_title'],$_GET['atransid'],'Success',date("Y-m-d",strtotime($transifo['payment_date'])));
	}
}
$search_array = array('[#deal_details#]','[#site_name#]');
$replace_array = array($transaction_details,$site_name);
$filecontent = str_replace($search_array,$replace_array,$filecontent);
$transql = $wpdb->query("update $transection_db_table_name set status = '1' where trans_id = '".$_GET['atransid']."'");
?>
<?php
global $wpdb,$current_user;
$fromEmail = get_site_emailId();
$fromEmailName = get_site_emailName();
$seller_name = get_post_meta($transifo['post_id'],'owner_name',true);
$seller_email = get_post_meta($transifo['post_id'],'owner_email',true);
if($current_user->ID == "")
{
		$user_qry = "select * from $user_db_table_name order by ID desc limit 0,1";
		$users = $wpdb->get_row($user_qry);
		$buyer_email = $users->user_email;
		$buyer_name = $users->display_name;
		$user_id = $users->ID;
}
else
{
		$buyer_email = $current_user->user_email;
		$buyer_name = $current_user->display_name;
		$user_id = $current_user->ID;
}
$deal_title = $transifo['post_title'];
$subject = sprintf(BUY_NOW_SUBJECT,$deal_title);
$buyer_subject = "You have just purchased the deal: ". $deal_title;
$admin_subject = sprintf(BUY_NOW_ADMIN_SUBJECT,$deal_title);
if(get_option('pttthemes_send_mail') == 'Enable' || get_option('pttthemes_send_mail') == '') {
templ_sendEmail($fromEmail,$fromEmailName,$fromEmail,$fromEmailName,$admin_subject,$filecontent,$extra='');
templ_sendEmail($fromEmail,$fromEmailName,$seller_email,$seller_name,$subject,$filecontent,$extra='');
templ_sendEmail($fromEmail,$fromEmailName,$buyer_email,$buyer_name,$buyer_subject,$filecontent,$extra='');
}
?>


<?php if ( get_option( 'ptthemes_breadcrumbs' )) {
$sep_array = get_option('yoast_breadcrumbs');
$sep = $sep_array['sep'];
  ?>
<div class="breadcrumb clearfix">
    <div class="breadcrumb_in"><?php yoast_breadcrumb('',' '.$sep.' '.$title);  ?></div>
</div>
<?php } ?>
<h1 class="singleh1"><?php echo $title;?></h1>   

<div class="content left">
        <div class="post-content">
		
			<?php 
			if($_GET['show']==1){
			echo $filecontent; 
			}else{
				echo $filecontent; 
			?>
			<a href="<?php echo get_author_posts_url($user_id); ?>"><?php echo BUY_NOW_CLICK_LINK;?></a>
            <?php }?>
			</div>
 </div> <!-- /Content -->
                            
<div class="sidebar right" >
   
  <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Article Listing Sidebar Right')){?> <?php } else {?>  <?php }?>
   
</div>  <!-- sidebar #end --> 
<?php
} ?>

<?php
if($_REQUEST['cancel_id'] != ""){ ?>

<h1 class="singleh1"><?php echo "Payment has been cancel";?></h1>   

<div class="content left">
        <div class="post-content">
<?php
	$filecontent = stripslashes(get_option('post_payment_cancel_msg_content'));
	$post_link=get_permalink($_REQUEST['pid']);
	$store_name = "<a href=".site_url('/').">".get_option('blogname')."</a>";
	$search_array = array('[#order_amt#]','[#bank_name#]','[#account_number#]','[#orderId#]','[#site_name#]','[#submited_information_link#]');
	$replace_array = array($paid_amount,$bankInfo,$accountinfo,$order_id,$store_name,$post_link);
	$filecontent = str_replace($search_array,$replace_array,$filecontent);
	if($filecontent==""){
		$filecontent = DEAL_CANCEL_TEXT;
	}else{
		echo $filecontent;
	}
	$select_transql = $wpdb->query("delete from $transection_db_table_name where trans_id = '".$_REQUEST['cancel_id']."' "); ?>
</div>
</div>
	<?php }?>


  
<?php get_footer(); ?>
<?php
if($redirect_url != '') { ?>
<script type="text/javascript">
setTimeout("location.href='<?php echo $redirect_url;?>'", 3000);
</script>
<?php } ?>