<?php
	/********************************************************************
		You can add your filetes in this file and it will affected.
		This is the common filter functions file where you can add you filtes.
	********************************************************************/ 
	add_action("admin_init", "admin_init");
	
	add_action("save_post", "save_deal");
	function admin_init(){
		add_meta_box("dealInfo-meta", "Deal Options", "meta_options", "dagaanbiedingen", "normal", "high");
		
	}
	function get_post_custom_fields_templ_1()
	{
		global $wpdb,$custom_post_meta_db_table_name;
		$post_meta_info = $wpdb->get_results("select * from $custom_post_meta_db_table_name where is_active=1 and post_type = '".CUSTOM_POST_TYPE1."' order by sort_order asc,admin_title asc");
		$return_arr = array();
		if($post_meta_info){
			foreach($post_meta_info as $post_meta_info_obj){	
				if($post_meta_info_obj->ctype){
					$options = explode(',',$post_meta_info_obj->option_values);
				}
				$custom_fields = array(
				"name"		=> $post_meta_info_obj->htmlvar_name,
				"label" 	=> $post_meta_info_obj->clabels,
				"default" 	=> $post_meta_info_obj->default_value,
				"type" 		=> $post_meta_info_obj->ctype,
				"desc"      => $post_meta_info_obj->admin_desc,
				"option_values"      => $post_meta_info_obj->option_values,
				"site_title"      => $post_meta_info_obj->site_title,
				);
				if($options)
				{
					$custom_fields["options"]=$options;
				}
				$return_arr[$post_meta_info_obj->htmlvar_name] = $custom_fields;
			}
		}
		return $return_arr;
	}
	
	function meta_options(){
		
		global $post;
		
		$custom = get_post_custom($post->ID);
		$owner_name = $custom["owner_name"][0];
		$owner_email = $custom["owner_email"][0];
		$coupon_website = $custom["coupon_website"][0];
		$coupon_type = $custom["coupon_type"][0];
		$coupon_code = $custom["coupon_code"][0];
		$used_coupon_code = $custom["used_coupon_code"][0];
		$coupon_link = $custom["coupon_link"][0]; 
		if($custom["coupon_entry"][0] == 'coupon_entry_0')
		{		
			$single_coupon_code = $custom["coupon_code"][0];
			}else{
			$coupon_code = $custom["coupon_code"][0];
			
		}
		$is_expired = $custom["is_expired"][0];
		if($is_expired=='')
		$is_expired=0;
		$status = $custom["status"][0];
		if($status =='')
		$status=0;
		$our_price = $custom["our_price"][0];
		$current_price = $custom["current_price"][0];
		$coupon_address = $custom["coupon_address"][0];
		$no_of_coupon = $custom["no_of_coupon"][0];
		$fineprint = $custom["fineprint"][0];
		$thankyou_page_url = $custom["thankyou_page_url"][0];
		$coupon_entry = $custom["coupon_entry"][0];
		$coupon_start_date_time = date("Y-m-d H:i:s",$custom["coupon_start_date_time"][0]);
		$coupon_start_date_time_arry = explode(" ",$coupon_start_date_time);
		$product_images = $custom['file_name'][0];
		$min_purchases = $custom["min_purchases"][0];
		$filename = $custom["filename"][0];
		$max_purchases_user = $custom["max_purchases_user"][0];
		
		$shipping_address = $custom["shhiping_address"][0];
		$shipping_cost = $custom["shipping_cost"][0];
		$geo_latitude = $custom["geo_latitude"][0];
		$geo_longitude = $custom["geo_longitude"][0];
		
		if($coupon_start_date_time_arry[0]!="" && $coupon_start_date_time_arry[0]!="1970-01-01")
		$coupon_start_date = $coupon_start_date_time_arry[0];
		else
		$coupon_start_date = date("Y-m-d");
		$coupon_start_time = explode(":",$coupon_start_date_time_arry[1]);
		$coupon_start_time_hh = $coupon_start_time[0];
		$coupon_start_time_mm = $coupon_start_time[1];
		$coupon_start_time_ss = $coupon_start_time[2];
		
		if($custom["coupon_end_date_time"][0] != '') {
			$coupon_end_date_time = date("Y-m-d H:i:s",$custom["coupon_end_date_time"][0]);
			$coupon_end_date_time_arry = explode(" ",$coupon_end_date_time);
			if($coupon_end_date_time_arry[0]!="" && $coupon_end_date_time_arry[0]!="1970-01-01")
			$coupon_end_date = $coupon_end_date_time_arry[0];
			else
			$coupon_end_date = date("Y-m-d");
			$coupon_end_time = explode(":",$coupon_end_date_time_arry[1]);
			$coupon_end_time_hh = $coupon_end_time[0];
			$coupon_end_time_mm = $coupon_end_time[1];
			$coupon_end_time_ss = $coupon_end_time[2];
		}
	?>
	<script>var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dhtmlgoodies_calendar.js"></script>
	
	<script type="text/javascript">
		function coupon_change_type(ctype)
		{
			
			if(ctype=='1')
			{  	
				document.getElementById('afflink').style.display = "block";
				document.getElementById("no_of_coupons").style.display = "none";
				document.getElementById('multicode').style.display = "none";
				document.getElementById('singlecode').style.display = "none";
				document.getElementById('coupadd').style.display = "none";
				document.getElementById('coupon_entry').style.display = "none";
				document.getElementById('shipping_details').style.display = "none";
			}
			if(ctype=='2')
			{
				document.getElementById('media_upload').style.display = "block";
				document.getElementById("no_of_coupons").style.display = "none";
				document.getElementById('multicode').style.display = "none";
				document.getElementById('coupadd').style.display = "none";
				document.getElementById('singlecode').style.display = "none";
				document.getElementById('afflink').style.display = "none";
				
				document.getElementById('shipping_details').style.display = "none";
				
			}
			if(ctype=='3')
			{
				
				document.getElementById("no_of_coupons").style.display = "none";
				document.getElementById('multicode').style.display = "none";
				document.getElementById('coupon_entry').style.display = "block";
				document.getElementById('afflink').style.display = "none";
				document.getElementById('singlecode').style.display = "none";
				document.getElementById('coupadd').style.display = "none";
				document.getElementById('media_upload').style.display = "none";
				document.getElementById('shipping_details').style.display = "none";
			}
			if(ctype=='4')
			{
				document.getElementById('shipping_details').style.display = "block";
				document.getElementById("no_of_coupons").style.display = "none";
				document.getElementById('multicode').style.display = "none";
				document.getElementById('coupon_entry').style.display = "block";
				document.getElementById('afflink').style.display = "none";
				document.getElementById('singlecode').style.display = "none";
				document.getElementById('coupadd').style.display = "none";
				
				document.getElementById('media_upload').style.display = "none";
			}
			
			if(ctype == 'coupon_entry_0'  || document.getElementById('coupon_entry_0').checked == true)
			{
				
				document.getElementById('singlecode').style.display = "block";
				document.getElementById('coupon_entry').style.display = "block";
				document.getElementById("no_of_coupons").style.display = "none";
				document.getElementById('multicode').style.display = "none";
				document.getElementById('coupadd').style.display = "none";
				
				document.getElementById('media_upload').style.display = "none";
				
				
			}
			if(ctype == 'coupon_entry_1' || document.getElementById('coupon_entry_1').checked == true)
			{
				var no_of_c = document.getElementById('no_of_coupon').value;
				if(no_of_c == "")
				{
					alert("Please Enter Number of Items");
					document.getElementById('no_of_coupon').focus();
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
		function no_of_coupon1()
		{
			noofcoupon();
			return true;
		}
		function noofcoupon()
		{
			document.getElementById("coupons").innerHTML =  document.getElementById("no_of_coupon").value+" coupons";
			return true;
		}
		function coupon_count()
		{
			
			var cno = document.getElementById('no_of_coupon').value;
			if( document.getElementById('coupon_code').value!="")
			{
				var coupon_codes = document.getElementById('coupon_code').value;
				var spcoupon_codes = coupon_codes.split(",");
				var spcoupon_codes_count = spcoupon_codes.length;
				
				if( document.getElementById('used_coupon_code').value!="")
				{
					var used_coupon_code = document.getElementById('used_coupon_code').value;
					var used_coupon_code = used_coupon_code.split(",");
					var used_coupon_code_count = used_coupon_code.length;
					var spcoupon_codes_count = spcoupon_codes_count  + used_coupon_code_count;
				}
				if(cno!=spcoupon_codes_count)
				{
					document.getElementById('no_of_coupon').value =spcoupon_codes_count;
					alert("Number of coupon code should be" +cno );
					//return false;
				}
				
			}
			return true;
		}
		
		function admin_seller_edit(fid)
		{
			
			if(fid == 'Yes')
			{
				sid = '1';
			}else
			{
				sid='0';
			}
			if (fid=="")
			{
				document.getElementById("allowedit").innerHTML="";
				return;
			}
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("allowedit").innerHTML=xmlhttp.responseText;
					
					//location.href = 'admin.php?page=seller&allowedit=updated';
				}
			}
			
			url = "<?php echo get_template_directory_uri(); ?>/monetize/seller/ajax_seller_status.php?allowedit="+sid+"&allowsid="+fid
			xmlhttp.open("GET",url,true);
			xmlhttp.send();
		}
		function disable_endtime() {
			if(document.getElementById('enddate').checked == true)	{
				document.getElementById('end_deal_time').style.display = 'none';
				} else {
				document.getElementById('end_deal_time').style.display = 'block';
			}
		}
	</script>
	<link href="<?php bloginfo('template_directory'); ?>/library/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dhtmlgoodies_calendar.js"></script>
	<link href="<?php bloginfo('template_directory'); ?>/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />
	
	
	<div class="rows">
		<label class="label">Status :</label>
		<select type="select" name="status" id= "status">
			<option name="0" value="0" <?php if($status == '0') { ?>selected="selected" <?php } ?> >Set deal status </option>
			<option name="2" value="2" <?php if($status == '2') { ?>selected="selected" <?php } ?>><?php echo "Active"; ?></option>
			<option name="1" value="1" <?php if($status == '1') { ?>selected="selected" <?php } ?>><?php echo "Accept" ; ?> </option>
			
			<?php if($status != '2' || $status != '1' ) { ?>
				<option name="3" value="3" <?php if($status == '3') { ?>selected="selected" <?php } ?>><?php echo "Reject"; ?></option>
			<?php } ?>
			<?php if($status == '2' || $status == '1' ) { ?>
				<option name="4" value="4" <?php if($status == '4') { ?>selected="selected" <?php } ?>><?php echo "Terminate"; ?></option>
			<?php } ?>
		</select>
		<p class="notif">
			<?php echo _e('Active &rarr; feature on homepage. <br/>','templatic'); 
				if($status == 1 || $status == 2)
				{
					echo _e('Terminate &rarr; Remove this deal as featured on homepage. <br/>','templatic'); 
				}
				_e('Accept or reject the deal here.If you wish to feature this deal on homepage,select appropriate option.','templatic');
			?>
			
			
		</p>
	</div>
	
	<div class="rows">
		<label class="label"><?php echo _e('Name of the seller :','templatic'); ?></label>
		<input type="text" name="owner_name" value="<?php echo $owner_name; ?>" /> 
	</div>
	
	<div class="rows">
		<label class="label"><?php echo _e('Email of the seller :','templatic'); ?></label> 
		<input type="text" name="owner_email" value="<?php echo $owner_email; ?>" />
	</div>
	
	<div class="rows">
		<label class="label"><?php echo _e('Seller&rsquo;s website:','templatic'); ?></label>
		<input type="text" name="coupon_website" value="<?php echo $coupon_website; ?>" />
	</div>
	
	<div class="rows">
		<label class="label"><?php echo _e('Total number of items:','templatic'); ?></label>
		<input type="text" name="no_of_coupon" value="<?php echo $no_of_coupon; ?>" id="no_of_coupon" />
	</div>
	
	<div class="rows">
		<label class="label"><?php echo _e('Original price:','templatic'); ?></label>
		<input type="text" name="current_price" value="<?php echo $current_price; ?>" id="current_price" />
	</div>
	
	<div class="rows">
		<label class="label"><?php echo _e('Discounted price:','templatic'); ?></label>
		<input type="text" name="our_price" value="<?php echo $our_price; ?>" id="our_price" />
	</div>
	
	
	<div class="rows">    		
		<label class="label"><?php echo _e('&lsquo;Thank you&rsquo; page (Redirect URL) set by the seller','templatic'); ?> <span class="indicates">*</span></label> 
		<input type="text" class="textfield" id="thankyou_page_url" name="thankyou_page_url" value="<?php echo _e($thankyou_page_url,'templatic');?>"> 
		<span id="our_priceInfo" class="error"></span>
		<p class="notif">After a successful purchase, users will be taken to this page. </p> 
	</div>
	
	<div class="rows">   
		<input type="hidden" id="link_url" name="link_url" value="<?php	the_permalink();?>"/>
		<label class="label"><?php echo _e('Deal type selected by the seller','templatic'); ?></label>
		
		<select class="textfield" onchange="coupon_change_type(this.value);" name="coupon_type" id="coupon_type" >
			<option id="coupon_type_0" value="0" <?php if($coupon_type == '0') { ?>selected="selected"<?php } ?> ><?php echo "Deal types";?></option>
			
			<option id="coupon_type_1" value="1" <?php if($coupon_type == '1') { ?>selected="selected"<?php } ?>><?php echo DEAL_TYPES_1;?></option> 
			
			<option id="coupon_type_2" value="2" <?php if($coupon_type == '2') { ?>selected="selected"<?php } ?> ><?php echo DEAL_TYPES_2;?></option>
			
			<option id="coupon_type_3" value="3" <?php if($coupon_type == '3') { ?>selected="selected"<?php } ?> ><?php echo DEAL_TYPES_3;?></option>
			
			<option id="coupon_type_4" value="4" <?php if($coupon_type == '4') { ?>selected="selected"<?php } ?> ><?php echo DEAL_TYPES_4;?></option>
			
			<?php ?>
		</select>
	</div> 
	
	
	
	
	<?php echo '<input type="hidden" name="mytheme_meta_box_nonce" value="'.wp_create_nonce('deal_panel').'" />';?>
	
	
	<?php echo '<input type="hidden" name="mytheme_meta_box_nonce" value="'.wp_create_nonce('deal_panel').'" />';?>
	
	<div id="coupon_entry" <?php if($coupon_type == '2' || $coupon_type == '3' || $coupon_type == '4' || $coupon_entry != '' ) { ?>style="display:block;"<?php }else{ ?>style="display:none;"<?php } ?>>
		<div class="rows clearfix">
			
			<label class="label"><?php _e('Seller wants to provide','templatic');  if($coupon_entry == "coupon_entry_0"){ echo "<b>".SINGLE_COUPON_TEXT."</b>"; }else{ echo "<b>".MULTIPPLE_COUPON_TEXT."</b>"; } ?> <span class="indicates">*</span></label>
			<p>
				<label class="label">
					<input type="radio" name="coupon_entry" value="coupon_entry_0" id="coupon_entry_0" onclick="coupon_change_type(this.value);" <?php if($coupon_entry == 'coupon_entry_0') { ?> checked="checked"<?php } ?>/>
				<?php echo SINGLE_COUPON_TEXT; ?></label>
				
				<label class="label">
					<input type="radio" name="coupon_entry" value="coupon_entry_1" id="coupon_entry_1" onclick="coupon_change_type(this.value);" <?php if($coupon_entry == 'coupon_entry_1') { ?> checked="checked"<?php } ?> />
				<?php echo MULTIPPLE_COUPON_TEXT; ?></label>
				
			</p>
			<span id="coupon_info" class="error"></span>
		</div>
	</div>
	
	
	<div class="rows" id="no_of_coupons" style="display:none;">
		<?php echo _e('Please enter ','templatic');?><span style="font-weight:bold;" id="coupons"></span>
	</div>	
	
	<div class="rows" id="afflink" style=" <?php if($coupon_type == '1'){ ?>display:block;<?php  }else{?>display:none; <?php }?>">
		<label class="label"><?php echo _e('Your Affiliate Link:','templatic');?></label> 
		<input type="text" name="coupon_link" value="<?php echo $coupon_link; ?>" />
		<p class="notif">Enter your affiliate link for this coupon.</p>
	</div>
	
	<div class="rows" id="media_upload" name="media_upload" style=" <?php if($coupon_type == '2'){ ?>display:block;<?php  }else{?>display:none; <?php }?>">
		
		<label class="label"><?php echo UPLOAD_PRODUCT_TEXT; ?></label>
		<input type="text" name="_wp_attached_file" id="_wp_attached_file" value="<?php echo $custom["_wp_attached_file"][0]; ?>"/>
	</div>
	
	<div id="_wp_attached_file_div" class="iframe" >
		<iframe name="mktlogoframe" id="upload_target" style="border: none; width:100%; height: 75px;" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" src="<?php bloginfo('template_directory'); ?>/monetize/upload/index.php?img=_wp_attached_file&nonce=mktnonce" ></iframe>
	</div> 
	
	
	
	
	<div class="rows" id="singlecode" <?php if($coupon_entry == 'coupon_entry_0'){ ?>style="display:block;" <?php }else if($coupon_type =='1' || $coupon_type =='2' || $coupon_type =='') { ?>style="display:none;"<?php }else{ ?>style="display:none;"<?php } ?>>
		<div class="form_row clearfix">
			<label class="label"><?php echo PRO_ADD_COUPON_TEXT; ?></label> 
			<input type="text" name="coupon_code1" class="textfield" value="<?php if($coupon_entry == 'coupon_entry_0') { echo $single_coupon_code; } ?>"/> 
		</div>	
		<p class="notif"><?php echo SINGLE_COUPON_TEXT; ?></p>
		
	</div>
	
	<div class="rows" id="multicode" <?php if($coupon_entry == 'coupon_entry_1'){ ?>style="display:block;" <?php }else if($coupon_type =='1' || $coupon_type =='2' || $coupon_type =='') { ?>style="display:none;"<?php }else{ ?>style="display:none;"<?php } ?>>
		<label class="label"><?php echo PRO_ADD_COUPON_TEXT; ?></label> 
		<textarea rows="4" cols="60" id="coupon_code" name="coupon_code"  class="textfield"><?php if($coupon_entry == 'coupon_entry_1') { echo $coupon_code; } ?></textarea>
		<p class="notif"><?php echo COMMA_SEPRATED_DEAL_CODE_TEXT; ?></p>
	</div> 			
	
	<div class="rows clearfix">
		<label class="label"><?php echo MIN_PUR_TEXT; ?> </label>
		<input type="text" class="textfield" id="min_purchases" name="min_purchases" value="<?php echo $min_purchases; ?>">
		<span id="min_purchaseinfo" class="error"></span>
		<p class="notif"><?php echo MIN_PUR_MSG;?></p>
	</div>
	
	
	<div class="rows clearfix">
		<label class="label"><?php echo MAX_USERPUR_TEXT; ?></label> 
		<input type="text" class="textfield" id="max_purchases_user" name="max_purchases_user" value="<?php echo $max_purchases_user; ?>">
		<span id="max_userpurchaseinfo" class="error"></span>
		<p class="notif"><?php echo MAX_USERPUR_MSG;?></p>
	</div>
	
	<div class="rows"  id="shipping_details" <?php if($coupon_type == '4') { ?>style="display:block;" <?php }else{ ?>style="display:none;"<?php } ?>>
		<h4 class="title"><?php echo SHIPPING_DETAIL_TEXT; ?> </h4>
		<div class="rows clearfix">
			<label class="label"><?php echo SHIPPINGCOST_TEXT; ?> <span class="indicates">*</span></label> 
			<input type="text" class="textfield" id="shipping_cost" name="shipping_cost" value="<?php echo _e($shipping_cost,'templatic');?>">
			<span id="shippingcost_info" class="error"></span>
		</div>
		
		
		<div class="rows clearfix">
			<label class="label"><?php echo SHIPPINGADRS_TEXT; ?> <span class="indicates">*</span></label>
			<input type="text" class="textfield" id="address" name="shhiping_address" value="<?php echo _e($shipping_address,'templatic');?>"> 
		<span id="shipping_info" class="error"></span></div>
		<?php  
			if(get_option('ptttheme_google_map_opt') == 'Enable' && get_option('pttheme_google_map_api') != '') {?>
			<div class="rows clearfix">
				<?php include_once(TEMPLATEPATH . "/library/map/location_add_map.php");?>
				<p class="notif"><?php echo GET_MAP_MSG;?></p>
			</div> 
			
			<div class="rows clearfix">
				<label class="label"><?php echo EVENT_ADDRESS_LAT;?> </label>
				<input type="text" name="geo_latitude" id="geo_latitude" class="textfield" value="<?php echo $geo_latitude; ?>" size="25"  /> 
				<p class="notif"><?php echo GET_LATITUDE_MSG;?></p>
			</div>
			<div class="rows clearfix">
				<label class="label"><?php echo EVENT_ADDRESS_LNG;?> </label>
				<input type="text" name="geo_longitude" id="geo_longitude" class="textfield" value="<?php echo $geo_longitude; ?>" size="25"  />
				<p class="notif"><?php echo GET_LOGNGITUDE_MSG;?></p>
			</div>
		<?php } ?>
	</div>
	
	<div class="rows ">	 			
		<label class="label"><?php echo _e('Deal start date & time:','templatic');?></label> 
		<input type="text" name="coupon_start_date"  id="coupon_start_date"  style="width:100px;"  value="<?php echo $coupon_start_date; ?>"/>
		&nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal_s.png" alt="Calendar" onclick="displayCalendar(document.post.coupon_start_date,'yyyy-mm-dd',this)" style="cursor: pointer;" align="absmiddle" border="0">&nbsp;&nbsp;
		<label>HH:</label>
		<select name="coupon_start_time_hh">
			<?php
				for($i=0;$i<=23;$i++){
					if($i<10)
					$i="0".$i;
				?>
				<option value="<?php echo $i;?>" <?php if($coupon_start_time_hh==$i){?> selected="selected" <?php } ?>><?php echo $i;?></option>
			<?php }?>
		</select>&nbsp;&nbsp;
		<label>MM:</label>
		<select name="coupon_start_time_mm">
			<?php
				for($i=0;$i<=59;$i++){
					if($i<10)
					$i="0".$i;
				?>
				<option value="<?php echo $i;?>" <?php if($coupon_start_time_mm==$i){?> selected="selected" <?php } ?>><?php echo $i;?></option>
			<?php }?>
		</select>&nbsp;&nbsp;
		<label>MM:</label>
		<select name="coupon_start_time_ss">
			<?php
				for($i=0;$i<=59;$i++){
					if($i<10)
					$i="0".$i;
				?>
				
				<option value="<?php echo $i;?>" <?php if($coupon_start_time_ss==$i){?> selected="selected" <?php } ?>><?php echo $i;?></option>
			<?php }?>
		</select>
	</div>
	
	<div class="rows clearfix">
		<label class="label"><?php echo _e('Deal end date & time:','templatic');?></label> 
		
		<span class="disable_checkbox" ><label>
		<input name="enddate" id="enddate" type="checkbox" value="0" onchange="disable_endtime()"<?php if($custom['enddate'][0] == "0") { ?>checked<?php } ?> /><?php echo DISABLE_END_TIME; ?></label>
		</span>
		<div class="form_row clearfix" id="end_deal_time" <?php if($custom['enddate'][0] == "0") { ?>style="display:none" <?php } ?>>	
			<input type="text" name="coupon_end_date"  id="coupon_end_date"  style="width:100px;"  value="<?php echo $coupon_end_date; ?>"/>
			&nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal_s.png" alt="Calendar" onclick="displayCalendar(document.post.coupon_end_date,'yyyy-mm-dd',this)" style="cursor: pointer;" align="absmiddle" border="0">&nbsp;&nbsp;
			<label>HH:</label>
			<select name="coupon_end_time_hh">
				<?php
					for($i=0;$i<=23;$i++){
						if($i<10)
						$i="0".$i;
					?>
					<option value="<?php echo $i;?>" <?php if($coupon_end_time_hh==$i){?> selected="selected" <?php } ?>><?php echo $i;?></option>
				<?php }?>
			</select>&nbsp;&nbsp;
			<label>MM:</label>
			<select name="coupon_end_time_mm">
				<?php
					for($i=0;$i<=59;$i++){
						if($i<10)
						$i="0".$i;
					?>
					<option value="<?php echo $i;?>" <?php if($coupon_end_time_mm==$i){?> selected="selected" <?php } ?>><?php echo $i;?></option>
				<?php }?>
			</select>&nbsp;&nbsp;
			<label>MM:</label>
			<select name="coupon_end_time_ss">
				<?php
					for($i=0;$i<=59;$i++){
						if($i<10)
						$i="0".$i;
					?>
					<option value="<?php echo $i;?>" <?php if($coupon_end_time_ss==$i){?> selected="selected" <?php } ?>><?php echo $i;?></option>
				<?php }?>
			</select>
		</div> 
	</div>
	<div class="rows clearfix"> 
		<label class="label">Deal image :</label> 	 
		<input type="text" name="file_name" id="file_name" value="<?php echo $custom["file_name"][0]; ?>"/>
	</div>
	<div class="rows clearfix"> 
		<img src ="<?php echo templ_thumbimage_filter($custom["file_name"][0],285,275); ?>" width="285" height="275" alt="deal image" />
	</div>
	<div id="file_name_div" class="iframe" >
		<iframe name="mktlogoframe" id="upload_target" style="border: none; width:100%; height: 75px;" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" src="<?php bloginfo('template_directory'); ?>/monetize/upload/index.php?img=file_name&nonce=mktnonce" ></iframe>
	</div>    
	<div class="rows clearfix">       
		
		<?php 
			if(isset($_REQUEST['post']) || $_REQUEST['post'] != "") {
				if( $is_expired == 1) { ?> <?php echo _e('This deal has expired','templatic'); ?> <?php }else{ 
					echo "This deal will expire on "."<b>".$coupon_end_date_time."</b>";
				?>		
			<?php } }
		?><input type="hidden" name="is_expired" value="<?php _e($is_expired,'templatic'); ?>"/>
	</div>
	
	<?php 
		/*$custom_metaboxes = get_post_custom_fields_templ_1();
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
			$value = get_post_meta($_REQUEST['editdeal'], $name,true);
			
			?>
			<div class="rows clearfix">
			<?php if($type=='text'){?>
			<label class="label"><?php echo $site_title; ?></label>
			<input name="<?php echo $name;?>" id="<?php echo $name;?>" value="<?php echo $value;?>" type="text" class="textfield" />
			<?php 
			}elseif($type=='checkbox'){
			?>     
			
			<input name="<?php echo $name;?>" id="<?php echo $name;?>" <?php if($value){ echo 'checked="checked"';}?>  value="<?php echo $value;?>" type="checkbox" /> <?php echo $site_title; ?>
			<?php
			}
			elseif($type=='multicheckbox')
			{ ?>
			<label class="label"><?php echo $site_title; ?></label>
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
			}
			
			elseif($type=='texteditor'){
			?>
			<label class="label"><?php echo $site_title; ?></label>
			<textarea name="<?php echo $name;?>" id="<?php echo $name;?>" cols="55" class="mce"><?php echo $value;?></textarea>       
			<?php
			}elseif($type=='select'){
			?>
			<label class="label"><?php echo $site_title; ?></label>
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
			<span class="message_note"><?php echo $admin_desc;?></span>
			</div>
			<?php }
		}*/?>
		
		<?php
		}
		function save_deal($post_id){
			global $post;
			
			if ( !wp_verify_nonce( $_POST['mytheme_meta_box_nonce'], 'deal_panel' )) {
				return $post_id;
			}
			$uploadpath = wp_upload_dir(); 
			$tmpfolder = $uploadpath['baseurl'].'/tmp/';
			$imgstr = '';
			if($_POST["file_info"] != ''){
				foreach($_POST["file_info"] as $key=>$val)
				{
					$imagepath =  $tmpfolder.$key.'.jpg';	
					$imgstr .= '<a href="'.$imagepath.'" target="_blank" ><img src="'.$imagepath.'" height="100" width="100" alt="" /></a> &nbsp; &nbsp;';
				}}
				$user_fname = $_POST['owner_name'];
				$user_email = $_POST['owner_email'];
				$deal_title = '<a href="'.$_POST['link_url'].'">'.$_POST['post_title'].'</a>';
				$deal_desc = $_POST['post_content'];
				
				$coupon_website = $_POST['coupon_website'];
				$no_of_coupon = $_POST['no_of_coupon'];
				$our_price = $_POST['our_price'];
				$current_price =$_POST['current_price'];
				$coupon_type = $_POST['coupon_type'];
				if($_POST['coupon_entry'] == 'coupon_entry_0') { 
					$single_coupon_code =$_POST['coupon_code1'];
					}else{
					$coupon_code= $_POST['coupon_code'];
				}
				//echo  $coupon_code= $_POST['coupon_code'];
				
				$coupon_address = $_POST['coupon_address'];
				$coupon_link = $_POST['coupon_link'];
				$mediafilename = $_POST['media_file'];
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
				
				// Start All Transection Details With Deal
				if($coupon_type=='4' || $coupon_type=='5')
				{
					if($coupon_address!="")	{
						$transaction_details = sprintf(__("
						<p><h3>Deal Details</h3> \r</p>
						<p><strong>Deal Title: </strong>%s \r	</p>
						<p><strong>Deal Desc: </strong>%s \r	</p>
						<p><strong>Deal Type: </strong>%s \r	</p>
						<p><strong>Original Price: </strong>%s \r	</p>
						<p><strong>Current Price: </strong>%s \r	</p>
						<p><strong>Store Address:</strong> %s \r	</p>
						",'templatic'),$deal_title,$deal_desc,$coupon_code,get_currency_sym().$current_price,get_currency_sym().$our_price,$current_price,$coupon_address);
						} else	{
						$transaction_details = sprintf(__("
						<p><h3>Deal Details </h3> \r</p>
						<p><strong>Deal Title:</strong> %s \r</p>
						<p><strong>Deal Desc:</strong> %s \r	</p>
						<p><strong>Deal Type: </strong>%s \r	</p>
						<p><strong>Original Price: </strong>%s \r	</p>
						<p><strong>Current Price: </strong>%s \r	</p>
						",'templatic'),$deal_title,$deal_desc,$coupon_code,$coupon_type,get_currency_sym().$current_price,get_currency_sym().$our_price);
					}
					}	else {
					
					$transaction_details = sprintf(__("
					<p><h3>Deal Details </h3>\r</p>
					<p><strong>Deal Title:</strong> %s \r</p>
					<p><strong>Deal Coupon:</strong> %s \r	</p>
					<p><strong>Deal Type:</strong> %s \r	</p>
					<p><strong>Original Price: </strong>%s \r	</p>
					<p><strong>Current Price: </strong>%s \r	</p>
					",'templatic'),$deal_title,$single_coupon_code,$coupon_type,get_currency_sym().$current_price,get_currency_sym().$our_price);
				}
				// End All Transection Details With Deal	
				$fromEmail = get_site_emailId();
				$fromEmailName = get_site_emailName();
				$store_name = get_option('blogname');
				if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
				return $post_id;
				if($_POST["status"]!="") {
					global $post;
					$pre = get_post_meta($post->ID,'status',true);
					if($pre != $_POST["status"]) 
					{
						update_post_meta($post->ID, "status", $_POST["status"]);
						if($_POST["status"] == '2'){ 
							update_post_meta($post->ID,"is_show",'1');
						} 
						if($_POST["status"] == '1' || $_POST["status"] == '2'){
							$client_message = get_option('req_accept_success_email_content');
							$users_details = sprintf(__("
							<p><h3>Seller Details</h3> \r</p>
							<p><strong>Name:</strong> %s \r	</p>
							<p><strong>Email:</strong> %s \r	</p>",'templatic'),$user_fname,$user_email);
							$subject = get_option('req_accept_success_email_subject');
							$search_array = array('[#to_name#]','[#site_name#]','[#deal_details#]','[#seller_details#]');
							$replace_array = array($user_fname.",",$store_name,$transaction_details,$users_details);
							$email_seller_content = str_replace($search_array,$replace_array,$client_message);	
							if(get_option('pttthemes_send_mail') == 'Enable' || get_option('pttthemes_send_mail') == '') {
								templ_sendEmail($fromEmail,$fromEmailName,$user_email,$user_fname,$subject,$email_seller_content,$extra='');
							}
							}  else if($_POST["status"] == '3' ) {
							$fromEmail = get_site_emailId();
							$fromEmailName = get_site_emailName();
							$store_name = get_option('blogname');
							$client_message = get_option('req_reject_success_email_content');
							$subject = get_option('req_reject_success_email_subject');
							$search_array = array('[#to_name#]','[#site_name#]');
							$replace_array = array($user_fname.",",$store_name);
							$email_seller_content = str_replace($search_array,$replace_array,$client_message);	
							if(get_option('pttthemes_send_mail') == 'Enable' || get_option('pttthemes_send_mail') == '') {
								templ_sendEmail($fromEmail,$fromEmailName,$user_email,$userName,$subject,$email_seller_content,$extra='');
							}
							} else {
							// Do nothing
						}
						}else{
						if($_POST["status"] == '2'){ 
							update_post_meta($post->ID,"is_show",'1');
						} 
						
					}
				}
				else
				delete_post_meta($post->ID, "status", $_POST["status"]);
				
				if($_POST["owner_name"]!="")
				update_post_meta($post->ID, "owner_name", $_POST["owner_name"]);
				else
				delete_post_meta($post->ID, "owner_name", $_POST["owner_name"]);
				if($_POST["_wp_attached_file"]!="")
				update_post_meta($post->ID, "_wp_attached_file", $_POST["_wp_attached_file"]);
				else
				delete_post_meta($post->ID, "_wp_attached_file", $_POST["_wp_attached_file"]);
				
				if($_POST["owner_email"]!="")
				update_post_meta($post->ID, "owner_email", $_POST["owner_email"]);
				else
				delete_post_meta($post->ID, "owner_email", $_POST["owner_email"]);
				
				
				if($_POST["thankyou_page_url"]!="")
				update_post_meta($post->ID, "thankyou_page_url", $_POST["thankyou_page_url"]);
				else
				delete_post_meta($post->ID, "thankyou_page_url", $_POST["thankyou_page_url"]);
				
				if($_POST["coupon_website"]!="")
				update_post_meta($post->ID, "coupon_website", $_POST["coupon_website"]);
				else
				delete_post_meta($post->ID, "coupon_website", $_POST["coupon_website"]);
				
				if($_POST["no_of_coupon"]!="")
				update_post_meta($post->ID, "no_of_coupon", $_POST["no_of_coupon"]);
				else
				delete_post_meta($post->ID, "no_of_coupon", $_POST["no_of_coupon"]);
				
				if($_POST["coupon_type"]!="")
				update_post_meta($post->ID, "coupon_type", $_POST["coupon_type"]);
				else
				delete_post_meta($post->ID, "coupon_type", $_POST["coupon_type"]);
				
				if($_POST["coupon_entry"]!="")
				{
					update_post_meta($post->ID, "coupon_entry", $_POST["coupon_entry"]);
					if($_POST["coupon_entry"]== "coupon_entry_0")
					{
						update_post_meta($post->ID, "coupon_code", $_POST["coupon_code1"]);
						}else{
						update_post_meta($post->ID, "coupon_code", $_POST["coupon_code"]);
					}
				}
				else{
					delete_post_meta($post->ID, "coupon_entry", $_POST["coupon_entry"]);
					delete_post_meta($post->ID, "coupon_code", $_POST["coupon_code"]);
				}
				
				if($_POST["min_purchases"]!="")
				update_post_meta($post->ID, "min_purchases", $_POST["min_purchases"]);
				else
				delete_post_meta($post->ID, "min_purchases", $_POST["min_purchases"]);
				
				
				if($_POST["max_purchases_user"]!="")
				update_post_meta($post->ID, "max_purchases_user", $_POST["max_purchases_user"]);
				else
				delete_post_meta($post->ID, "max_purchases_user", $_POST["max_purchases_user"]);
				
				if($_POST["shhiping_address"]!="")
				update_post_meta($post->ID, "shhiping_address", $_POST["shhiping_address"]);
				else
				delete_post_meta($post->ID, "shhiping_address", $_POST["shhiping_address"]);
				
				if($_POST["shipping_cost"]!="")
				update_post_meta($post->ID, "shipping_cost", $_POST["shipping_cost"]);
				else
				delete_post_meta($post->ID, "shipping_cost", $_POST["shipping_cost"]);
				
				if($_POST["geo_latitude"]!="")
				update_post_meta($post->ID, "geo_latitude", $_POST["geo_latitude"]);
				else
				delete_post_meta($post->ID, "geo_latitude", $_POST["geo_latitude"]);
				
				if($_POST["geo_longitude"]!="")
				update_post_meta($post->ID, "geo_longitude", $_POST["geo_longitude"]);
				else
				delete_post_meta($post->ID, "geo_longitude", $_POST["geo_longitude"]);
				
				
				if($_POST["coupon_type"]=="3" || $_POST["coupon_type"]=="4")
				{
					
					if($_POST["coupon_code"]=="")
					{
						$sys_gen_coupon = '';
						if($single_coupon_code == '')
						{
							for($c=0;$c<$_POST["no_of_coupon"];$c++)
							{   
								$user_coup = wp_generate_password(3,false);
								$sys_gen_coupon.=$post->ID.$user_coup.",";
							}
							$sys_gen_coupon = trim($sys_gen_coupon,",");
						}
						else
						{
							$sys_gen_coupon = $single_coupon_code;
						}
						update_post_meta($post->ID, "coupon_code", $sys_gen_coupon);
						}else{
						$totcop = $_POST["coupon_code"];
						if($_POST["used_coupon_code"]!="")
						$totcop .= ",".$_POST["used_coupon_code"];
						$totalcpoarr = explode(",",$totcop);
						if(sizeof($totalcpoarr)==$_POST["no_of_coupon"]){
						}elseif($_POST["no_of_coupon"]>sizeof($totalcpoarr))
						{
							$totorigcop = $_POST["coupon_code"];
							$extra_coupon=  $_POST["no_of_coupon"] - sizeof($totalcpoarr);
							for($c=0;$c<$extra_coupon;$c++)
							{   
								$user_coup = wp_generate_password(3,false);
								$sys_gen_coupon.=$post->ID.$user_coup.",";
							}
							$sys_gen_coupon = trim($sys_gen_coupon,",");
							$addextra = $totorigcop.",".$sys_gen_coupon; 
							update_post_meta($post->ID, "coupon_code", $addextra);
						}
						
						
					}
				}
				if($_POST["used_coupon_code"]!="")
				update_post_meta($post->ID, "used_coupon_code", $_POST["used_coupon_code"]);
				else
				delete_post_meta($post->ID, "used_coupon_code", $_POST["used_coupon_code"]);
				
				
				if($_POST["coupon_address"]!="")
				update_post_meta($post->ID, "coupon_address", $_POST["coupon_address"]);
				else
				delete_post_meta($post->ID, "coupon_address", $_POST["coupon_address"]);
				
				
				if($_POST["coupon_link"]!="")
				update_post_meta($post->ID, "coupon_link", $_POST["coupon_link"]);
				else
				delete_post_meta($post->ID, "coupon_link", $_POST["coupon_link"]);
				
				if($_POST["file_name"]!="")
				update_post_meta($post->ID, "file_name", $_POST["file_name"]);
				else
				delete_post_meta($post->ID, "file_name", $_POST["file_name"]);
				
				
				if($_POST["coupon_start_date"]!="" && $_POST["coupon_start_time_hh"]!="" && $_POST["coupon_start_time_mm"]!="" && $_POST["coupon_start_time_ss"]!=""){
					//echo $_POST["coupon_start_date"]." ".$_POST["coupon_start_time_hh"].":".$_POST["coupon_start_time_mm"].":".$_POST["coupon_start_time_ss"];
					$coupon_start_date_time=strtotime($_POST["coupon_start_date"]." ".$_POST["coupon_start_time_hh"].":".$_POST["coupon_start_time_mm"].":".$_POST["coupon_start_time_ss"]);	
					update_post_meta($post->ID, "coupon_start_date_time", $coupon_start_date_time);
					}else{
				delete_post_meta($post->ID, "coupon_start_date_time", $coupon_start_date_time);}
				if($_POST["enddate"]!="" || isset($_POST["enddate"]) )
				{
					update_post_meta($post->ID, "coupon_end_date_time",'');
					update_post_meta($post->ID, "enddate", '0');
					if(get_post_meta($post->ID, 'is_expired' , true) != '0') 
					{
						update_post_meta($post->ID, "is_expired", '0');
					}
					}else{
					if($_POST["coupon_end_date"]!="" && $_POST["coupon_end_time_hh"]!="" && $_POST["coupon_end_time_mm"]!="" && $_POST["coupon_end_time_ss"]!=""){
						$_POST["coupon_end_date"]." ".$_POST["coupon_end_time_hh"].":".$_POST["coupon_end_time_mm"].":".$_POST["coupon_end_time_ss"];
						$coupon_end_date_time=strtotime($_POST["coupon_end_date"]." ".$_POST["coupon_end_time_hh"].":".$_POST["coupon_end_time_mm"].":".$_POST["coupon_end_time_ss"]);	
						update_post_meta($post->ID, "coupon_end_date_time", $coupon_end_date_time);
						if(get_post_meta($post->ID, 'is_expired' , true) != '0') 
						{
							update_post_meta($post->ID, "is_expired", '0');
						}
						}else{
						update_post_meta($post->ID, "coupon_end_date_time", "");
					}
					update_post_meta($post->ID, "enddate", '');
				}
				//update_post_meta($post->ID, "is_expired", $_POST["is_expired"]);
				
				if($_POST["is_expired"] != "")
				{
					//update_post_meta($post->ID, "is_expired", $_POST["is_expired"]);
				}
				else
				{
					//update_post_meta($post->ID, "is_expired", '0');
				}	
				if($_POST["our_price"]!="")
				update_post_meta($post->ID, "our_price", $_POST["our_price"]);
				else
				delete_post_meta($post->ID, "our_price", $_POST["our_price"]);
				
				
				if($_POST["current_price"]!="")
				update_post_meta($post->ID, "current_price", $_POST["current_price"]);
				else
				delete_post_meta($post->ID, "current_price", $_POST["current_price"]);
				
				global $post, $meta_boxes, $key;
				
				if ( !wp_verify_nonce( $_POST[ $key . '_wpnonce' ], plugin_basename(__FILE__) ) )
				return $post_id;
				
				if ( !current_user_can( 'edit_post', $post_id ))
				return $post_id;
				
				foreach( $meta_boxes as $meta_box ) {
					update_post_meta( $post_id, $meta_box[ 'name' ], $_POST[ $meta_box[ 'name' ] ] );
				}
				
				
		}
		
		add_filter('templ_page_title_filter','templ_page_title_fun');
		function templ_page_title_fun($title)
		{
			return '<h1>'.$title.'</h1>';
		}
		
		add_filter('templ_theme_guide_link_filter','templ_theme_guide_link_fun');
		function templ_theme_guide_link_fun($guidelink)
		{
			$guidelink .= "theme-documentation/dailydeal-theme-guide"; // templatic.com site theme guide url here
			return $guidelink;
		}
		
		add_filter('templ_theme_forum_link_filter','templ_theme_forum_link_fun');
		function templ_theme_forum_link_fun($forumlink)
		{
			$forumlink .= "viewforum.php?f=76"; // templatic.com site Forum url here
			return $forumlink;
		}
		
		
		
		
		/*add_filter('templ_msg_notifications_filter','templ_msg_notifications_fun');
			function templ_msg_notifications_fun($content)
			{
			unset($content[0]);
			return $content;
		}*/
		/*add_filter('templ_sidebar_widget_box_filter','templ_sidebar_widget_box_fun');
			function templ_sidebar_widget_box_fun($content)
			{
			return $content;
		}*/
		/*add_filter('templ_widgets_listing_filter','templ_widgets_listing_fun');
			function templ_widgets_listing_fun($content)
			{
			return $content;
			}
		*/
		add_filter('templ_admin_menu_title_filter','templ_admin_menu_title_fun');
		function templ_admin_menu_title_fun($content)
		{
			return $content=__('Daily Deal','templatic');
		}
		
		/////////search widget filter start/////////////
		add_action('pre_get_posts', 'search_filter');
		function search_filter($local_wp_query) 
		{
			if(is_search())
			{
				add_filter('posts_where', 'searching_filter_where');
			}else
			{
				remove_filter('posts_where', 'searching_filter_where');	
			}
		}
		
		function searching_filter_where($where) {
			global $wpdb;
			$scat = trim($_REQUEST['catdrop']);
			$todate = trim($_REQUEST['todate']);
			$frmdate = trim($_REQUEST['frmdate']);
			$articleauthor = trim($_REQUEST['articleauthor']);
			$exactyes = trim($_REQUEST['exactyes']);
			if($scat>0)
			{
				$where .= " AND  $wpdb->posts.ID in (select $wpdb->term_relationships.object_id from $wpdb->term_relationships join $wpdb->term_taxonomy on $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id and $wpdb->term_taxonomy.term_id=\"$scat\" ) ";
			}
			if($todate!="")
			{
				$where .= " AND   DATE_FORMAT($wpdb->posts.post_date,'%Y-%m-%d') >='".$todate."'";
			}
			else if($frmdate!="")
			{
				$where .= " AND  DATE_FORMAT($wpdb->posts.post_date,'%Y-%m-%d') <='".$frmdate."'";
			}
			else if($todate!="" && $frmdate!="")
			{
				$where .= " AND  DATE_FORMAT($wpdb->posts.post_date,'%Y-%m-%d') BETWEEN '".$todate."' and '".$frmdate."'";
			}
			if($articleauthor!="" && $exactyes!=1)
			{
				$where .= " AND  $wpdb->posts.post_author in (select $wpdb->users.ID from $wpdb->users where $wpdb->users.display_name  like '".$articleauthor."') ";
			}
			if($articleauthor!="" && $exactyes==1)
			{
				$where .= " AND  $wpdb->posts.post_author in (select $wpdb->users.ID from $wpdb->users where $wpdb->users.display_name  = '".$articleauthor."') ";
			}
			return $where;
		}
		/////////search widget filter end/////////////
		
		add_filter('templ_admin_post_custom_fields_filter','templ_admin_post_custom_fields_fun');
		function templ_admin_post_custom_fields_fun($array)
		{
			$pt_metaboxes = $array;
			$pt_metaboxes["custofiled"] = array (
			"name"		=> "custofiled",
			"default" 	=> "",
			"label" 	=> __("Custom Title"),
			"type" 		=> "text",
			"desc"      => __("Enter Custom Title. eg. : code from youtibe, vimeo, etc")
			);
			return $pt_metaboxes;
		}
		
		
		add_filter('templ_breadcrumbs_navigation_filter','templ_breadcrumbs_navigation_fun');
		function templ_breadcrumbs_navigation_fun($bc)
		{
			$sep_array = get_option('yoast_breadcrumbs');
			$sep = $sep_array['sep'];
			if(strstr($bc,CUSTOM_MENU_TAG_TITLE)) {
				$templ = substr($bc, strrpos($bc,'. '.$sep.' '.CUSTOM_MENU_TAG_TITLE.':') , strlen($bc));
				$arr = explode($sep,$templ);
				$bc = str_replace($arr[1],'',$bc);
			}	
			$bread = str_replace('. '.$sep,' '.$sep,$bc);
			$bread = str_replace(CUSTOM_MENU_CAT_TITLE.':','',$bread);
			$bread = str_replace(', and',',',$bread);
			$bread = str_replace(' and ',', ',$bread);
			$bread = str_replace(' '.$sep.$sep.' ',' '.$sep.' ',$bread);
			$bread = str_replace(' '.$sep.'  '.$sep.' ',' '.$sep.' ',$bread);
			
			return $bread;	
		}
		
		add_action('templ_page_title_above','templ_page_title_below_fun'); //page title above action hook
		add_action('templ_page_title_below','templ_page_title_below_fun');  //page title below action hook
		function templ_page_title_below_fun()
		{
			//templ_set_breadcrumbs_navigation();
		}
		
		add_filter('templ_anything_slider_widget_content_filter','templ_anything_slider_content_fun');
		function templ_anything_slider_content_fun($post)
		{
			ob_start(); // don't remove this code
			
			if(get_the_post_thumbnail( $post->ID, array())){
			?>
			<a class="post_img" href="<?php echo get_permalink($post->ID);?>"><?php echo  get_the_post_thumbnail( $post->ID, array(220,220),array('class'	=> "",));?></a>
			<?php
				}else if($post_images = bdw_get_images($post->ID,'medium')){ 
				global $thumb_url;
			?>
			
			<?php
				$crop_image = vt_resize( '', $post_images[0], 220, 220, $crop = true );
				$imgurl = $crop_image['url'];
			?>
			<a class="post_img" href="<?php echo get_permalink($post->ID); ?>"><img src="<?php echo $imgurl; ?>" alt="<?php echo get_the_title($post->ID); ?>" title="<?php echo get_the_title($post->ID); ?>" /></a>
			
		<?php } ?>
		<div class="tslider3_content">
			<h3> <a class="widget-title" href="<?php echo get_permalink($post->ID);?>"><?php echo get_the_title($post->ID);?></a></h3>
			<p>
			<?php echo bm_better_excerpt(605, ' ... ');?></p>
			<p><a href="<?php echo get_permalink($post->ID);?>" class="more"><?php _e('Read More','templatic')?></a></p>
		</div>
		
		
		<?php
			
			$return = ob_get_contents(); // don't remove this code
			ob_end_clean(); // don't remove this code
			return  $return;
		}
		
		add_filter('templ_sidebar_widget_box_filter','templ_sidebar_widget_box_fun');
		function templ_sidebar_widget_box_fun($content)
		{
			
			$content['home_slider']='';
			// End Remove Footer Widgets Area Page Layout option wise
			//$content['top_navigation']='';
			$content['header_logo_right_side']='';
			$content['main_navigation']='';
			$content['header_above']='';
			$content['slider_above']='';
			$content['slider_below']='';
			$content['sidebar_2col_merge']='';
			$content['sidebar2']='';
			
			//$content['header_logo_right_side']='';
			
			$array_key = array_keys($content);
			$position = array_keys($array_key,'single_post_below');
			$widget_pos = $position[0]+1;
			
			$sidebar_widget_arr = array();
			$sidebar_widget_arr['header_above'] =array('1',array('name' => 'Header: Right side', 'id' => 'header_above', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h1>','after_title' => '</h1>'));
			$sidebar_widget_arr['home_above'] =array('1',array('name' => 'Homepage: Intro', 'id' => 'home_above', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h1>','after_title' => '</h1>'));
			$sidebar_widget_arr['home_below'] =array('1',array('name' => 'Homepage: Below Today\'s deal', 'id' => 'home_below', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h1>','after_title' => '</h1>'));
			$sidebar_widget_arr['submit_deal_sidebar'] =array('1',array('name' => 'Sidebar for post deal page', 'id' => 'submit_deal_sidebar', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h1>','after_title' => '</h1>'));
			$sidebar_widget_arr['footer_above'] =array('1',array('name' => 'Pre-footer', 'id' => 'footer_above', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
			$sidebar_widget_arr['footer_below_links'] =array('1',array('name' => 'Footer: Left side', 'id' => 'footer_below_links', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
			
			$sidebar_widget_arr['contact_googlemap'] =array(1,array('name' => 'Contact Page : Google Map','id' => 'contact_googlemap','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
			
			
			array_splice($content, $widget_pos-1, 0, $sidebar_widget_arr);
			
			//print_r($content);
			
			return $content;
		}
		
		add_filter('templ_widgets_listing_filter','templ_widgets_listing_fun');
		function templ_widgets_listing_fun($content)
		{
			//print_r($content);
			$content['featured_video']='';
			$content['pika_choose_slider']='';
			$content['anything_slider']='';
			//$content['login']='';
			$content['anything_listing_slider']='';
			$content['nivo_slider']='';
			$content['my_bio']='';
			//$content['social_media']='';
			
			//print_r($content);
			//$content['flickr']='';
			return $content;
		} 
		//add_action( 'wp_load.php', 'templatic_edit_deal_columns' );
		
		/*-Extra fields in user area BOF-*/
		add_action( 'show_user_profile', 'extra_user_profile_fields' );
		add_action( 'edit_user_profile', 'extra_user_profile_fields' );
		
		function extra_user_profile_fields( $user ) { 
			$user_id = $user->ID;
			$user_facebook = get_user_meta($user_id,'user_facebook',true);
			$user_twitter = get_user_meta($user_id,'user_twitter',true);
		?>
		<h3><?php echo OTHER_INFO_TEXT; ?></h3>
		
		<table class="form-table">
			<tr>
				<th><label for="user_facebook"><?php _e("Facebook Link ",'templatic'); ?></label></th>
				<td>
					<input type="text" name="user_facebook" id="user_facebook" value="<?php echo esc_attr($user_facebook); ?>" class="textfield" /><br />
				</td>
			</tr>
			
			<tr>
				<th><label for="user_twitter"><?php _e("Twitter Link"); ?></label></th>
				<td>
					<input type="text" name="user_twitter" id="user_twitter" value="<?php echo esc_attr( $user_twitter); ?>" class="textfield" /><br />
				</td>
			</tr>
			
			<?php
				global $form_fields_usermeta;
				$validation_info = array();
				
				$custom_metaboxes = templ_get_usermeta('profile');
				
				foreach($form_fields_usermeta as $key=>$val)
				{
					if($val['on_profile']){
						$str = ''; $fval = '';
						$field_val = $key.'_val';
						if($$field_val){$fval = $$field_val;}else{$fval = $val['default'];}
						if($val['is_require'])
						{
							$validation_info[] = array(
							'name'	=> $key,
							'espan'	=> $key.'_error',
							'type'	=> $val['type'],
							'text'	=> $val['label'],
							);
						}
						if($key)
						{
							$fval = get_user_meta($user_id,$key,true);
						}
						
						if($val['type']=='text')
						{
							$str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'">';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';
							}
						}elseif($val['type']=='hidden')
						{
							$str = '<input name="'.$key.'" type="hidden" '.$val['extra'].' value="'.$fval.'">';	
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='textarea')
						{
							$str = '<textarea name="'.$key.'" '.$val['extra'].'>'.$fval.'</textarea>';	
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='texteditor')
						{
							
							$str = $val['tag_before'].'<textarea name="'.$key.'" '.$val['extra'].'>'.$fval.'</textarea>'.$val['tag_after'];
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='file')
						{
							$str = '<input name="'.$key.'" type="file" '.$val['extra'].' value="'.$fval.'">';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='include')
						{
							$str = @include_once($val['default']);
						}else
						if($val['type']=='head')
						{
							$str = '';
						}else
						if($val['type']=='date')
						{ 
							$str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.get_user_meta($user_id,$key,true).'">';	
							$str .= '<img src="'.get_template_directory_uri().'/images/cal.gif" alt="Calendar"  onclick="displayCalendar(document.userform.'.$key.',\'yyyy-mm-dd\',this)" style="cursor: pointer;" align="absmiddle" border="0" class="calendar_img" />';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='catselect')
						{
							$term = get_term( (int)$fval, CUSTOM_CATEGORY_TYPE1);
							$str = '<select name="'.$key.'" '.$val['extra'].'>';
							$args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
							$all_categories = get_categories($args);
							foreach($all_categories as $key => $cat) 
							{
								
								$seled='';
								if($term->name==$cat->name){ $seled='selected="selected"';}
								$str .= '<option value="'.$cat->name.'" '.$seled.'>'.$cat->name.'</option>';	
							}
							$str .= '</select>';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='catdropdown')
						{
							$cat_args = array('name' => 'post_category', 'id' => 'post_category_0', 'selected' => $fval, 'class' => 'textfield', 'orderby' => 'name', 'echo' => '0', 'hierarchical' => 1, 'taxonomy'=>CUSTOM_CATEGORY_TYPE1);
							$cat_args['show_option_none'] = __('Select Category','templatic');
							$str .=wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='select')
						{
							$str = '<select name="'.$key.'" '.$val['extra'].'>';
							$option_values_arr = explode(',', $val['options']);
							for($i=0;$i<count($option_values_arr);$i++)
							{
								$seled='';
								
								if($fval==$option_values_arr[$i]){ $seled='selected="selected"';}
								$str .= '<option value="'.$option_values_arr[$i].'" '.$seled.'>'.$option_values_arr[$i].'</option>';	
							}
							$str .= '</select>';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='catcheckbox')
						{
							$fval_arr = explode(',',$fval);
							$str .= $val['tag_before'].get_categories_checkboxes_form(CUSTOM_CATEGORY_TYPE1,$fval_arr).$oval.$val['tag_after'];
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='catradio')
						{
							$args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
							$all_categories = get_categories($args);
							foreach($all_categories as $key1 => $cat) 
							{
								
								
								$seled='';
								if($fval==$cat->term_id){ $seled='checked="checked"';}
								$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$cat->name.'" '.$seled.'> '.$cat->name.$val['tag_after'];	
								
							}
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='checkbox')
						{
							if($fval){ $seled='checked="checked"';}
							$str = '<input name="'.$key.'" type="checkbox" '.$val['extra'].' value="1" '.$seled.'>';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='upload')
						{
							$str = '<input name="'.$key.'" type="file" '.$val['extra'].' '.$uclass.' value="'.$fval.'" > ';
							if($fval!=''){
								$str .='<img src="'.templ_thumbimage_filter($fval,'&amp;w=121&amp;h=115&amp;zc=1&amp;q=80').'" width="121" heigh="115" alt="" />
								<br />
								<input type="hidden" name="prev_upload" value="'.$fval.'" />
								';	
							}
							if($val['is_require'])
							{
								$str .='<span id="'.$key.'_error"></span>';	
							}
						}
						else
						if($val['type']=='radio')
						{
							$options = $val['options'];
							if($options)
							{
								$option_values_arr = explode(',',$options);
								for($i=0;$i<count($option_values_arr);$i++)
								{
									$seled='';
									if($fval==$option_values_arr[$i]){$seled='checked="checked"';}
									$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
								}
								if($val['is_require'])
								{
									$str .= '<span id="'.$key.'_error"></span>';	
								}
							}
						}else
						if($val['type']=='multicheckbox')
						{
							$options = $val['options'];
							if($options)
							{  $chkcounter = 0;
								
								$option_values_arr = explode(',',$options);
								for($i=0;$i<count($option_values_arr);$i++)
								{
									$chkcounter++;
									$seled='';
									if(in_array($option_values_arr[$i],$fval)){ $seled='checked="checked"';}
									$str .= $val['tag_before'].'<input name="'.$key.'[]"  id="'.$key.'_'.$chkcounter.'" type="checkbox" '.$val['extra'].' value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
								}
								if($val['is_require'])
								{
									$str .= '<span id="'.$key.'_error"></span>';	
								}
							}
						}
						else
						if($val['type']=='packageradio')
						{
							$options = $val['options'];
							foreach($options as $okey=>$oval)
							{
								$seled='';
								if($fval==$okey){$seled='checked="checked"';}
								$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$okey.'" '.$seled.'> '.$oval.$val['tag_after'];	
							}
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='geo_map')
						{
							do_action('templ_submit_form_googlemap');	
						}else
						if($val['type']=='image_uploader')
						{
							do_action('templ_submit_form_image_uploader');	
						}
						if($val['is_require'])
						{
							$label = '<label>'.$val['label'].' <span>*</span> </label>';
						}else
						{
							$label = '<label>'.$val['label'].'</label>';
						}
						$outer_st = "<tr><th>";
						$tag_st = "</th><td>";
						$tag_end = "</td>";
						$outer_end = "</tr>";
						echo $outer_st.$label.$tag_st.$str.$tag_end.$outer_end;
					}
				}
			?>
		</table>
		<?php }
		/*-Extra fields in user area EOF-*/
		
		/*-Extra fields in user info save BOF-*/
		add_action('personal_options_update', 'save_extra_user_profile_fields' );
		add_action('edit_user_profile_update', 'save_extra_user_profile_fields' );
		
		function save_extra_user_profile_fields( $user_id ) {
			global $wpdb;
			if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
			
			$user_facebook = $_POST['user_facebook'];
			$user_twitter = $_POST['user_twitter'];
			update_usermeta($user_id, 'user_facebook', $user_facebook);
			update_usermeta($user_id, 'user_twitter',$user_twitter);	
			
			global $upload_folder_path;
			
			$custom_metaboxes = templ_get_usermeta('profile');
			
			foreach($custom_metaboxes as $fkey=>$fval)
			{
				$fldkey = "$fkey";
				$$fldkey = $_POST["$fkey"];
				if($fval['type']=='upload')
				{			
					if($_FILES[$fkey]['name'] && $_FILES[$fkey]['size']>0) {
						$dirinfo = wp_upload_dir();
						$path = $dirinfo['path'];
						$url = $dirinfo['url'];
						$destination_path = $path."/";
						$destination_url = $url."/";
						
						$src = $_FILES[$fkey]['tmp_name'];
						$file_ame = date('Ymdhis')."_".$_FILES[$fkey]['name'];
						$target_file = $destination_path.$file_ame;
						if(move_uploaded_file($_FILES[$fkey]["tmp_name"],$target_file))
						{
							$image_path = $destination_url.$file_ame;
						}else
						{
							$image_path = '';	
						}				
						$_POST[$fkey] = $image_path;
						$fldkey = $image_path;
						
					}
					else{
						$_POST[$fkey]=$_POST['prev_upload'];
					}
				}			
				update_usermeta($user_id, $fkey, $$fldkey);
				// User Custom Metadata Here
			} 	
		}
		/*-Extra fields in user info save EOF-*/	