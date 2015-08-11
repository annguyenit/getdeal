<?php 
 if($_SERVER['HTTP_REFERER'] != ''){ 
	global $deal_db_table_name;
	
	$deals_res = $wpdb->get_row("select p.* from $post_db_table_name p where p.ID = '".$_REQUEST['transid']."' and p.post_type = 'seller' ");
	$transactiondeal = $wpdb->get_row("select * from $deal_db_table_name where deal_id = '".$_REQUEST['transid']."'"); 
	if($current_user->data->ID == $deals_res->post_author){				
		echo $dashboard_display;
	}else{
		echo $dashboard_display1;
	} ?>
	
		<ul class="deal_listing">	
			<li>
				<div class="posts_deal">							
					<div class="product_image"><a href="#"><?php 
					if(get_post_meta($deals_res->ID,'file_name',true) != "") { ?>
						<img src="<?php echo templ_thumbimage_filter(get_post_meta($deals_res->ID,'file_name',true),165,180);?>" alt=""/>
			  <?php } else { ?>
						<img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" width="165" height="180" alt="" />
			  <?php } ?></a>
					</div>
					<div class="content">
						<h3><span class="dealtitle"><?php echo $deals_res->post_title;?></span><span class="price"><?php echo STATUS." : "; fetch_status(get_post_meta($deals_res->ID,'status',true),get_post_meta($deals_res->ID,'is_expired',true));  ?></span></h3>
				<?php 	if(get_post_meta($deals_res->ID,'coupon_end_date_time',true) != '') {
							echo "<strong>".DEAL_DURATION." : </strong> <br /><strong>".FROM." </strong>".date("F d,Y H:i:s",get_post_meta($deals_res->ID,'coupon_start_date_time',true))." &nbsp; | &nbsp; <strong> To</strong> ".date("F d,Y H:i:s",get_post_meta($deals_res->ID,'coupon_end_date_time',true));
						} else {
							echo DEAL_FROM.date("F d,Y H:i:s",get_post_meta($deals_res->ID,'coupon_start_date_time',true));
						}?><br /><br />
						<strong><?php echo DEAL_CONTENT_TEXT; ?> : </strong> <br />
						
						 <?php 
						$content_display = $deals_res->post_content;
						$content_display = apply_filters('the_content', $content_display);
						$content_display = str_replace(']]>', ']]&gt;', $content_display);
						echo $content_display;
						
						?>
						<ul class="deal_li">
							<li><span class="field"><?php echo DEAL_COUPON_TEXT; ?> </span><span>:  <?php fetch_deal(get_post_meta($deals_res->ID,'coupon_type',true));?></span></li>
				<?php 		if($deals_res->post_author == $current_user->data->ID) { ?>
								<li><span class="field"><?php echo DEAL_CODE_TEXT; ?> </span><span>:  <?php _e(get_post_meta($deals_res->ID,'coupon_code',true),'templatic');?></span></li>
				<?php 		} ?>
							<li><span class="field"><?php echo DEAL_POST_TEXT; ?> </span><span>: <?php _e($deals_res->post_date,'templatic'); ?></span></li>							
							<li><span class="field"><?php echo DEAL_OWNER_TEXT; ?> </span><span>: <?php _e(get_post_meta($deals_res->ID,'owner_name',true),'templatic'); ?></span></li>
							<li><span class="field"><?php echo DEAL_NUM_OF_TEXT; ?> </span><span>: <?php _e(get_post_meta($deals_res->ID,'no_of_coupon',true),'templatic') ?></span></li>
							<li><span class="field"><?php echo DEAL_PRICE_TEXT; ?> </span><span>: <?php _e(get_currency_sym().get_post_meta($deals_res->ID,'our_price',true),'templatic'); ?></span></li>
							<li><span class="field"><?php echo DEAL_CPRICE_TEXT; ?> </span><span>: <?php _e(get_currency_sym().get_post_meta($deals_res->ID,'current_price',true),'templatic');?></span></li>
						</ul>
						<p class="deallistinglinks">
							<span class="link"><?php echo DEAL_WEBLINK_TEXT; ?> : <a href="<?php _e(get_post_meta($deals_res->ID,'coupon_website',true),'templatic') ;?>" title="<?php _e($transactiondeal->coupon_website,'templatic');?>" target="_blank"><?php _e(get_post_meta($deals_res->ID,'coupon_website',true),'tempalatic');?></a></span></p>
						</div>	
					</div>
				</li>							
			</ul>					
	
<?php 	

	$transaction = $wpdb->get_results("select * from $transaction_table where post_id = '".$_REQUEST['transid']."'");
	$postdate = get_posts($_REQUEST['transid']);
	global $current_user;
	?>
	<h4 class="trans_title"><?php echo TRANS_DETAILS_TEXT; ?></h4>				
	<table border="" class="transaction_table">
<?php	if($transaction) {
		echo '<tr>
			<td class="title">'.USER_NAME.'</td>
			<td class="title">'.USER_EMAIL.'</td>
			<td class="title">'.USER_TITLE.'</td>
			<td class="title">'.USER_AMOUNT.'</td>
			<td class="title">'.PAYMENT_DATE.'</td>
			<td class="title"></td>
		</tr>';
		foreach($transaction as $transaction_obj) { 
		$uinfo = get_userdata($transaction_obj->user_id);
		if($transaction_obj->user_id == $current_user->ID) {  ?>
			<tr class="list_row">
				<td class="row1"><?php echo $uinfo->display_name; ?></td>
				<td class="row1"><?php echo $transaction_obj->pay_email; ?></td>
				<td class="row1"><?php echo $transaction_obj->post_title; ?></td>					
				<td class="row1"><?php echo get_currency_sym().number_format($transaction_obj->payable_amt,2); ?></td>
				<td class="row1"><?php echo $transaction_obj->payment_date; ?></td>
				<td class="row1"><a href="#" onclick="showtransdetail(<?php echo $transaction_obj->trans_id;?>)"><?php echo USER_DETAILS;?></a></td>
			</tr>				
			<tr class="subtable_tr" id="transaction_<?php echo $transaction_obj->trans_id;?>" style="display:none;">
				<td colspan="6">	
					<table border="" class="sub_table">
						<tr>
							<td><span><?php echo USER_NAME; ?></span>: <?php echo $transaction_obj->user_name; ?></td>
							<td><span><?php echo USER_EMAIL; ?></span>: <?php echo $transaction_obj->pay_email; ?></td>
						</tr>
						<tr>
							<td><span><?php echo USER_TITLE; ?></span>: <?php echo $transaction_obj->post_title; ?></td>
							<td><span><?php echo DEAL_TYPES_TEXT; ?></span>: <?php fetch_deal($transaction_obj->deal_type); ?></td>
						</tr>
						<tr>
							<td><span><?php echo DEAL_CODE_TEXT; ?></span>: <?php echo $transaction_obj->deal_coupon; ?></td>
							<td><span><?php echo PAID_AMOUNT; ?></span>: <?php echo get_currency_sym().number_format($transaction_obj->payable_amt,2); ?></td>
						</tr>
						<tr>
							<td><span><?php echo PAYMENT_DATE; ?></span>: <?php echo $transaction_obj->payment_date; ?></td>
							<td><span><?php echo TRANSACTION_ID; ?></span>: <?php echo $transaction_obj->paypal_transaction_id; ?></td>
						</tr>
						<tr>
							<td><span><?php echo BUY_DEAL_BILLING_NAME_TEXT; ?></span>: <?php echo $transaction_obj->billing_name; ?></td>
							<td><div style="float:left;width:118px;"><span><?php echo BUY_DEAL_BILLING_TEXT; ?></span></div><div style="float:left;"> : <?php echo $transaction_obj->billing_add; ?></div></td>
						</tr>
						<tr>
							<td><span><?php echo BUY_DEAL_SHIPPING_NAME_TEXT; ?></span>: <?php echo $transaction_obj->shipping_name; ?></td>
							<td><div style="float:left;width:118px;"><span><?php echo BUY_DEAL_SHIPPING_TEXT; ?></span></div><div style="float:left;"> : <?php echo $transaction_obj->shipping_add; ?></div></td>
						</tr>
					</table>
				</td>
			</tr>
	<?php } } 
	} else { ?>
			<tr><td colspan="6"><?php echo NO_TRANS_TEXT; ?></td></td>
<?php }
	
 ?>
	</table>					
<?php 
} else {
		echo '<script>location.href="'.site_url().'"</script>';
		exit;
	}