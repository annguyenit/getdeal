<?php 
echo '<div class="tabbertab" style="margin-top:20px;">';
		if($dealcnt_sql) {
			foreach( $dealcnt_sql as $post ){ //echo wp_get_recent_posts($post);
				deal_expire_process($post->ID); 
				$coupon_website= get_post_meta($post->ID,'coupon_website',true);
				$owner_name= get_post_meta($post->ID,'owner_name',true);
				$our_price= get_post_meta($post->ID,'our_price',true);
				$current_price= get_post_meta($post->ID,'current_price',true);
				$sellsql = "select count(*) from $transection_db_table_name where post_id=".$post->ID." and status=1";
				$totdiff = $current_price - $our_price;
				$percent = $totdiff * 100;
				$percentsave = $percent/$current_price;
                $sellsqlinfo = $wpdb->get_var($sellsql);
				$date = get_post_meta($post->ID,'coupon_end_date_time',true);
				$targatedate= date("d-m-Y H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));
				if(get_post_meta($post->ID,'coupon_end_date_time',true) != ''){
					$tardate= date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));
					$tardate1= date("F d, Y",get_post_meta($post->ID,'coupon_end_date_time',true));
				} if(get_post_meta($post->ID,'coupon_start_date_time',true) != ''){
					$stdate= date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_start_date_time',true));
				}
				$no_of_coupon = get_post_meta($post->ID,'no_of_coupon',true);?> 
				<div class="posts_deals"> 
					<div class="product_image">
						<a href="#" onclick="viewtransaction(<?php _e($post->post_author,'templatic'); ?>,<?php _e($post->ID,'templatic'); ?>)">
			        <?php if(get_post_meta($post->ID,'file_name',true) != "") {?>
								<img src="<?php echo templ_thumbimage_filter(get_post_meta($post->ID,'file_name',true),165,180);?>" alt="" />
					<?php } else { ?>
								<img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" width="165" height="180" alt="" />
					<?php } ?></a>
					</div>
                    <div class="content_right content_right_inner">
			
                    <span class="title_yellow"><?php echo TODAY_DEAL;?></span><span class="title_grey"><?php echo PROVIDE_BY;?> </span>
			<?php	$user_data = $wpdb->get_row("select * from $user_db_table_name where ID = '".$post->post_author."'"); 
				if(get_post_meta($post->ID,'coupon_type',true) == 1) { ?>
									<a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" title="<?php echo $user_data->display_name; ?>" class="top_lnk" target="_blank"><?php echo get_post_meta($post->ID,'owner_name',true);?></a>
			<?php 				} else { ?>
					<a href="<?php echo get_author_posts_url($post->post_author);?>" onclick="viewauthor(<?php echo $post->post_author; ?>,1)" class="top_lnk" title="<?php echo $user_data->display_name; ?>"><?php echo get_post_meta($post->ID,'owner_name',true); ?></a>
					<?php } ?>
					<h3><?php echo $post->post_title; ?></h3>
	        <?php 	if(get_post_meta($post->ID,'coupon_end_date_time',true) != '') {
						if(get_post_meta($post->ID,'is_expired',true) == '1' || date("Y-m-d H:i:s")>= date("Y-m-d H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true)) ) {
							if(get_post_meta($post->ID,'is_expired',true)== '0'){
							update_post_meta($post->ID,'is_expired','1');
							}?>
							<div class="i_expire"><?php echo THIS_DEAL;?><span><?php echo EXPIRED;?></span> <?php echo ON;?> <span><?php echo $tardate1;?></span></div>
			<?php  					}
					if(get_post_meta($post->ID,'no_of_coupon',true)== $sellsqlinfo ) { ?>
					<div class="i_start"><span><?php echo "Is Sold Out"; ?></span></div>
					<?php } else  { 
							if(get_post_meta($post->ID,'coupon_end_date_time',true) !='') { ?> 
								
								<div class="deal_time_box">
									<div class="time_line"></div>
									<div id="countdowncontainer_author_<?php _e($post->ID,'templatic'); ?>"></div>
								<?php
							$targatedate = explode(' ',$targatedate);
							$tar_date =  explode('-',$targatedate[0]);
							$tar_time =  explode(':',$targatedate[1]);
							$timezone = get_option('ptthemes_time_offset');
							$exp_year =  explode(',',$tardate1);
							?>	
								<script>
							displayTZCountDown(setTZCountDown('<?php echo $tar_date[1]; ?>','<?php echo $tar_date[0]; ?>','<?php echo $tar_time[0]; ?>','<?php echo $timezone; ?>','<?php echo $exp_year[1]; ?>'),'countdowncontainer_author_<?php _e($post->ID,'templatic'); ?>','fr_<?php echo $post->ID; ?>','<?php echo $tardate1; ?>');
							</script>
									<div class="fr">
                                    <div class="price_main">
                                    <span class="strike_rate"><?php echo get_currency_sym();?><?php echo $current_price;?></span> 
                                    <span class="rate"><?php echo get_currency_sym();?><?php echo $our_price;?></span> 
                                    </div>
									<?php if(get_post_meta($post->ID,'coupon_type',true) == 1) { ?>
								<a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" title="Buy now!" class="btn_buy" target="_blank"><?php _e(BUY_NOW,'templatic');?></a>
							<?php } else { ?>
								<a href="<?php echo get_option('siteurl');?>/?ptype=buydeal&amp;did=<?php _e($post->ID,'templatic'); ?>" title="Buy now!" class="btn_buy"><?php _e(BUY_NOW,'templatic');?></a>
							<?php }?>
									</div>
								</div>
			<?php 			} 
						}
					} ?>
                    <ul class="rate_summery">
                        <li class="rate_current_price"><span><?php echo CURRENT_PRICE;?></span> 
                        <strong><small><?php echo get_currency_sym();?></small><?php echo $current_price;?></strong></li>
                        <li class="rate_our_price"><span><?php echo OUR_PRICE;?></span> <strong><small><?php echo get_currency_sym();?></small><?php echo $our_price;?></strong></li>
                        <li class="rate_percentage"><span><?php echo YOU_SAVE;?></span> <strong><?php echo @number_format($percentsave,2);?>%</strong></li>
						<?php if(get_post_meta($post->ID,'shipping_cost',true) > 0 ) {?>
						<li class="rate_our_price"><span>
						<?php echo SHIPPING_COST;?>
						</span> <strong><small><?php echo get_currency_sym();?></small><?php echo get_post_meta($post->ID,'shipping_cost',true);?></strong></li>
						<?php } ?>
                        <li class="bdr_none rate_item_sold"><span><?php echo ITEMS_SOLD;?></span> <strong><?php echo $sellsqlinfo;?></strong>
				<?php 	if($sellsqlinfo == 0 ) { 
							$enddate = explode(" ",$tardate); 
							$curdate = explode(" ",date("F d, Y H:i:s"));
							$enddate= str_replace(",","",$enddate[1]);
							$curdate =  str_replace(",","",$curdate[1]);
							$startdate = explode(" ",$stdate);
							$strdate = str_replace(","," ",$startdate[1]);
							$curtime = $enddate - $curdate;
							$totaltime =  ($enddate - $strdate);
							$nowremail = $curdate - $strdate; ?>
							<input type="hidden" value="<?php echo $nowremail ; ?>" name="sellsqlinfo" id="sellsqlinfo"/>
							<input type="hidden" value="<?php  echo ($enddate - $strdate) ; ?>" name="noofcoupon" id="noofcoupon"/>
				<?php 	} else{  ?>
							<input type="hidden" value="<?php echo $sellsqlinfo; ?>" name="sellsqlinfo" id="sellsqlinfo"/>
							<input type="hidden" value="<?php echo $no_of_coupon; ?>" name="noofcoupon" id="noofcoupon"/>
				<?php 	} ?>
						</li>
                    </ul>
                    
                    
                     <?php if(templ_is_show_post_category()){?>
					  <div class="post_cats clearfix"> 
                       <?php the_taxonomies(array('before'=>'<span class="categories">','sep'=>'</span><span class="tags">','after'=>'</span>')); ?> 
                       </div>
                     <?php } ?>
                    
                    
					<div class="text_content" id="content_<?php _e($post->ID,'templatic');?>">
				 <?php echo "".$post->post_excerpt."";  ?><a href="<?php the_permalink(); ?>" class="readmore_link"><?php _e(get_option('ptthemes_content_excerpt_readmore'));
						?> </a>
    
					</div>
					
                </div>  
            </div>
	<?php  	} 
			if($total_pages>$recordsperpage) {
				echo '<div style="text-align:right" >'.get_pagination($targetpage,$total_pages,$recordsperpage,$pagination).'</div>';
			}
		} else {
			echo NO_DEAL_PROVIDED;
		} ?>
	</div>