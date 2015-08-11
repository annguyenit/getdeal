<?php get_header(); 
?>
<div  class="<?php templ_content_css();?>" >
<?php
global $current_user,$transection_db_table_name, $wpdb;;
if(isset($_GET['author_name'])) :
	$curauth = get_userdatabylogin($author_name);
else :
	$curauth = get_userdata(intval($author));
endif;
?>
<?php templ_page_title_above(); //page title above action hook?>
<div class="content-title"> 
<h1><?php _e('Success ','templatic');?></h1>

</div>
<div class="deal_steps step3bg">
                    	<ul>
                        	<li class="current"><?php echo BUY_STEP_1;?></li>
                            <li class="step2 current"><?php echo BUY_STEP_2;?></li>
                            <li class="step3 current" ><?php echo BUY_STEP_3;?></li>
                        </ul>
                    </div>
<?php if(isset($_REQUEST['edit_success']) || $_REQUEST['edit_success'] != "" ) { ?>
<p class="error"><?php _e(SUCCESS_EDIT_DEAL,'templatic');?></p>
<?php }else { 
// Start All Transection Details With Deal
	$deal_title = $_SESSION['post_title'];
	$deal_desc = $_SESSION['post_content'];
	
	$coupon_website = $_SESSION['coupon_website'];
	$no_of_coupon = $_SESSION['no_of_coupon'];
	$our_price = $_SESSION['our_price'];
	$current_price =$_SESSION['current_price'];
	$coupon_type = $_SESSION['coupon_type'];
	$coupon_address = $_SESSION['coupon_address'];
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
	if($coupon_address!="")	{
		$deal_detail = sprintf(__("
			<h5 class='title'>".DEAL_DETAILS_TEXT."</h5>
			<ul>
			<li><strong>".DEAL_TITLE_TEXT.": </strong>%s  	</li>
 			<li><strong>".DEAL_CONTENT_TEXT.":</strong> %s 	</li>	
 			<li><strong>".NO_OF_ITEMS.":</strong> %s 	</li>	
			<li><strong>".DEAL_TYPE.":</strong> %s </li>	
			<li><strong>".DEAL_CPRICE_TEXT.": </strong>%s </li>	
			<li><strong>".DEAL_YOUR_PRICE_TEXT.": </strong>%s </li>	
			<li><strong>".STORE_ADDRESS.": </strong>%s </li>	
		</ul>
			",'templatic'),$deal_title,$deal_desc,$no_of_coupon,get_currency_sym().$current_price,get_currency_sym().$our_price,$current_price,$coupon_address);
	} else	{
		$deal_detail = sprintf(__("
			<h5 class='title'>".DEAL_DETAILS_TEXT."</h5>
			<ul>
			<li><strong>".DEAL_TITLE_TEXT.": </strong>%s  	</li>
 			<li><strong>".DEAL_CONTENT_TEXT.":</strong> %s 	</li>	
 			<li><strong>".NO_OF_ITEMS.":</strong> %s 	</li>	
			<li><strong>".DEAL_TYPE.":</strong> %s </li>	
			<li><strong>".DEAL_CPRICE_TEXT.": </strong>%s </li>	
			<li><strong>".DEAL_YOUR_PRICE_TEXT.": </strong>%s </li>	
		</ul>
			",'templatic'),$deal_title,$deal_desc,$no_of_coupon,$coupon_type,get_currency_sym().$current_price,get_currency_sym().$our_price);
		}
		
	// End All Transection Details With Deal
?>
<div class="post-content">
<div ><?php 
if($current_user->data->ID == "") {

$fromEmail = get_site_emailId();
$site_name = get_option('blogname');
$search_array = array('[#user_email#]','[#admin_email#]','[#blog_name#]','[#deal_detail#]');
$replace_array = array($_SESSION['owner_email'] ,$fromEmail,$site_name,$deal_detail);
$filecontent = str_replace($search_array,$replace_array,SUCCESS_NEW_USER_DEAL);	
_e($filecontent,'templatic');
} else {
$fromEmail = get_site_emailId();
$site_name = get_option('blogname');
$search_array = array('[#user_email#]','[#admin_email#]','[#blog_name#]','[#deal_detail#]');
$replace_array = array($_SESSION['owner_email'] ,$fromEmail,$site_name,$deal_detail);
$filecontent = str_replace($search_array,$replace_array,SUCCESS_DEAL);	
_e($filecontent,'templatic');

}?></div>
<?php } ?>
</div>

<?php templ_page_title_below(); //page title below action hook?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
