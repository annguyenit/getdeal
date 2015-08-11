<?php 
global $wpdb;
if($_REQUEST['editdeal'] != ''){
	$editid = $_REQUEST['editdeal'];
	$edit_deal = get_post($editid);
} 
if(isset($_REQUEST['deal']) || $_REQUEST['deal'] !="" || isset($_REQUEST['emsg']) || $_REQUEST['emsg'] !="" ) {
	
	session_start();
	$dealsession = $_REQUEST['deal'];
	$coupon_start_date_time = date("Y-m-d H:i:s",$_SESSION['coupon_start_date_time']);
	$coupon_start_date_time_arry = explode(" ",$coupon_start_date_time);
	$coupon_end_date_time = date("Y-m-d H:i:s",$_SESSION['coupon_end_date_time']);
	$coupon_end_date_time_arry = explode(" ",$coupon_end_date_time);
} else{
	session_unset($dealsession);
	$tbldeal = $wpdb->prefix."posts";
	$edit_deal1 = $wpdb->get_row("select * from $tbldeal where ID = '".$_REQUEST['editdeal']."'");
	$coupon_start_date_time = date("Y-m-d H:i:s",get_post_meta($edit_deal1->ID,'coupon_start_date_time',true));
	$coupon_start_date_time_arry = explode(" ",$coupon_start_date_time);
	$coupon_end_date_time = date("Y-m-d H:i:s",get_post_meta($edit_deal1->ID,'coupon_end_date_time',true));
	$coupon_end_date_time_arry = explode(" ",$coupon_end_date_time);
}
if($coupon_start_date_time_arry[0]!="" && $coupon_start_date_time_arry[0]!="1970-01-01") {	
	    $coupon_start_date = $coupon_start_date_time_arry[0];
		$coupon_start_time = explode(":",$coupon_start_date_time_arry[1]);
		$coupon_start_time_hh = $coupon_start_time[0];
		$coupon_start_time_mm = $coupon_start_time[1];
		$coupon_start_time_ss = $coupon_start_time[2];
}else{
	$coupon_start_date = date('Y-m-d');
}
if($coupon_end_date_time_arry[0]!="" && $coupon_end_date_time_arry[0]!="1970-01-01") {
	$coupon_end_date = $coupon_end_date_time_arry[0];
	$coupon_end_time = explode(":",$coupon_end_date_time_arry[1]);
	$coupon_end_time_hh = $coupon_end_time[0];
	$coupon_end_time_mm = $coupon_end_time[1];
	$coupon_end_time_ss = $coupon_end_time[2];
} else {
	$coupon_end_date = date('Y-m-d');
}
ob_start();
get_header();?>
<script>var rootfolderpath = "<?php bloginfo('template_directory'); ?>/images/";</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/monetize/deal/post_deal_validation.js"></script>
<?php 
function get_date_format() {
	global $wpdb;
	$tbl_option = $wpdb->prefix."options";
	$getDate = $wpdb->get_row("select * from  $tbl_option where option_name like 'ptthemes_date_format' ");
	if($getDate == "" ) {
		$getDate = "yyyy - mm - dd";
	} else	{
		$getDate = $getDate->option_value;
	}
	return $getDate;
}
$destination_path = site_url().'/wp-content/uploads/';

?>

<script type="text/javascript">
function coupon_change_type(ctype)
{
	if(ctype=='1')
	{  		
	
		document.getElementById('afflink').style.display = "block";
		
		document.getElementById('coupon_entry').style.display = "none";
		document.getElementById("no_of_coupons").style.display = "none";
		document.getElementById('multicode').style.display = "none";
		document.getElementById('singlecode').style.display = "none";
		document.getElementById('shipping_details').style.display = "none";
		document.getElementById('shippingdiv').style.display = "none";
		
		document.getElementById('descdiv').innerHTML = '<?php echo DEAL_TYPE1_DESC;?>'; 
	}
	if(ctype=='2')
	{
		document.getElementById('media_upload').style.display = "block";
		document.getElementById('coupon_entry').style.display = "none";
		document.getElementById("no_of_coupons").style.display = "none";
		document.getElementById('multicode').style.display = "none";
		document.getElementById('singlecode').style.display = "none";
		document.getElementById('afflink').style.display = "none";
		document.getElementById('shipping_details').style.display = "none";
		document.getElementById('shippingdiv').style.display = "none";
		document.getElementById('descdiv').innerHTML = '<?php echo DEAL_TYPE2_DESC;?>'; 
	}
	if(ctype=='3')
	{
		document.getElementById('coupon_entry').style.display = "block";
		document.getElementById("no_of_coupons").style.display = "none";
		document.getElementById('multicode').style.display = "none";
		document.getElementById('afflink').style.display = "none";
		document.getElementById('singlecode').style.display = "none";
		document.getElementById('media_upload').style.display = "none";
		document.getElementById('shipping_details').style.display = "none";
		document.getElementById('shippingdiv').style.display = "none";
		document.getElementById('descdiv').innerHTML = '<?php echo DEAL_TYPE3_DESC;?>'; 
	}
	if(ctype=='4')
	{
		document.getElementById('coupon_entry').style.display = "block";
		document.getElementById('shipping_details').style.display = "block";
		document.getElementById("no_of_coupons").style.display = "none";
		document.getElementById('multicode').style.display = "none";
		document.getElementById('afflink').style.display = "none";
		document.getElementById('singlecode').style.display = "none";
		document.getElementById('media_upload').style.display = "none";
		document.getElementById('shippingdiv').style.display = "block";
		document.getElementById('descdiv').innerHTML = '<?php echo DEAL_TYPE4_DESC;?>'; 
	}if(ctype=='0')
	{
		document.getElementById('coupon_entry').style.display = "block";
		document.getElementById('shipping_details').style.display = "block";
		document.getElementById("no_of_coupons").style.display = "none";
		document.getElementById('multicode').style.display = "none";
		document.getElementById('afflink').style.display = "none";
		document.getElementById('singlecode').style.display = "none";
		document.getElementById('shippingdiv').style.display = "none";
		document.getElementById('media_upload').style.display = "none";
		//document.getElementById('descdiv').innerHTML = ''; 
	}
	
	if(ctype == 'coupon_entry_0')
	{
		document.getElementById('singlecode').style.display = "block";
		document.getElementById('coupon_entry').style.display = "block";
		document.getElementById("no_of_coupons").style.display = "none";
		document.getElementById('multicode').style.display = "none";
		document.getElementById('afflink').style.display = "none";
		document.getElementById('media_upload').style.display = "none";
	}
	if(document.getElementById('coupon_entry_0').checked == true)
	{	
		
		if(ctype == '1' || ctype == '2')
		{
		document.getElementById('singlecode').style.display = "none";
		document.getElementById('coupon_entry').style.display = "none";
		document.getElementById("no_of_coupons").style.display = "none";
		document.getElementById('multicode').style.display = "none";
		//document.getElementById('afflink').style.display = "none";
		//document.getElementById('media_upload').style.display = "none";
		
		}
	
	}
	if(ctype == 'coupon_entry_1' || document.getElementById('coupon_entry_1').checked == true)
	{

			var no_of_c = document.getElementById('no_of_coupon').value;
			if(no_of_c == "")
			{ 
				if(document.getElementById('coupon_type').value == 3 || document.getElementById('coupon_type').value == 4)
				{ 
					alert("Please enter number of items");
					document.getElementById('no_of_coupon').focus();
				}
				
			}else if(document.getElementById('coupon_type').value == 1 || document.getElementById('coupon_type').value == 2){
						noofcoupon();
				document.getElementById('coupon_entry').style.display = "none";
				document.getElementById("no_of_coupons").style.display = "none";
				document.getElementById('multicode').style.display = "none";
			
			}else{

				noofcoupon();
				document.getElementById('coupon_entry').style.display = "block";
				document.getElementById("no_of_coupons").style.display = "block";
				document.getElementById('multicode').style.display = "block";
				document.getElementById('singlecode').style.display = "none";
				document.getElementById('afflink').style.display = "none";
				document.getElementById('media_upload').style.display = "none";

			}
		
	}
	
	return true;
}

