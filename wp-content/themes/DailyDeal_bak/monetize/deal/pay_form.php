<?php
session_start();
ob_start();?>
<?php get_header(); 
$user_db_table_name = get_user_table();
$select_name_email = $wpdb->get_row("SELECT * FROM $user_db_table_name where ID = '".$current_user->data->ID."'");
?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/monetize/deal/buy_deal_validation.js"></script>
<?php if ( get_option( 'ptthemes_breadcrumbs' )) {  
$sep_array = get_option('yoast_breadcrumbs');
$sep = $sep_array['sep'];
?>
                    <div class="breadcrumb clearfix">
						<div class="breadcrumb_in"><a href="<?php echo site_url(); ?>"><?php echo HOME;?></a> <?php echo $sep; ?> <?php echo BUY_DEAL_TITLE; ?></div>
                    </div>
<?php } ?>
<div  class="content content_full" >
	<div class="entry">
	<?php if($_SERVER['HTTP_REFERER'] != ''){ 
	$did = $_REQUEST['did'];
	global $wpdb,$transection_db_table_name;
	$sellsql = "select count(*) from $transection_db_table_name where post_id=".$did." and status = 1";
	$sellsqlinfo = $wpdb->get_var($sellsql);
	
	if(get_post_meta($did,'is_expired',true) == '1' || get_post_meta($did,'no_of_coupon',true) == $sellsqlinfo && !isset($_REQUEST['dealerror'])){
		wp_redirect(site_url());
		exit;
	}
	?>
        <div <?php post_class('single clear'); ?>>
		<?php
		if($_REQUEST['dealerror'] == 1)
		{
			_e('<p class="error_msg">'.BUY_DEAL_LMT.'</p>','templatic');
		}
		?>
            <div class="post-meta">
				<h1><?php echo BUY_DEAL_TITLE;?></h1>
			</div>
			<?php
			if($current_user->data->ID != "")	{
				global $wpdb,$table_prefix;
				$transection_db_table_name = $table_prefix . "posts";
				$sellsql1 = "select * from $transection_db_table_name where ID=".$did." ";
				$post = $wpdb->get_row($sellsql1);
				$price=get_post_meta($did,'our_price',true);
				 if(get_post_meta($post->ID,'shipping_cost',true) > 0 ) { 
					$price =  $price+get_post_meta($post->ID,'shipping_cost',true);
				 }
			?>
			<div class="form_row clearfix">
				<label style="padding:0px;width:100px;">
					Deal name : 
				</label>
				 <a href="<?php the_permalink(); ?>"><?php	echo $post->post_title;  ?></a>
				</div>
				<div class="form_row clearfix">
				<label style="padding:0px;width:100px;">
					Deal Price : 
				</label>
				<?php echo get_currency_sym(); echo $price; ?><?php if(get_post_meta($post->ID,'shipping_cost',true) > 0 ) { ?>
				<?php echo "(Including Shipping price ".get_currency_sym().(get_post_meta($post->ID,'shipping_cost',true))." )";  }?>
			</div>
			<p><?php _e(BUY_DEAL_DESC,'templatic');?></p>
            <div id="post_<?php the_ID(); ?>">
				<div class="post-content">
		<?php 		if($_REQUEST['msg']=='nopaymethod'){?>
						<p class="error"><?php _e('Please Select Payment Method','templatic');?></p>
		<?php 		}?>
		<?php 		if($_SESSION['display_message']){?>
						<p class="error"><?php echo $_SESSION['display_message'];?></p>
        <?php 		} }
		
		if($_REQUEST['reg'] == 1)
		{
			echo "<p style='padding-top:5px' class=\"success_msg\"> ".REGISTRATION_SUCCESS_MSG."</p>";
		}
		 ?>
<!-- BOF Shipping Form -->
					<div class="post_deal_buy_now"> 
						<div class="address_info">
						<?php	
							if($current_user->data->ID == "")	{	?>
								<h4 ><?php echo LOGINORREGISTER; ?></h4>
								<div class="form_row clearfix">
										<label><?php echo IAM_TEXT; ?> </label>
										<span class=" user_define"> <input type="radio" onclick="set_login_registration_frm('existing_user');" value="existing_user" name="user_login_or_not" checked="checked" tabindex="1"> <?php echo EXISTING_USER_TEXT; ?> </span>
										<span class="user_define"> <input type="radio" onclick="set_login_registration_frm('new_user');" value="new_user" name="user_login_or_not" tabindex="2"> <?php echo NEW_USER_TEXT; ?> </span>
									</div>
							<?php } ?>
                                    </div>
						<?php if($current_user->data->ID == "")	{ ?>
							<div id="login_user_frm_id" class="login_submit clearfix buynow_deal_login">
								<?php  include_once('login_frm.php');?></div>
						<?php 
						} ?>
							<?php 		if($current_user->data->ID == "" && !$current_user->data->ID) { ?>
						<form id="dealpaynow_frm1" name="dealpaynow_frm1" action="<?php echo get_settings('home').'/index.php?ptype=login&amp;action=register'?>" method="post">
						<input type="hidden" name="redirect_to" value="<?php echo get_settings('home').'/?ptype='.$_GET['ptype'].'&did='.$_GET['did']; ?>" />
						<div id="contact_detail_id" class="contact_detail_id address_info" style="display:none;">
						<?php 		if($current_user->data->ID == "" && !$current_user->data->ID) { ?>
										<h4><?php echo POST_DEAL_INFO; ?></h4>
										<div class="form_row clearfix">
											<label><?php echo POST_DEAL_USER_NAME;?> <span class="indicates">*</span></label>
											<input type="text" class="textfield" id="owner_name" name="user_fname" value="<?php _e($select_name_email->display_name,'templatic');  ?>"  tabindex="3"><span id="user_fname_Info" class="error"></span>
										</div>							   
										<div class="form_row clearfix">
											<label><?php echo POST_DEAL_EMAIL_TEXT;?> <span class="indicates">*</span></label>
											<input type="text" class="textfield" id="owner_email" name="user_email" value="<?php _e($select_name_email->user_email,'templatic');?>" tabindex="4"><span id="user_emailInfo"  class="error"></span>
										</div>
										<input type="submit" name="registernow" value="<?php echo REGISTER_NOW_TEXT;?>" class="b_register_btn" />
							<?php 	}  else if($current_user->data->ID != "") { ?>
										<input type="hidden" class="textfield" id="owner_name" name="user_fname" value="<?php _e($select_name_email->display_name,'templatic');  ?>" >
										<input type="hidden" class="textfield" id="owner_email" name="user_email"  value="<?php	 echo _e($select_name_email->user_email,'templatic');?>" >
										
						<?php 		} ?>
								</div>  
						</form>
				       	<?php } ?>
						
						<div class="address_info">                    
		<?php			if($current_user->data->ID != "")	{
							$user_db_table_name = get_user_table();
							$select_name_email = $wpdb->get_row("SELECT * FROM $user_db_table_name where ID = '".$current_user->data->ID."'"); 
						}?>
						
					<?php 	if($current_user->data->ID != "") { ?>
						<form id="dealpaynow_frm" name="dealpaynow_frm" action="<?php echo site_url('/?ptype=dealpaynow');?>" method="post">
						<input type="hidden" name="did_deal" value="<?php echo $_REQUEST['did'];?>" />
						<input type="hidden" class="textfield" id="user_fname" name="user_fname" value="<?php echo $select_name_email->display_name ;?>" ><input type="hidden" class="textfield" id="user_email" name="user_email" value="<?php echo $select_name_email->user_email ; ?>" >
							<div class="billing_address">   
                                <h4><?php echo BUY_DEAL_BILLING_TEXT;?></h4>
								<div class="form_row clearfix"><label><?php echo BUY_DEAL_BILLING_NAME_TEXT;?> <span class="indicates">*</span></label> <input type="text" class="textfield" id="user_billing_name" name="user_billing_name" value="<?php echo $_SESSION['deal_info']['user_billing_name'];?>"><span id="billing_nameInfo" class="error"></span></div>
								<div class="form_row clearfix"><label><?php echo BUY_DEAL_ADDRESS_TEXT;?>  <span class="indicates">*</span></label> <input type="text" class="textfield" id="user_add1" name="user_add1" value="<?php echo $_SESSION['deal_info']['user_add1'];?>"><span id="user_addInfo" class="error"></span></div>
								<div class="form_row clearfix"><label><?php echo BUY_DEAL_CITY_TEXT;?> <span class="indicates">*</span></label> <input type="text" class="textfield" id="user_city" name="user_city" value="<?php echo $_SESSION['deal_info']['user_city'];?>"><span id="user_cityInfo" class="error"></span></div>
								<div class="form_row clearfix"><label><?php echo BUY_DEAL_STATE_TEXT;?> <span class="indicates">*</span></label> <input type="text" class="textfield" id="user_state" name="user_state" value="<?php echo $_SESSION['deal_info']['user_state'];?>"><span id="user_stateInfo" class="error"></span></div>
								<div class="form_row clearfix"><label><?php echo BUY_DEAL_COUNTRY_TEXT;?> <span class="indicates">*</span></label> <input type="text" class="textfield" id="user_country" name="user_country" value="<?php echo $_SESSION['deal_info']['user_country'];?>"><span id="user_countryInfo" class="error"></span></div>
								<div class="form_row clearfix"><label><?php echo BUY_DEAL_POSTALCODE_TEXT;?> <span class="indicates">*</span></label> <input type="text" class="textfield" id="user_postalcode" name="user_postalcode" value="<?php echo $_SESSION['deal_info']['user_postalcode'];?>"><span id="user_postalcodeInfo" class="error"></span></div>
								<div class="form_row clearfix"><label><?php echo BUY_DEAL_PHONE_TEXT;?> </label>  <input type="text" class="textfield" id="user_phone" name="user_phone" value="<?php echo $_SESSION['deal_info']['user_phone'];?>"></div>
                                <div class="form_row clearfix"><input type="checkbox" name="copybilladd" id="copybilladd" onclick="copy_billing_address();" value="Y" checked><?php echo BUY_DEAL_SAME_AS_TEXT;?></div>
							</div> 
							<!-- billing address -->
			<?php 			if(get_post_meta($did,'coupon_type',true)>= 1) { ?>
                                <div class="shipping_address" id="shipping_address" style="display:none;">  
									<h4><?php echo BUY_DEAL_SHIPPING_TEXT;?></h4> 
                                    <div class="form_row clearfix"><label><?php echo BUY_DEAL_SHIPPING_NAME_TEXT;?> <span class="indicates">*</span></label> <input type="text" class="textfield" id="buser_shipping_name" name="buser_shipping_name" value="<?php echo $_SESSION['deal_info']['buser_shipping_name'];?>"></div>
									<div class="form_row clearfix"><label><?php echo BUY_DEAL_ADDRESS_TEXT;?> <span class="indicates">*</span> </label><input type="text" class="textfield" id="buser_add1" name="buser_add1" value="<?php echo $_SESSION['deal_info']['buser_add1'];?>"></div>
									<div class="form_row clearfix"><label><?php echo BUY_DEAL_CITY_TEXT;?> <span class="indicates">*</span></label> <input type="text" class="textfield" id="buser_city" name="buser_city" value="<?php echo $_SESSION['deal_info']['buser_city'];?>"></div>
									<div class="form_row clearfix"><label><?php echo BUY_DEAL_STATE_TEXT;?> <span class="indicates">*</span></label> <input type="text" class="textfield" id="buser_state" name="buser_state" value="<?php echo $_SESSION['deal_info']['buser_state'];?>"></div>
									<div class="form_row clearfix"><label><?php echo BUY_DEAL_COUNTRY_TEXT;?> <span class="indicates">*</span> </label> <input type="text" class="textfield" id="buser_country" name="buser_country" value="<?php echo $_SESSION['deal_info']['buser_country'];?>"></div>
									<div class="form_row clearfix"><label><?php echo BUY_DEAL_POSTALCODE_TEXT;?> <span class="indicates">*</span></label> <input type="text" class="textfield" id="buser_postalcode" name="buser_postalcode" value="<?php echo $_SESSION['deal_info']['buser_postalcode'];?>"></div> 
									<div class="form_row clearfix"><label><?php echo BUY_DEAL_PHONE_TEXT;?> </label> <input type="text" class="textfield" id="buser_phone" name="buser_phone" value="<?php echo $_SESSION['deal_info']['buser_phone'];?>"></div>
                                </div> <!-- shipping address #end -->
            <?php			}?>
						</div>
                   <!-- EOF Shipping Form -->
                   <!-- BOF Buy Section -->
		<?php		$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_%' order by option_id";
					$paymentinfo = $wpdb->get_results($paymentsql);
					if($paymentinfo) { ?>
						<div class="preview_section">
							<h4><?php _e(SELECT_PAY_MEHTOD_TEXT); ?></h4> 
							<ul class="payment_method">
		<?php				$paymentOptionArray = array();
							$paymethodKeyarray = array();
							foreach($paymentinfo as $paymentinfoObj) {
								$paymentInfo = unserialize($paymentinfoObj->option_value);
								if($paymentInfo['isactive']) {
									$paymethodKeyarray[] = $paymentInfo['key'];
									$paymentOptionArray[$paymentInfo['display_order']][] = $paymentInfo;
								}
							}
							ksort($paymentOptionArray);
							if($paymentOptionArray) {
								foreach($paymentOptionArray as $key=>$paymentInfoval) {
									for($i=0;$i<count($paymentInfoval);$i++) {
									$paymentInfo = $paymentInfoval[$i];
									$jsfunction = 'onclick="showoptions(this.value);"';
									$chked = '';
									if($key==1) {
										$chked = 'checked="checked"';
									} ?>
								<li id="<?php echo $paymentInfo['key'];?>">
									<input <?php echo $jsfunction;?>  type="radio" value="<?php echo $paymentInfo['key'];?>" id="<?php echo $paymentInfo['key'];?>_id" name="paymentmethod" <?php echo $chked;?> />  <?php echo $paymentInfo['name']?>
		<?php					if(file_exists(TEMPLATEPATH.'/library/includes/payment/'.$paymentInfo['key'].'/'.$paymentInfo['key'].'.php')) { ?>
		<?php						include_once(TEMPLATEPATH.'/library/includes/payment/'.$paymentInfo['key'].'/'.$paymentInfo['key'].'.php');	} ?> 						</li>
		<?php						}
								}
							}else {	?>
								<li><?php _e(NO_PAYMENT_METHOD_MSG);?></li>
		<?php				}	?>
							</ul>
						</div>
		<?php			}
						if(get_option('pttthemes_captcha')=='Enable' && file_exists(ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php') && plugin_is_active('wp-recaptcha')){
							echo '<div class="form_row clearfix">';
						  	$a = get_option("recaptcha_options");
							echo '<label>Word verification</label>';
							$publickey = $a['public_key']; // you got this from the signup page
							echo recaptcha_get_html($publickey); 
							if($_REQUEST['emsg']=='captch'){echo '<span class="message_error2" id="category_span">'.__('Please enter valid text as you see in captcha','templatic').'</span>';}
							echo '</div>';
						} ?> 
						<input type="submit" id="submit" value="<?php echo BUY_DEAL_PAY_BUTTON;?>"/>
						<?php } ?>
						</form>
<script>
function showoptions(paymethod) {
<?php
for($i=0;$i<count($paymethodKeyarray);$i++)
{
?>
showoptvar = '<?php echo $paymethodKeyarray[$i]?>options';
if(eval(document.getElementById(showoptvar)))
{
	document.getElementById(showoptvar).style.display = 'none';
	if(paymethod=='<?php echo $paymethodKeyarray[$i]?>')
	{
		document.getElementById(showoptvar).style.display = '';
	}
}
<?php
}	
?>
}
<?php
for($i=0;$i<count($paymethodKeyarray);$i++)
{
?>
if(document.getElementById('<?php echo $paymethodKeyarray[$i];?>_id').checked)
{
showoptions(document.getElementById('<?php echo $paymethodKeyarray[$i];?>_id').value);
}
<?php
}	
?>
</script> 
						</form>
                   <!-- EOF Buy Section -->
					</div>     
				</div>  <!-- post content #end -->
        	</div> 
		</div>
	</div>
<?php }  else {
		echo '<script>location.href="'.site_url().'"</script>';
		exit;
	}?>
</div>
<!-- /Content -->
<div class="sidebar right" >
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar Right')){ } else {  }?>
</div>  <!-- sidebar #end -->
<script type="text/javascript">
function copy_billing_address() {
	if(document.getElementById('copybilladd').checked)
	{
		document.getElementById('shipping_address').style.display = 'none';
		
	}else
	{
		document.getElementById('shipping_address').style.display = 'block';
	}
}
</script>
<?php get_footer(); ?>
