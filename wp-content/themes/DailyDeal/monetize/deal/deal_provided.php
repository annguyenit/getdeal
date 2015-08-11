<?php 
if($curauth->ID && $_REQUEST['transid'] == "" &&  $_REQUEST['ahuthordetailid'] == "" ) {
		$UID=$curauth->ID;
		$email_id = $curauth->user_email;
		$username  = $curauth->user_login;
		$user_db_table_name = $wpdb->prefix."users";
		$targetpage = get_author_posts_url($curauth->ID);
		$total_deals = mysql_query("select p.* from $post_db_table_name p where post_author = '".$curauth->ID."' and p.post_type = '".CUSTOM_POST_TYPE1."' and p.post_status = 'publish' ");
		$total_pages = mysql_num_rows($total_deals);
		$recordsperpage = 5;
		$pagination = $_REQUEST['pagination'];
		if($pagination == '') {
			$pagination = 1;
		}
		$strtlimit = ($pagination-1)*$recordsperpage;
		$endlimit = $strtlimit+$recordsperpage;
		$dealcnt_sql = $wpdb->get_results("select p.* from $post_db_table_name p where post_author = '".$curauth->ID."' and p.post_type = '".CUSTOM_POST_TYPE1."' and p.post_status = 'publish' limit $strtlimit,$recordsperpage ");

?>
	<h2><a href="#?totaldeal=1"><?php echo DEAL_PROVIDED;?></a></h2>						  
			 <?php
			if(mysql_affected_rows() >0){
				echo '<ul class="deal_listing">';
				foreach($dealcnt_sql as $total_deals_obj){ 
				
					?>
				<div class="posts_deal">
			
					<li><div class="product_image">
					<a href="#" onclick="viewtransaction(<?php echo $UID ;?>,<?php echo $total_deals_obj->ID;?>)">
					<?php 
							if(get_post_meta($total_deals_obj->ID,'file_name',true) != "") {?>
							<img src="<?php echo templ_thumbimage_filter($destination_path.get_post_meta($total_deals_obj->ID,'file_name',true),165,180);?>" width="165" height="180" alt="" />
						<?php }else{ if(is_super_admin($UID)){
							echo display_deal_image($total_deals_obj->ID,'thumbnail');
							}else { ?>
							<img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" width="165" height="180" alt="" />
						<?php } ?>
					<?php }?>							
						</a>
						<div class="mp_deal_price">
							<div class="mp_current_price"><span class="mp_redline"></span><?php echo MP_CURENT_PRICE;?> <small><?php echo get_currency_sym();?></small><?php echo get_post_meta($post->ID,'current_price',true);?>,-</div>
							<div class="mp_our_price"><?php echo MP_OUR_PRICE;?> <strong><small><?php echo get_currency_sym();?></small><?php echo get_post_meta($post->ID,'our_price',true);?></strong></div>
						</div>
						</div>
						<div class="content">
							<h3><span class="dealtitle"><a href="#" onclick="viewtransaction(<?php echo $UID ;?>,<?php echo $total_deals_obj->ID;?>)"><?php echo $total_deals_obj->post_title;?></a></span>
							<span class="price"><?php echo STATUS; ?> : <?php  fetch_status(get_post_meta($total_deals_obj->ID,'status',true),get_post_meta($total_deals_obj->ID,'is_expired',true)); ?></span></h3>
							<strong><?php if(get_post_meta($total_deals_obj->ID,'coupon_end_date_time',true) != '') {
								echo DEAL_DURATION." : "; ?></strong> <?php echo "<strong>From </strong>".date("F d,Y H:i:s",get_post_meta($total_deals_obj->ID,'coupon_start_date_time',true))."<strong> To</strong> ".date("F d,Y H:i:s",get_post_meta($total_deals_obj->ID,'coupon_end_date_time',true));
							} else {
								echo "DEAL start from : ".date("F d,Y H:i:s",get_post_meta($total_deals_obj->ID,'coupon_start_date_time',true));
							}?>
							<ul class="deal_li">
								<li><span class="field"><?php echo DEAL_COUPON_TEXT; ?></span><span>: <?php fetch_deal(get_post_meta($total_deals_obj->ID,'coupon_type',true));?></span></li>											
								<li><span class="field"><?php echo DEAL_POST_TEXT; ?></span><span>: <?php echo $total_deals_obj->post_date;?></span></li>						
								<li><span class="field"><?php echo DEAL_NUM_OF_TEXT; ?></span><span>: <?php echo get_post_meta($total_deals_obj->ID,'no_of_coupon',true);?></span></li>
								<li><span class="field"><?php echo DEAL_CPRICE_TEXT; ?></span><span>: </strong> <?php echo get_currency_sym().get_post_meta($total_deals_obj->ID,'current_price',true);?></span></li>
								<li><span class="field"><?php echo DEAL_PRICE_TEXT; ?></span><span>: </strong><?php echo get_currency_sym().get_post_meta($total_deals_obj->ID,'our_price',true);?></span></li>		
							</ul>
							<p class="deallistinglinks">
								<span class="link"><?php echo DEAL_WEBLINK_TEXT; ?> : <a href="<?php echo get_post_meta($total_deals_obj->ID,'coupon_website',true);?>" title="<?php echo $total_deals_obj->coupon_website;?>" target="_blank"><?php echo get_post_meta($total_deals_obj->ID,'coupon_website',true);?></a></span>
								<?php 
								
								global $wpdb;
								$table_setup = $wpdb->prefix."deal_setup";
								$sqlsetup = $wpdb->get_row("select * from $table_setup where sid='1'");
								if($sqlsetup->access == '1')
								{
										if($total_deals_obj->post_status == 'draft' || get_post_meta($total_deals_obj->ID,'status',true) == '0' || get_post_meta($total_deals_obj->ID,'is_expired',true) == '1')  { ?>
										<span><a href="?ptype=dealform&editdeal=<?php _e($total_deals_obj->ID,'templatic');?>" ><?php echo Edit; ?> &rsaquo;&rsaquo;</a></span>
										<span><a href="javascript:void(0);delete_deal('<?php _e($total_deals_obj->ID,'templatic');?>');" ><?php echo Delete; ?> &rsaquo;&rsaquo;</a>
										</span>
										<?php } 
								}
								if($current_user->ID != '0' && $current_user->ID == $UID) { ?>
								<span><a href="#" onclick="viewtransaction(<?php echo $UID ;?>,<?php echo $total_deals_obj->ID;?>)"><?php echo VIEW_TRANSACTIONS; ?>&rsaquo;&rsaquo;</a></span> 
								<?php } ?>
							</p>
						</div>								 								
					</li>	
					</div>
		 <?php }
			echo '</ul>';
				if($total_pages>$recordsperpage)
				{
				echo '<div style="text-align:right" >'.get_pagination($targetpage,$total_pages,$recordsperpage,$pagination).'</div>';
				}
					
			} else {
					echo NO_DEAL_PROVIDED;
			}
}			?>							
	