<?php
						 if(get_option('ptthemes_add_customlink_deal_allow')!='No' || get_option('ptthemes_add_fixed_deal_allow')!='No' || get_option('ptthemes_add_customgen_deal_allow')!='No' || get_option('ptthemes_add_physicalbarcode_deal_allow')!='No' || get_option('ptthemes_add_physicalproduct_deal_allow')!='No' ){?>
						 var deal_val = true;
						 <?php } ?>
</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		editor_selector : "mce",
		mode : "textareas",
		theme : "advanced",
		plugins :"advimage,advlink,emotions,iespell,",
		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,|,link,unlink,image",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		content_css : "css/word.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<script type="text/javascript">
function set_login_registration_frm(val) {
	if(val=='existing_user') {
		document.getElementById('contact_detail_id').style.display = 'none';
		document.getElementById('login_user_frm_id').style.display = '';
		document.getElementById('user_login_or_not').value = val;
	}else  //new_user
	{
		document.getElementById('contact_detail_id').style.display = '';
		document.getElementById('login_user_frm_id').style.display = 'none';
		document.getElementById('user_login_or_not').value = val;
	}
}
function disable_endtime() {
	if(document.getElementById('enddate').checked == true)	{
		document.getElementById('end_deal_time').style.display = 'none';
	} else {
		document.getElementById('end_deal_time').style.display = 'block';
	}
}
</script>
<?php 
$user_db_table_name = get_user_table();
$select_name_email = $wpdb->get_row("SELECT * FROM $user_db_table_name where ID = '".$current_user->data->ID."'");
if ( get_option('ptthemes_breadcrumbs' )) { 
$sep_array = get_option('yoast_breadcrumbs');
$sep = $sep_array['sep'];
 ?>
    <div class="breadcrumb clearfix">
        <div class="breadcrumb_in"><a href="<?php echo site_url(); ?>"><?php echo HOME;?></a> <?php echo $sep; ?> <?php echo POST_DEAL_TITLE_TEXT; ?></div>
    </div>
<?php } //content_full class for full page layout 
 ?>
	<div  class="content <?php echo templ_submitdeal_layout(); ?>" >
       	<div class="entry">
            <div <?php post_class('single clear'); ?>>
                <div class="post-meta"><h1><?php echo POST_DEAL_TITLE_TEXT;?></h1></div>
					<div class="deal_steps">
						<ul>
                        	<li class="current"><?php echo BUY_STEP_1;?></li>
                            <li class="step2"><?php echo BUY_STEP_2;?></li>
                            <li class="step3"><?php echo BUY_STEP_3;?></li>
                        </ul>
                    </div>
				<div id="post_<?php the_ID(); ?>">
				<p><?php if($_REQUEST['editdeal']!="") {
					_e(EDIT_FORM_MSG,'templatic');
				}	else{
					_e(POST_FORM_MSG,'templatic');
				} ?></p>
					<div class="post_dealarea_register">        
                        <div class="post-content">
							<div class="address_info">
					<?php	if($current_user->data->ID == "")	{	?>
									<h4 class="title-first"><?php echo LOGINORREGISTER; ?></h4>
									<div class="form_row clearfix">
										<label><?php echo IAM_TEXT; ?> </label>
										<label>
										<span class=" user_define"> 
										<input type="radio" onclick="set_login_registration_frm('existing_user');" value="existing_user" name="user_login_or_not" checked="checked" tabindex="1"> <?php echo EXISTING_USER_TEXT; ?> </span></label>
										<label>
										<span class="user_define"> 
										<input type="radio" onclick="set_login_registration_frm('new_user');" value="new_user" name="user_login_or_not" tabindex="2"> <?php echo NEW_USER_TEXT; ?> </span></label>
									</div>
						<?php 	} ?>
								<div id="login_user_frm_id" class="login_submit clearfix" <?php if($current_user->data->ID != ""){?>style="display:none;"<?php }else{ ?> style="display:block;"<?php } ?>>
								<?php include_once('login_frm.php');?></div>
									
									<form id="postdeal_frm" name="postdeal_frm" action="<?php echo site_url('/?ptype=previewdeal');?>" method="post" enctype="multipart/form-data">
									<input type="hidden" name="did" value="<?php echo $did;?>" />
									<input type="hidden" name="editdeal" value="<?php echo $_REQUEST['editdeal'];?>" />
                   	  
									
									<div id="contact_detail_id" class="contact_detail_id" style="display:none;">
						<?php 		if($current_user->data->ID == "") { ?>
										<h4><?php echo POST_DEAL_INFO; ?></h4>
										<div class="form_row clearfix">
											<label><?php echo POST_DEAL_USER_NAME;?> <span class="indicates">*</span></label>
											<input type="text" class="textfield" id="owner_name" name="owner_name" value="<?php _e($select_name_email->display_name,'templatic');  ?>" <?php if(mysql_affected_rows() >0){ ?> readonly <?php } ?> tabindex="3"><span id="user_fname_Info" class="error"></span>
										</div>							   
										<div class="form_row clearfix">
											<label><?php echo POST_DEAL_EMAIL_TEXT;?> <span class="indicates">*</span></label>
											<input type="text" class="textfield" id="owner_email" name="owner_email" value="<?php _e($select_name_email->user_email,'templatic');?>" <?php if(mysql_affected_rows() >0){ ?> readonly <?php } ?> tabindex="4"><span id="user_emailInfo"  class="error"></span>
										</div>
							<?php 	} else if (isset($_REQUEST['editdeal']) || $_REQUEST['editdeal'] != ""){ ?>
										<input type="hidden" class="textfield" id="owner_name" name="owner_name" value="<?php _e($select_name_email->display_name,'templatic');  ?>" >
										<input type="hidden" class="textfield" id="owner_email" name="owner_email" value="<?php	 echo _e($select_name_email->user_email,'templatic');?>" >
							<?php 	} else if($current_user->data->ID != "") { ?>
										<input type="hidden" class="textfield" id="owner_name" name="owner_name" value="<?php _e($select_name_email->display_name,'templatic');  ?>" >
										<input type="hidden" class="textfield" id="owner_email" name="owner_email" value="<?php	 echo _e($select_name_email->user_email,'templatic');?>" >
						<?php 		} ?>
								</div>   
								<h4><?php echo POST_DEAL_INFO_TEXT;?></h4>
								<div class="form_row clearfix">
									<label><?php echo DEAL_TITLE_TEXT; ?> <span class="indicates">*</span></label>
									<input type="text" class="textfield" id="post_title" name="post_title" value="<?php if(isset($dealsession) || $dealsession != "") { _e($_SESSION['post_title'],'templatic'); }elseif($_REQUEST['editdeal'] != ""){ echo $edit_deal->post_title;  }?>" tabindex="5">
									<small><?php echo DEAL_TITLE_DESC; ?></small><span id="deal_titleInfo" class="error"></span>
								</div>	
								<div class="form_row clearfix" >
									<label><?php echo "Excerpt :";?> <span class="indicates">*</span></label>
									<textarea name="post_excerpt" id="post_excerpt" class=" mce" cols="40" rows="10" tabindex="6"><?php if(isset($dealsession) || $dealsession != "") {  _e($_SESSION['post_content'],'templatic');   }else{  echo htmlspecialchars($edit_deal->post_content); } ?></textarea><small><?php echo BUY_DEAL_DESC_TEXT; ?></small><span id="deal_descInfo" class="error"></span>
								</div>								
								<div class="form_row clearfix" >
									<label><?php echo DEAL_DESC_TEXT;?> <span class="indicates">*</span></label>
									<textarea name="post_content" id="post_content" class=" mce" cols="40" rows="10" tabindex="6"><?php if(isset($dealsession) || $dealsession != "") {  _e($_SESSION['post_content'],'templatic');   }else{  echo htmlspecialchars($edit_deal->post_content); } ?></textarea><small><?php echo BUY_DEAL_DESC_TEXT; ?></small><span id="deal_descInfo2" class="error"></span>
								</div>
								<div class="form_row clearfix">
									<label><?php echo DEAL_NO_OF_ITEM;?> <span class="indicates">*</span></label>
									<input type="text" onkeyup="return no_of_coupon1();" class="textfield" id="no_of_coupon" name="no_of_coupon" value="<?php if(isset($dealsession) || $dealsession != "") { _e($_SESSION['no_of_coupon'],'templatic');  }else{ echo get_post_meta($edit_deal->ID,'no_of_coupon',true); } ?>" tabindex="7">
                                    <small><?php echo DEAL_NO_OF_ITEM_HINR; ?></small>
									<span id="no_of_couponInfo" class="error"></span>
								</div>						
								<div class="form_row clearfix">
									<label><?php echo DEAL_CURRENT_PRICE_TEXT;?> <span class="indicates">*</span></label>
									<input type="text" class="textfield" id="current_price" name="current_price" value="<?php if(isset($dealsession) || $dealsession != "") { _e($_SESSION['current_price'],'templatic');   }else{ echo get_post_meta($edit_deal->ID,'current_price',true); }?>" tabindex="8">
									<small><?php echo DEAL_ORIGINAL_PRICE_DESC; ?></small>
									<span id="current_priceInfo" class="error"></span>
								</div>	
								<div class="form_row clearfix">
									<label><?php echo DEAL_YOUR_PRICE_TEXT;?> <span class="indicates">*</span></label>
									<input type="text" class="textfield" id="our_price" name="our_price" value="<?php if(isset($dealsession) || $dealsession != "") { _e($_SESSION['our_price'],'templatic'); }else{ echo get_post_meta($edit_deal->ID,'our_price',true); } ?>"  tabindex="9"><span id="our_priceInfo" class="error"></span>
									<small><?php echo DEAL_DISCOUNT_PRICE_DESC.FREE_DEAL_DESC;?></small>
								</div>
								 <?php		 if(get_option('ptthemes_add_customlink_deal_allow')!='No' && get_option('ptthemes_add_fixed_deal_allow')!='No' && get_option('ptthemes_add_customgen_deal_allow')!='No' && get_option('ptthemes_add_physicalbarcode_deal_allow')!='No' && get_option('ptthemes_add_physicalproduct_deal_allow')!='No' ) 
					{ ?>
						           
						  <?php }?> 
						  
								 
						        <div class="form_row clearfix">
									<label><?php echo  DEAL_TYPES_TEXT; ?> <span class="indicates">*</span></label>
									<select class="textfield" onchange="coupon_change_type(this.value);" name="coupon_type" id="coupon_type" tabindex="10">
										<option id="coupon_type_0" value="0" <?php if($_SESSION['coupon_type'] == 0 || get_post_meta($_REQUEST['editdeal'],'deal_type',true) == 0) {?>selected <?php } ?>><?php echo "Select Deal Type";?></option>
										 <?php if(get_option('ptthemes_add_customlink_deal_allow')!='No'){?>
										<option id="coupon_type_1" value="1" <?php if($_SESSION['coupon_type'] == 1 || get_post_meta($_REQUEST['editdeal'],'coupon_type',true) == 1 ) {?>selected <?php } ?>><?php echo DEAL_TYPES_1;?></option>  <?php }?>
									<?php if(get_option('ptthemes_add_customgen_deal_allow')!='No'){?>
										<option id="coupon_type_2" value="2" <?php if($_SESSION['coupon_type'] == 2 || get_post_meta($_REQUEST['editdeal'],'coupon_type',true) == 2) {?>selected <?php } ?>><?php echo DEAL_TYPES_2;?></option> <?php } ?>
									<?php if(get_option('ptthemes_add_customgen_deal_allow')!='No'){?>
										<option id="coupon_type_3" value="3" <?php if($_SESSION['coupon_type'] == 3 || get_post_meta($_REQUEST['editdeal'],'coupon_type',true) == 3) {?>selected <?php } ?>><?php echo DEAL_TYPES_3;?></option> <?php } ?>
									<?php if(get_option('ptthemes_add_physicalbarcode_deal_allow')!='No'){?>
										<option id="coupon_type_4" value="4" <?php if($_SESSION['coupon_type'] == 4 || get_post_meta($_REQUEST['editdeal'],'coupon_type',true) == 4) {?>selected <?php } ?>><?php echo DEAL_TYPES_4;?></option> <?php } ?>
									</select> <a href="#" class="tooltip"><img src="<?php echo get_template_directory_uri();?>/images/info.png" alt="Information"><div><?php echo DEAL_TYPE_DESC;?></div></a><span id="coupon_typeInfo" class="error"></span>
								<div id="descdiv" ></div>
								 
                                </div>
								
								<div id="coupon_entry" <?php if(isset($_SESSION['coupon_entry']) || get_post_meta($_REQUEST['editdeal'],'coupon_entry',true) != "" || $_SESSION['coupon_entry'] != "") { ?> style="display:block;" <?php }else{ ?>style="display:none;"<?php } ?> >
									<div class="form_row clearfix">
										<label><?php echo COUPONENTRY_TEXT; ?>  <span class="indicates">*</span></label>
										<div class="coupons_list" ><label><input type="radio" name="coupon_entry" value="coupon_entry_0" id="coupon_entry_0" onclick="coupon_change_type(this.value);" <?php if(isset($_SESSION['coupon_entry']) == "coupon_entry_0" || get_post_meta($_REQUEST['editdeal'],'coupon_entry',true) == "coupon_entry_0" ) { ?> checked="checked"<?php } ?> tabindex="11" />
										<?php echo SINGLE_COUPON_TEXT; ?></label>
										<label><input type="radio" name="coupon_entry" value="coupon_entry_1" id="coupon_entry_1" onclick="coupon_change_type(this.value);" <?php if(isset($_SESSION['coupon_entry']) == "coupon_entry_1" || get_post_meta($_REQUEST['editdeal'],'coupon_entry',true) == "coupon_entry_1" ) { ?> checked="checked"<?php } ?> tabindex="12" />
									   <?php echo MULTIPPLE_COUPON_TEXT; ?></label>
									   </div>
										<span id="coupon_info" class="error"></span>
									</div>
								</div>
								<div id="media_upload" <?php if($_SESSION['coupon_type'] == 2 || get_post_meta($_REQUEST['editdeal'],'coupon_type',true) == 2) {?>style="display:block;"<?php }else{ ?>style="display:none;"<?php } ?>>
									<div class="form_row clearfix">
										<label><?php echo UPLOAD_PRODUCT_TEXT; ?></label>
										<div id="file_browse_wrapper">
										<input type="file" name="media_file" id="media_file" class="file_browse" tabindex="13" />
										</div>
										<small><?php echo UPLOAD_FILE_DESC;?></small>
										<?php wp_nonce_field('client-file-upload'); ?>  
								   	</div>						
								</div>
                                <div id="multicode" <?php if($_SESSION['coupon_entry'] == "coupon_entry_1" || get_post_meta($_REQUEST['editdeal'],'coupon_entry',true) == "coupon_entry_1" ) { ?>style="display:block;"<?php }else{ ?>style="display:none;"<?php } ?>>
									<div class="form_row clearfix" id="no_of_coupons" style="display:none;">
									<div class="descdiv"><span id="count_no_of_coupon" style="font-weight:bold;" ><?php _e('0 ','templatic');?></span><?php echo " out of ";?><span style="font-weight:bold;" id="coupons"></span><?php _e(' entered','templatic');?></div>
									</div>	
									<div class="form_row clearfix">
										<label><?php echo PRO_ADD_COUPON_TEXT; ?></label>
										<textarea rows="6" cols="60" id="coupon_code" name="coupon_code" tabindex="14" class="textarea" ><?php if(isset($dealsession) || $dealsession != "") { echo $_SESSION['coupon_code']; }else{  echo get_post_meta($edit_deal->ID,'coupon_code',true); }?></textarea><br/><small><?php echo COMMA_SEPRATED_DEAL_CODE_TEXT; ?></small>
									</div>
									<span id="coupon_codeInfo" class="error"></span>
								</div>
							
								<div id="singlecode" <?php if($_SESSION['coupon_entry'] == "coupon_entry_0" || get_post_meta($_REQUEST['editdeal'],'coupon_entry',true) == "coupon_entry_0") { ?>style="display:block;"<?php }else{ ?>style="display:none;"<?php } ?>>
									<div class="form_row clearfix">
										<label><?php echo PRO_ADD_COUPON_TEXT; ?></label>
										<input type="text" name="single_coupon_code" class="textfield" value ="<?php if(isset($dealsession) || $dealsession != " ") { echo $_SESSION['coupon_code']; }else{ echo get_post_meta($edit_deal->ID,'coupon_code',true); } ?>" tabindex="15" />
										<small><?php echo SINGLE_COUPON_TEXT; ?></small>
									</div>						
								</div>
                                <div id="coupon_expired" style="display:none;">
									<div class="form_row clearfix">
										<label><?php echo COUPON_EXPIRED_TEXT; ?></label>
										<input type="text" name="coupon_expired_date" id="coupon_expired_date" class="textfield" tabindex="16" value="<?php if(isset($dealsession) || $dealsession != "") { echo $_SESSION['coupon_expired_date']; }else{ echo get_post_meta($edit_deal->ID,'coupon_expired_date',true); } ?>"/>&nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.postdeal_frm.coupon_expired_date,'<?php echo templ_get_date_format(); ?>',this)" class="calendar_img">&nbsp;&nbsp;
									</div>
								</div>
								<div id="afflink" <?php if( $_SESSION['coupon_type'] == 1 || get_post_meta($_REQUEST['editdeal'],'coupon_type',true) == 1) {?>style="display:block;"<?php }else{ ?>style="display:none;"<?php } ?>>
									<div class="form_row clearfix">
										<label><?php echo AFFILIATE_LINK; ?></label>
										<input type="text" name="coupon_link"  class="textfield" value="<?php echo get_post_meta($edit_deal->ID,'coupon_link',true);?> " tabindex="17"><br/><small><?php echo ENTER_AFFILIATE_LINK; ?></small>
									</div>
								</div>
                                <div class="form_row clearfix" id="shippingdiv" <?php if( $_SESSION['coupon_type'] == 4 || get_post_meta($_REQUEST['editdeal'],'coupon_type',true) == 4) {?>style="display:block;"<?php }else{ ?>style="display:none;"<?php } ?>>
                                <label><?php echo SHIPPINGCOST_TEXT; ?> <span class="indicates">*</span></label>
                                <input type="text" class="textfield" id="shipping_cost" name="shipping_cost" value="<?php if(isset($dealsession) || $dealsession != " ") { _e($_SESSION['shipping_cost'],'templatic');  }else{ echo get_post_meta($edit_deal->ID,'shipping_cost',true); } ?>" tabindex="18">
                                <span id="shippingcost_info" class="error"></span>
                           		 </div>
                                  <div id="shipping_details" <?php if( $_SESSION['coupon_type'] == 4 || get_post_meta($_REQUEST['editdeal'],'coupon_type',true) == 4) {?>style="display:block;"<?php }else{ ?>style="display:none;" <?php } ?>>
                      							
							
                             <div class="form_row clearfix">
                                <label><?php echo SHIPPINGADRS_TEXT; ?> <span class="indicates">*</span></label>
                                <input type="text" class="textfield" id="shhiping_address" name="shhiping_address" value="<?php if(isset($dealsession) || $dealsession != " ") { _e($_SESSION['shhiping_address'],'templatic');  }else{ echo get_post_meta($edit_deal->ID,'shhiping_address',true); } ?>" tabindex="19">
                                <span id="shipping_info" class="error"></span>
                             </div>
							<?php if(get_option(ptttheme_google_map_opt) == 'Enable' && get_option('pttheme_google_map_api') != '') {  ?>
							 <div class="form_row map_location clearfix">
							 <?php include_once(TEMPLATEPATH . "/library/map/location_add_map.php");?>
							  <span class="message_note"><?php echo GET_MAP_MSG;?></span></div>
							  
							 <div class="form_row clearfix">
								<label><?php echo EVENT_ADDRESS_LAT;?> </label>
								<input type="text" name="geo_latitude" id="geo_latitude" class="textfield" value="<?php if(isset($dealsession) || $dealsession != " ") { _e($_SESSION['geo_latitude'],'templatic');  }else{ echo get_post_meta($edit_deal->ID,'geo_latitude',true); } ?>" size="25" tabindex="20" />
								<span class="message_note"><?php echo GET_LATITUDE_MSG;?></span>
							 </div>
							 <div class="form_row clearfix">
								<label><?php echo EVENT_ADDRESS_LNG;?> </label>
								<input type="text" name="geo_longitude" id="geo_longitude" class="textfield" value="<?php if(isset($dealsession) || $dealsession != " ") { _e($_SESSION['geo_longitude'],'templatic');  }else{ echo get_post_meta($edit_deal->ID,'geo_longitude',true); } ?>" size="25" tabindex="21" />
							   <span class="message_note"><?php echo GET_LOGNGITUDE_MSG;?></span>
							 </div>
							 <?php } ?>
                        
                        </div>

								<div class="category_list clearfix">
									<label><?php echo DEAL_CATEGORY_TEXT; ?></label>	
									<div class="cat_list">	
									<?php 
									$tmtable = $wpdb->prefix.term_taxonomy;
									$ttable = $wpdb->prefix.terms;
									$query12 = ("SELECT * FROM $tmtable,$wpdb->terms WHERE $tmtable.term_id = $ttable.term_id and $tmtable.taxonomy = 'seller_category'");
									$pageposts = $wpdb->get_results($query12);
									foreach($pageposts as $pageposts_obj) {	?>
										
											<label>
												<input name="deal_category[]"  id="<?php _e($pageposts_obj->name,'templatic'); ?>" type="checkbox" value="<?php _e($pageposts_obj->term_taxonomy_id,'templatic'); ?>" tabindex="22"	/>	
												<?php _e($pageposts_obj->name,'templatic'); ?>
											</label>
										
							<?php 	} ?>
							</div>
							</div>
							<div class="form_row clearfix">
								<label><?php echo DEAL_START_DATE_TIME; ?></label>	
								<input type="text" name="coupon_start_date"  id="coupon_start_date" class="textfield calendar_text" value="<?php echo $coupon_start_date; ?>"/>  <img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.postdeal_frm.coupon_start_date,'<?php echo templ_get_date_format(); ?>',this)" class="calendar_img" tabindex="23"> 
								<label class="time_label"><?php echo DEAL_HH;?></label>
								<select name="coupon_start_time_hh" class="textfield time_select"> 
						<?php	for($i=0;$i<=23;$i++){
									if($i<10)
									$i="0".$i;
								?>
								<option value="<?php echo $i;?>" <?php if($coupon_start_time_hh == $i){?> selected="selected" <?php } ?>><?php echo $i;?></option>
								<?php } ?>
								</select> 
								<label class="time_label"><?php echo DEAL_MM;?></label>
								<select name="coupon_start_time_mm" class="textfield time_select"> 
						<?php	for($i=0;$i<=59;$i++){
									if($i<10)
									$i="0".$i;
								?>
								<option value="<?php echo $i;?>" <?php if($coupon_start_time_mm==$i){?> selected="selected" <?php } ?>><?php echo $i;?></option>
								<?php }?>
								</select> 
								<label class="time_label"><?php echo DEAL_SS;?></label>
								<select name="coupon_start_time_ss" class="textfield time_select"> 
						<?php	for($i=0;$i<=59;$i++){
									if($i<10)
									$i="0".$i;
								?>
								<option value="<?php echo $i;?>" <?php if($coupon_start_time_ss==$i){?> selected="selected" <?php } ?>><?php echo $i;?></option>
								<?php }?>
								</select>
								<span id="deal_startInfo" class="error"></span>
							</div>
							<span class="disable_checkbox" ><label><input name="enddate" id="enddate" type="checkbox" value="0" onchange="disable_endtime()" /><?php echo DISABLE_END_TIME; ?></label></span>
						 	<div class="form_row clearfix" id="end_deal_time">							
								<label><?php echo DEAL_START_END_TIME; ?></label>
								<input type="text" name="coupon_end_date"  id="coupon_end_date" class="textfield calendar_text" value="<?php echo $coupon_end_date; ?>"/> <img style="margin:0px" src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.postdeal_frm.coupon_end_date,'<?php echo templ_get_date_format(); ?>',this)" class="calendar_img"> 
								<label class="time_label"><?php echo DEAL_HH;?></label>
								<select name="coupon_end_time_hh" class="textfield time_select"> 
						<?php
								for($i=0;$i<=23;$i++){
									if($i<10)
									$i="0".$i;
								?>
								<option value="<?php echo $i;?>" <?php if($coupon_end_time_hh==$i){?> selected="selected" <?php } ?>><?php echo $i; ?></option>
								<?php }?>
							</select> 
							<label class="time_label"><?php echo DEAL_MM;?></label>
							<select name="coupon_end_time_mm" class="textfield time_select"> 
								<?php
								for($i=0;$i<=59;$i++){
									if($i<10)
									$i="0".$i;
								?>
								<option value="<?php echo $i;?>" <?php if($coupon_end_time_mm==$i){?> selected="selected" <?php } ?>><?php echo $i;?></option>
								<?php }?>
							</select> 
							<label class="time_label" ><?php echo DEAL_SS;?></label>
							<select name="coupon_end_time_ss" class="textfield time_select"> 
								<?php
								for($i=0;$i<=59;$i++){
									if($i<10)
									$i="0".$i;
								?>
								<option value="<?php echo $i;?>" <?php if($coupon_end_time_ss==$i){?> selected="selected" <?php } ?>><?php echo $i;?></option>
								<?php }?>
							</select>
							
                            
						</div>
                        
                       
                        <div class="form_row clearfix">
							<label><?php echo PHOTOES_BUTTON;?></label>
							
							<a href="#">
							<?php 
								
								if((isset($_SESSION['deal_image'] ) || $_SESSION['deal_image'] !="") && ($_REQUEST['deal'] == "") ) { 
									if(is_super_admin($edit_deal->post_author)){ echo "in else";
										echo display_deal_image($edit_deal->ID,'thumbnail');
									}else {  ?>
								<img src="<?php if($_SESSION['deal_image'] !="") { echo templ_thumbimage_filter($_SESSION['deal_image'],168,180); }else{ echo templ_thumbimage_filter($destination_path.get_post_meta($edit_deal->ID,'file_name',true),168,180); } ?>" alt="<?php $_SESSION['filename']; ?>" /> <?php } ?>
							
								<input type="hidden" value="<?php echo $_SESSION['deal_image']; ?>" name="dealsession_image"/>
							<?php } else if(get_post_meta($edit_deal->ID,'file_name',true) != '') { 
									if(is_super_admin($edit_deal->post_author)){  
										echo display_deal_image($edit_deal->ID,'thumbnail');
									}else { ?>
							<img src="<?php echo templ_thumbimage_filter($destination_path.get_post_meta($edit_deal->ID,'file_name',true),168,180); ?>" alt="<?php $edit_deal->post_title; ?>" />
							<?php }
							}else{ ?>
								<img src="<?php echo get_template_directory_uri()."/images/no-image2.png"; ?>" width="168" height="180" alt="No Image Available" />
								<?php } ?>
							</a>
							<input type="hidden" name="edit_image"/>
							<div class='file_browse_wrapper'><input type="file" name="deal_image" id="deal_image" class="file_browse"/><?php echo $edit_deal->image_name; ?></div>
							
                        </div>
								
								<div class="form_row clearfix">
									<label><?php echo DEAL_WEB_TEXT;?> <span class="indicates">*</span></label>
									<input type="text" class="textfield" id="coupon_website" name="coupon_website" value="<?php if(isset($dealsession) || $dealsession != "") {   _e($_SESSION['coupon_website'],'templatic'); }else if($_REQUEST['editdeal'] != ""){ echo get_post_meta($edit_deal->ID,'coupon_website',true);  } else { echo "http://";} ?>">
									<small><?php echo BUY_DEAL_WEB_LINK; ?></small> <span id="coupon_websiteInfo" class="error"></span>
								</div>						
								
								<div class="form_row clearfix">
									<label><?php echo THANKYOU_PAGE_TEXT;?> </label>
									<input type="text" class="textfield" id="thankyou_page_url" name="thankyou_page_url" value="<?php if(isset($dealsession) || $dealsession != "") { _e($_SESSION['thankyou_page_url'],'templatic'); }else if($_REQUEST['editdeal'] != ""){ echo get_post_meta($edit_deal->ID,'thankyou_page_url',true); } else { echo "http://";} ?>">
									<small><?php echo REDIRECT_TEXT; ?></small>
								</div>
                        
                                                
                        
						<h4><?php echo PURCHASE_TEXT; ?></h4>
                        
                        	<div class="form_row clearfix">
								<label class="max_user"><?php echo MIN_PUR_TEXT; ?> </label>
								<input type="text" class="textfield" id="min_purchases" name="min_purchases" value="<?php if(isset($dealsession) || $dealsession != " ") { _e($_SESSION['min_purchases'],'templatic');  }elseif(get_post_meta($edit_deal->ID,'min_purchases',true) != ""){ echo get_post_meta($edit_deal->ID,'min_purchases',true);  }else{ echo "1"; }								?>">
								<span id="min_purchaseinfo" class="error"></span>
								 <small><?php echo MIN_PUR_MSG;?></small>
							</div>
                        
                             <div class="form_row clearfix">
								<label class="max_user"><?php echo MAX_USERPUR_TEXT; ?></label>
								<input type="text" class="textfield" id="max_purchases_user" name="max_purchases_user" value="<?php if(isset($dealsession) || $dealsession != " ") {  _e($_SESSION['max_purchases_user'],'templatic'); }else{ echo get_post_meta($edit_deal->ID,'max_purchases_user',true); } ?>">
								<span id="max_userpurchaseinfo" class="error"></span>
							    <small><?php echo MAX_USERPUR_MSG;?></small>
							</div>
                            
						
                        
						<?php
								global $wpdb,$table_prefix;
								$custom_post_meta_db_table_name = $table_prefix . "templatic_custom_post_fields";
								$wpdb->query('CREATE TABLE IF NOT EXISTS `'.$custom_post_meta_db_table_name.'` (
							  `cid` int(11) NOT NULL AUTO_INCREMENT,
							  `admin_title` varchar(255) NOT NULL,
							  `htmlvar_name` varchar(255) NOT NULL,
							  `admin_desc` text NOT NULL,
							  `site_title` varchar(255) NOT NULL,
							  `ctype` varchar(255) NOT NULL COMMENT "text,checkbox,radio,select,textarea",
							  `default_value` text NOT NULL,
							  `option_values` text NOT NULL,
							  `clabels` text NOT NULL,
							  `sort_order` int(11) NOT NULL,
							  `is_active` tinyint(4) NOT NULL DEFAULT "1",
							  `show_on_listing` tinyint(4) NOT NULL DEFAULT "1",
							  `show_on_detail` tinyint(4) NOT NULL DEFAULT "1",
							  `extrafield1` text NOT NULL,
							  `extrafield2` text NOT NULL,
							  PRIMARY KEY (`cid`)
							)');

							
							$custom_metaboxes = get_post_custom_fields_templ_1();
							
							
				function get_post_custom_listing_single_page_1($pid, $paten_str,$fields_name='')
				{
					global $wpdb,$custom_post_meta_db_table_name;
					$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail=1 ";
					if($fields_name)
					{
						$fields_name = '"'.str_replace(',','","',$fields_name).'"';
						$sql .= " and htmlvar_name in ($fields_name) ";
					}
					$sql .=  " order by sort_order asc,admin_title asc";
					
					$post_meta_info = $wpdb->get_results($sql);
					$return_str = '';
					$search_arr = array('{#TITLE#}','{#VALUE#}');
					$replace_arr = array();
					if($post_meta_info){
						foreach($post_meta_info as $post_meta_info_obj){
							if($post_meta_info_obj->site_title)
							{
								$replace_arr[] = $post_meta_info_obj->site_title;	
							}
							
							if(is_array(get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true))){
								$replace_arr = array($post_meta_info_obj->site_title,implode(",",get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true)));
							}
							else{                                    
								$replace_arr = array($post_meta_info_obj->site_title,get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true));
							}
							if(get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true))
							{
								$return_str .= str_replace($search_arr,$replace_arr,$paten_str);
							}
						}	
					}
					
					return $return_str;
				}

			function get_post_custom_for_listing_page_1($pid, $paten_str,$fields_name='')
			{
				global $wpdb,$custom_post_meta_db_table_name;
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_listing=1 ";
				if($fields_name)
				{
					$fields_name = '"'.str_replace(',','","',$fields_name).'"';
					$sql .= " and htmlvar_name in ($fields_name) ";
				}
				$sql .=  " order by sort_order asc,admin_title asc";
				
				$post_meta_info = $wpdb->get_results($sql);
				$return_str = '';
				$search_arr = array('{#TITLE#}','{#VALUE#}');
				$replace_arr = array();
				if($post_meta_info){
					foreach($post_meta_info as $post_meta_info_obj){
						if($post_meta_info_obj->site_title)
						{
							$replace_arr[] = $post_meta_info_obj->site_title;	
						}
						if(is_array(get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true))){
							$replace_arr = array($post_meta_info_obj->site_title,implode(",",get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true)));
						}
						else{                                    
							$replace_arr = array($post_meta_info_obj->site_title,get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true));
						}
						if(get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true))
						{
							$return_str .= str_replace($search_arr,$replace_arr,$paten_str);
						}
					}	
				}
				return $return_str;
			}

