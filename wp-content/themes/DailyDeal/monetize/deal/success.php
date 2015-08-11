<?php 
get_header(); 
global $wpdb,$upload_folder_path,$transection_db_table_name,$last_postid,$is_login;
$select_transql = $wpdb->get_row("select * from $transection_db_table_name where trans_id = '".$_GET['pid']."' ");
$is_login = $_REQUEST['is_login'];
$paymentmethod = $select_transql->payment_method;
$paid_amount = get_currency_sym().number_format($select_transql->payable_amt,2);
$redirect_url = get_post_meta($select_transql->post_id,'thankyou_page_url',true);
$fromEmail = get_site_emailId();
$fromEmailName = get_site_emailName();
$paymentupdsql = "select option_value from $wpdb->options where option_name ='payment_method_".$paymentmethod."'";
	$paymentupdinfo = $wpdb->get_results($paymentupdsql);
	if($paymentupdinfo){
		foreach($paymentupdinfo as $paymentupdinfoObj)	{
			$option_value = unserialize($paymentupdinfoObj->option_value);
			$name = $option_value['name'];
			$option_value_str = serialize($option_value);
		}
	}

if($is_login == 'N'){
		$new_user = NEW_USER_SUCCESS;
	}
$buyer_information = "<div style='line-height:30px;'>
		<div style='float:left;width:350px;'>
		<lable><strong>".BILLING_NAME."</strong></lable> : ".$select_transql->billing_name."<br />
		<lable><strong>".BILLING_ADDRESS."</strong></lable> : ".$select_transql->billing_add."<br />
		</div>
		<div style='float:left;'>
		<lable><strong>".SHIPPING_NAME."</strong></lable> : ".$select_transql->shipping_name."<br />
		<lable><strong>".SHIPPING_ADDRESS."</strong></lable> : ".$select_transql->shipping_add."<br />
		</div><div style='clear:both'>&nbsp;</div>
		<lable><strong>".PAYMET_MODE."</strong></lable> : ".$name."<br />
	</div>";

if($paymentmethod == 'prebanktransfer')
{
	$filecontent = stripslashes(get_option('post_pre_bank_trasfer_msg_content'));
	if($filecontent==""){
	$filecontent = __('<p>Thanks you, your information has been successfully received.</p><p>Kindly transfer amount of <u>[#payable_amt#] </u> to our bank. Our bank account details are mentioned below.</p>
<p>Bank Name : [#bank_name#]</p><p>Account Number : [#account_number#]</p><br><p>Please include the following reference : [#submition_Id#]</p><h5 class="title">View your submitted information : </h5>'.$new_user.$buyer_information.'<br /><p>Thank you for visiting us at [#site_name#].</p>','templatic');
	}
}else {
	
	//$filecontent = stripslashes(get_option('post_added_success_msg_content'));
	if($filecontent==""){
		$filecontent=__('<p>Thank you, your for buying a deal. Now go to your <a href="'.get_author_posts_url($select_transql->user_id).'">dashboard</a> to view transaction report and to download files in case you bought a digital product.</p><h5 class="title">View your submitted information : </h5><br />'.$new_user.$buyer_information.'<br /><p>Thank you for visiting us at [#site_name#].</p>','templatic');
	}
}
if($_REQUEST['paydeltype'] != 'prebanktransfer' && $_REQUEST['paydeltype'] != 'payondelevary'){
$transql = $wpdb->query("update $transection_db_table_name set status = '1' where trans_id = '".$_GET['pid']."'");
}
if ( get_option( 'ptthemes_breadcrumbs' )) {  
$sep_array = get_option('yoast_breadcrumbs');
$sep = $sep_array['sep'];
?>
    <div class="breadcrumb clearfix">
        <div class="breadcrumb_in"><?php yoast_breadcrumb('',' '.$sep.' You just bought a deal');  ?></div>
    </div>
<?php } ?>


         
   <h1 class="singleh1"><?php echo BUYNOW_TITLE;?></h1>
   

 <div class="content left">
        <div class="post-content">
       
             <?php
$store_name = get_option('blogname');
if($paymentmethod == 'prebanktransfer')
{
	$paymentupdsql = "select option_value from $wpdb->options where option_name='payment_method_".$paymentmethod."'";
	$paymentupdinfo = $wpdb->get_results($paymentupdsql);
	$paymentInfo = unserialize($paymentupdinfo[0]->option_value);
	$payOpts = $paymentInfo['payOpts'];
	$bankInfo = $payOpts[0]['value'];
	$accountinfo = $payOpts[1]['value'];
}
$post_link = get_author_posts_url($select_transql->user_id);	


$orderId = $_REQUEST['pid'];
$search_array = array('[#payable_amt#]','[#bank_name#]','[#account_number#]','[#submition_Id#]','[#site_name#]','[#submited_information_link#]','[#admin_email#]');
$replace_array = array($paid_amount,$bankInfo,$accountinfo,$last_postid,$store_name,$post_link,$fromEmail);
$filecontent = str_replace($search_array,$replace_array,$filecontent);
echo $filecontent;
?> 
             
        </div>
 </div> <!-- /Content -->
                            
    <div class="sidebar right" >
       
      <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Article Listing Sidebar Right')){?> <?php } else {?>  <?php }?>
       
    </div>  <!-- sidebar #end -->
<!--Page 2 column - Right Sidebar #end  -->

<script type="text/javascript" language="javascript" >
var root_path_js = '<?php echo get_option('siteurl')."/";?>';
</script>
<script type="text/javascript" language="javascript" src="<?php bloginfo('template_directory'); ?>/library/js/article_detail.js" ></script>
<?php include_once (TEMPLATEPATH . '/monetize/send_to_friend/popup_frms.php');?> 
<?php get_footer(); if($redirect_url != '') { ?>
<script type="text/javascript">
setTimeout("location.href='<?php echo $redirect_url;?>'", 3000);
</script>
<?php }?>