?>
<?php 
			$custom_metaboxes = get_post_custom_fields_templ_1();
			if(count($custom_metaboxes) > 0){
				echo '<h4>'.CUSTOM_TEXT.'</h4>';
			
			foreach($custom_metaboxes as $key=>$val)
			{	
				$name = $val['name'];
				$site_title = $val['site_title'];
				$type = $val['type'];
				$admin_desc = $val['desc'];
				$option_values = $val['option_values'];
				$default_value = $val['default'];
				if($_REQUEST['editdeal'])
				{
					$value = get_post_meta($_REQUEST['editdeal'], $name,true);
				}else
				if($_SESSION['deal_info'] && $_REQUEST['backandedit'])
				{
					$value = 	$_SESSION['property_info'][$name];
				}
				
				//echo $type;
			?>
            <div class="form_row clearfix">
			   <?php if($type=='text'){?>
               <label><?php echo $site_title; ?></label>
             <input name="<?php echo $name;?>" id="<?php echo $name;?>" value="<?php echo $value;?>" type="text" class="textfield" />
			 <span  id="<?php echo $name."_error";?>"></span>
               <?php 
                }elseif($type=='checkbox'){
                ?>     
                 <label><?php echo $site_title; ?></label>      
                <input name="<?php echo $name;?>" id="<?php echo $name;?>" <?php if($value){ echo 'checked="checked"';}?>  value="<?php echo $value;?>" type="checkbox" /> <?php echo $site_title; ?>
				<span  id="<?php echo $name."_error";?>"></span>
                <?php
                }
				elseif($type=='multicheckbox')
				{ ?>
				 <label><?php echo $site_title; ?></label>
				<?php
					$options = $val['option_values'];
					if($options)
					{  $chkcounter = 0;
					    
						$option_values_arr = explode(',',$options);
						for($i=0;$i<count($option_values_arr);$i++)
						{
							$chkcounter++;
							$seled='';
							if($default_value == $option_values_arr[$i]){ $seled='checked="checked"';}							
							echo '
							<div class="form_cat">
								<label>
									<input name="'.$key.'[]"  id="'.$key.'_'.$chkcounter.'" type="checkbox" value="'.$option_values_arr[$i].'" '.$seled.' /> '.$option_values_arr[$i].'
									
								</label>
							</div>';								
						}
						
					}
				}elseif($type=='radio'){
				?>     
				 <label class="r_lbl"><?php echo $site_title.$is_required; ?></label>
				<?php
					$options = $val['option_values'];
					if($options)
					{  $chkcounter = 0;
						
						$option_values_arr = explode(',',$options);
						for($i=0;$i<count($option_values_arr);$i++)
						{
							$chkcounter++;
							$seled='';
							if($default_value == $option_values_arr[$i]){ $seled='checked="checked"';}							
							if (trim($value) == trim($option_values_arr[$i])){ $seled='checked="checked"';}	
							echo '
							<div class="form_cat">
								<label class="r_lbl">
									<input name="'.$key.'"  id="'.$key.'_'.$chkcounter.'" type="radio" value="'.$option_values_arr[$i].'" '.$seled.'  '.$extra_parameter.' /> '.$option_values_arr[$i].'
								</label>
							</div>';							
						}
						
					}
			   
				}
				elseif($type=='texteditor'){
                ?>
                <label><?php echo $site_title; ?></label>
                <textarea name="<?php echo $name;?>" id="<?php echo $name;?>" cols="55" class="mce"><?php echo $value;?></textarea>   
				<span  id="<?php echo $name."_error";?>"></span>    
                <?php
				}
				elseif($type=='textarea'){
                ?>
                <label><?php echo $site_title; ?></label>
                <textarea name="<?php echo $name;?>" id="<?php echo $name;?>" ><?php echo $value;?></textarea>   
				<span  id="<?php echo $name."_error";?>"></span>    
                <?php
                }
                elseif($type=='select'){
                ?>
                 <label><?php echo $site_title; ?></label>
                <select name="<?php echo $name;?>" id="<?php echo $name;?>" class="textfield textfield_x">
                <?php if($option_values){
				$option_values_arr = explode(',',$option_values);
				
				for($i=0;$i<count($option_values_arr);$i++)
				{
				?>
               <option value="<?php echo $option_values_arr[$i]; ?>" <?php if($value==$option_values_arr[$i]){ echo 'selected="selected"';} else if($default_value==$option_values_arr[$i]){ echo 'selected="selected"';}?>><?php echo $option_values_arr[$i]; ?></option>
                <?php	
				}
				?>
                <?php }?>               
                </select>                
                <?php
                }
                ?>
				<span  id="<?php echo $name."_error";?>"></span>
             	 <span class="message_note"><?php echo $admin_desc;?></span>
				 
              </div>
              <?php }
			  }?>
						<!-- BOF Buy Section -->						
			<?php
						if(get_option('pttthemes_captcha')=='Enable' && file_exists(ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php') && plugin_is_active('wp-recaptcha')  ){
						  echo '<div class="form_row clearfix">';
						  
						$a = get_option("recaptcha_options");
						echo '<label>'.WORD_VERIFICATION.'</label>';
						$publickey = $a['public_key']; // you got this from the signup page
						echo recaptcha_get_html($publickey); 
						if($_REQUEST['emsg']=='captch'){echo '<span class="message_error2" id="category_span">'.CAPTCH_ERROR_MSG.'</span>';}
						 echo '</div>';
						 }
			?>  
						<div class="form_row clearfix">
                             <div class="post_deal_button">
                                <?php 
                                if($_REQUEST['editdeal'] != "")
                                {
                                ?>	
                                <input type="hidden" name="updateid" value ="<?php echo $_REQUEST['editdeal']; ?>">
                                <input type="submit" id="submit" name="update_deal" value="<?php echo SAVE_ALL_CHANGES; ?>"/>
                                <?php }else	{ ?>				
                                <input type="submit" id="submit" name="save_deal" value="<?php echo POST_DEAL_BUTTON_TEXT; ?>"/>
                                <?php } ?>
                            </div>
					<!-- EOF Buy Section -->
					</div>
				
                </form>
				   <!-- EOF Shipping Form -->
                   </div>
                   
                   </div>
			</div>
		</div> 
	</div>
	</div>
</div>
<?php
$form_fields = array();

$form_fields['category'] = array(
				   'name'	=> 'category',
				   'espan'	=> 'category_span',
				   'type'	=> get_option('ptthemes_category_dislay'),
				   'text'	=> 'Please select Category',
				   'validation_type' => 'require');
global $custom_post_meta_db_table_name;
if(get_option('ptthemes_category_dislay') == 'select'){
$extra_field_sql = mysql_query("select * from $custom_post_meta_db_table_name where is_require = '1' and (post_type ='".CUSTOM_POST_TYPE1."' or  post_type ='both')  and (field_category = '$category_id' or field_category = '0') order by sort_order");
} else {
$extra_field_sql = mysql_query("select * from $custom_post_meta_db_table_name where is_require = '1' and (post_type ='".CUSTOM_POST_TYPE1."' or  post_type ='both')  order by sort_order");
}
while($res = mysql_fetch_array($extra_field_sql)){
	$title = $res['site_title'];
	$name = $res['htmlvar_name'];
	$type = $res['ctype'];
	$require_msg = $res['field_require_desc'];
	$validation_type = $res['validation_type'];
	$form_fields[$name] = array(
				   'title'	=> $title,
				   'name'	=> $name,
				   'espan'	=> $name.'_error',
				   'type'	=> $type,
				   'text'	=> $require_msg,
				   'validation_type' => $validation_type);	
	
}
$validation_info = array();
 foreach($form_fields as $key=>$val)
			{			
				$str = ''; $fval = '';
				$field_val = $key.'_val';
				if(!isset($val['title']))
				   {
					 $val['title'] = '';   
				   }	
				$validation_info[] = array(
											   'title'	=> $val['title'],
											   'name'	=> $key,
											   'espan'	=> $key.'_error',
											   'type'	=> $val['type'],
											   'text'	=> $val['text'],
											   'validation_type'	=> $val['validation_type']);
			}	

include_once(TEMPLATEPATH . "/monetize/deal/submition_validation.php");
?>
<div class="sidebar right" >
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar Right')){ } else {  }?>
</div>  <!-- sidebar #end -->
 <?php // get_sidebar(); ?>
 <?php get_footer(); ?>