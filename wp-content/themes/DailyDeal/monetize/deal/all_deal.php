<?php
	$deal_targetpage = "?ptype=taxonomy_alle_deals_tab";
	$postmeta_db_table_name = $wpdb->prefix . "postmeta";
	date_default_timezone_set(get_option('timezone_string'));
	$post_db_table_name = $wpdb->prefix . "posts";
	if ($current_term->term_id != '')
	{
		$sqlsql = " and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($current_term->term_id)  )";
	}
	$dealcnt = "select p.* from $post_db_table_name p where p.post_type = '".CUSTOM_POST_TYPE1."' and p.post_status = 'publish' $sqlsql ORDER BY ID DESC ";
	$all_total_pages = count($wpdb->get_results($dealcnt));
	$recordsperpage = get_option('posts_per_page');
	$all_pagination = $_REQUEST['pagination'];
	if ($all_pagination == '')
	{
		$all_pagination = 1;
	}
	$strtlimit = ($all_pagination - 1) * $recordsperpage;
	$endlimit = $strtlimit + $recordsperpage;
	$dealcnt_sql = $wpdb->get_results($dealcnt . "  limit $strtlimit,$recordsperpage ");
	if (count($dealcnt_sql) > 0)
	{
		$pcount = 0;
		foreach ($dealcnt_sql as $post)
		{
			$pcount++;
			if (get_post_meta($post->ID, 'enddate', true) != '0')
            deal_expire_process($post->ID);
			$coupon_website = get_post_meta($post->ID, 'coupon_website', true);
			$owner_name = get_post_meta($post->ID, 'owner_name', true);
			$our_price = get_post_meta($post->ID, 'our_price', true);
			$current_price = get_post_meta($post->ID, 'current_price', true);
			$sellsql = "select count(*) from $transection_db_table_name where post_id=" . $post->ID . " and status=1";
			$totdiff = $current_price - $our_price;
			$percent = $totdiff * 100;
			$percentsave = $current_price > 0 ? $percent / $current_price : 0;
			$sellsqlinfo = $wpdb->get_var($sellsql);
			if (get_post_meta($post->ID, 'coupon_end_date_time', true) != "")
			{
				$date = get_post_meta($post->ID, 'coupon_end_date_time', true);
				$tardate = date("F d, Y H:i:s", get_post_meta($post->ID, 'coupon_end_date_time', true));
				$targatedate = date("d-m-Y H:i:s", get_post_meta($post->ID, 'coupon_end_date_time', true));
				$tardate1 = date("F d, Y", get_post_meta($post->ID, 'coupon_end_date_time', true));
				$enddate1 = date("Y-m-d H:i:s", get_post_meta($post->ID, 'coupon_end_date_time', true));
			}
			$stdate = date("F d, Y H:i:s", (int)get_post_meta($post->ID, 'coupon_start_date_time', true));
			$no_of_coupon = get_post_meta($post->ID, 'no_of_coupon', true);
		?> 
        <div <?php post_class('post posts_deals'); ?> id="deal_<?php the_ID(); ?>" > 
            <div class="product_image">
                <a href="<?php the_permalink(); ?>">
				<?php if (get_post_meta($post->ID, 'file_name', true) != "")
					{ ?>
					<img src="<?php echo templ_thumbimage_filter(get_post_meta($post->ID, 'file_name', true), 165, 180); ?>" width="165" height="180" alt="" />
                    <?php } else
                    { ?>
					<img src="<?php echo get_template_directory_uri() . "/images/no-image.png"; ?>" width="165" height="180" alt="" />
				<?php } ?>							
                </a>
				<div class="mp_deal_price">
					<div class="mp_current_price"><span class="mp_redline"></span><?php echo MP_CURENT_PRICE;?> <small><?php echo get_currency_sym();?></small><?php echo get_post_meta($post->ID,'current_price',true);?>,-</div>
					<div class="mp_our_price"><?php echo MP_OUR_PRICE;?> <strong><small><?php echo get_currency_sym();?></small><?php echo get_post_meta($post->ID,'our_price',true);?></strong></div>
				</div>
			</div>
			
            <div class="product_image grid_img">
                <a href="<?php the_permalink(); ?>">
                <?php if (get_post_meta($post->ID, 'file_name', true) != "")
					{ ?>
					<img src="<?php echo templ_thumbimage_filter(get_post_meta($post->ID, 'file_name', true), 280, 180); ?>" width="280" height="180" alt="" />
					<?php } else
					{ ?>
					<div class="noimg"><?php echo IMAGE_NOT_AVAILABLE; ?></div>
				<?php } ?></a>
			</div>
            <div class="content_right content_right_inner">
                <?php if (get_option('ptthemes_listing_author') != 'No')
					{ ?>        
                    <span class="title_grey"><?php echo PROVIDE_BY; ?> </span>					
                    <?php
						$user_db_table_name = get_user_table();
						$user_data = $wpdb->get_row("select * from $user_db_table_name where ID = '" . $post->post_author . "'");
						
						if (get_post_meta($post->ID, 'coupon_type', true) == 1)
						{
						?>
                        <a href="<?php echo get_post_meta($post->ID, 'coupon_link', true); ?>" title="<?php echo $user_data->display_name; ?>" class="top_lnk" target="_blank"><?php echo get_post_meta($post->ID, 'owner_name', true); ?></a>
						<?php } else
						{ ?>
						
                        <a href="<?php echo get_author_posts_url($post->post_author); ?>" class="top_lnk" title="<?php echo $user_data->display_name; ?>"><?php echo $user_data->display_name; ?></a>
						<?php }
					} ?>
					<h3><a href="<?php the_permalink(); ?>"><?php echo $post->post_title; ?></a></h3>
					<?php
						$post_categories = wp_get_post_terms($post->ID, CUSTOM_CATEGORY_TYPE1);
						if ($post_categories[0] != "")
						{
						?>
						<div class="post_cats clearfix" style="margin-bottom: 10px; margin-top: -20px;"> 
							<?php the_taxonomies(array('before' => '<span class="categories">', 'sep' => '</span><span class="tags">', 'after' => '</span>')); ?> 
						</div>
					<?php } ?>
					<div class="grid_price"><span class="strike_rate"><?php echo OUR_PRICES; ?><s><?php echo get_currency_sym(); ?><?php echo $current_price; ?></s></span> <span class="rate"><?php echo OFFER_PRICE; ?><?php echo get_currency_sym(); ?><?php echo $our_price; ?></span> </div>
					<?php
						if(get_post_meta($post->ID,'coupon_end_date_time',true) !="")
						if(strtotime(date("F d, Y H:i:s"))>= strtotime(date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true))) || get_post_meta($post->ID,'no_of_coupon',true)==$sellsqlinfo || get_post_meta($post->ID,'is_expired',true)=='1')
						{
							if(get_post_meta($post->ID,'is_expired',true)=='1' ) 
							{
									if(get_post_meta($post->ID,'is_expired',true)== '0') {
										update_post_meta($post->ID,'is_expired','1');
									} ?>
									<div class="i_expire" style="margin-top: 10px;"><span><?php echo THIS_DEAL_IS_EXPIRED;?></span></div>
							<?php
							}
							if(get_post_meta($post->ID,'no_of_coupon',true)== $sellsqlinfo && get_post_meta($post->ID,'is_expired',true)!='1') { ?>
							<div class="i_start"><span><?php echo "Is Sold Out"; ?></span></div>
							<?php }
						}
						else{
							if (get_post_meta($post->ID, 'coupon_end_date_time', true))
							{
							?> 
							
							<div class="deal_time_box">
								<div class="time_line"></div>
								<div id="countdowncontainer_<?php _e($post->ID, 'templatic'); ?>"></div>
								
								<div class="fr" id="fr_<?php echo $post->ID; ?>">
									<div class="price_main">
										<span class="strike_rate"><?php echo get_currency_sym(); ?><?php echo $current_price; ?></span> 
										<span class="rate"><?php echo get_currency_sym(); ?><?php echo $our_price; ?></span> 
									</div>
                                    <?php if (get_post_meta($post->ID, 'coupon_type', true) == 1)
										{ ?>
										<a href="<?php echo get_post_meta($post->ID, 'coupon_link', true); ?>" title="<?php echo BUY_NOW; ?>" class="btn_buy" target="_blank"><?php echo BUY_NOW; ?></a>
										<?php } else
										{ ?>
										<a href="<?php echo get_option('siteurl'); ?>/?ptype=buydeal&amp;did=<?php _e($post->ID, 'templatic'); ?>" title="<?php echo BUY_NOW; ?>" class="btn_buy"><?php echo BUY_NOW; ?></a>
									<?php } ?>
								</div>
                                <?php
									$targatedate = explode(' ', $targatedate);
									$tar_date = explode('-', $targatedate[0]);
									$tar_time = explode(':', $targatedate[1]);
									$timezone = (int)get_option('ptthemes_time_offset');
									$exp_year = explode(',', $tardate1);
								?>
								<script>
									displayTZCountDown(setTZCountDown('<?php echo $tar_date[1]; ?>','<?php echo $tar_date[0]; ?>','<?php echo $tar_time[0]; ?>','<?php echo $tar_time[1]; ?>','<?php echo $tar_time[2]; ?>','<?php echo $timezone; ?>','<?php echo $exp_year[1]; ?>'),'countdowncontainer_<?php _e($post->ID, 'templatic'); ?>','fr_<?php echo $post->ID; ?>','<?php echo $tardate1; ?>');
								</script>
							</div>
						<?php } ?>
					<?php } ?>
					
					<ul class="rate_summery">
						<li class="rate_current_price"><span><?php echo CURRENT_PRICE; ?></span> 
						<strong><small><?php echo get_currency_sym(); ?></small><?php echo $current_price; ?></strong></li>
						<li class="rate_our_price"><span><?php echo OUR_PRICE; ?></span> <strong><small><?php echo get_currency_sym(); ?></small><?php echo $our_price; ?></strong></li>
						<li class="rate_percentage"><span><?php echo YOU_SAVE; ?></span> <strong><?php echo @number_format($percentsave, 2); ?>%</strong></li>
						<?php if (get_post_meta($post->ID, 'shipping_cost', true) > 0)
							{ ?>
							<li class="rate_our_price"><span>
								<?php echo SHIPPING_COST; ?>
							</span> <strong><small><?php echo get_currency_sym(); ?></small><?php echo get_post_meta($post->ID, 'shipping_cost', true); ?></strong></li>
						<?php } ?>
						<li class="bdr_none rate_item_sold"><span><?php echo ITEMS_SOLD; ?></span> <strong><?php echo $sellsqlinfo; ?></strong>
							<?php
								if ($sellsqlinfo == 0)
								{
									$enddate = explode(" ", $tardate);
									$curdate = explode(" ", date("F d, Y H:i:s"));
									$enddate = str_replace(",", "", $enddate[1]);
									$curdate = str_replace(",", "", $curdate[1]);
									$startdate = explode(" ", $stdate);
									$strdate = str_replace(",", " ", $startdate[1]);
									$curtime = $enddate - $curdate;
									$totaltime = ($enddate - $strdate);
									$nowremail = $curdate - $strdate;
								?>
								<input type="hidden" value="<?php echo $nowremail; ?>" name="sellsqlinfo" id="sellsqlinfo"/>
								<input type="hidden" value="<?php echo ($enddate - $strdate); ?>" name="noofcoupon" id="noofcoupon"/>
								<?php } else
								{ ?>
								<input type="hidden" value="<?php echo $sellsqlinfo; ?>" name="sellsqlinfo" id="sellsqlinfo"/>
								<input type="hidden" value="<?php echo $no_of_coupon; ?>" name="noofcoupon" id="noofcoupon"/>
							<?php } ?>
						</li>
					</ul>										
					<?php if (get_post_meta($post->ID, 'enddate', true) == '0' && get_post_meta($post->ID, 'is_expired', true) == '0')
						{ ?>
						<?php if (get_post_meta($post->ID, 'coupon_type', true) == 1)
							{ ?>
							<a href="<?php echo get_post_meta($post->ID, 'coupon_link', true); ?>" title="<?php echo BUY_NOW; ?>" class="btn_buy_deal" target="_blank"><?php echo BUY_NOW; ?></a>
							<?php } else
							{ ?>
							<a href="<?php echo get_option('siteurl'); ?>/?ptype=buydeal&amp;did=<?php _e($post->ID, 'templatic'); ?>" title="<?php echo BUY_NOW; ?>" class="btn_buy_deal"><?php echo BUY_NOW; ?></a>
							<?php }
						}
					?>
					<?php if (get_post_meta($post->ID, 'is_expired', true) != 1 && get_post_meta($post->ID, 'enddate', true) == '')
						{
							if (get_post_meta($post->ID, 'coupon_type', true) == 1)
							{
							?>
							<a href="<?php echo get_post_meta($post->ID, 'coupon_link', true); ?>" title="<?php echo BUY_NOW; ?>" class="btn_buy_grid" target="_blank"><?php echo BUY_NOW; ?></a>
							<?php } else
							{ ?>
							<a href="<?php echo get_option('siteurl'); ?>/?ptype=buydeal&amp;did=<?php _e($post->ID, 'templatic'); ?>" title="<?php echo BUY_NOW; ?>" class="btn_buy_grid"><?php echo BUY_NOW; ?></a>
						<?php } ?>
					<?php } ?>
					<div class="text_content" id="content_<?php _e($post->ID, 'templatic'); ?>">
						<?php echo "" . $post->post_excerpt . ""; ?><a href="<?php the_permalink(); ?>" class="readmore_link"><?php _e(get_option('ptthemes_content_excerpt_readmore'));
						?> </a>
					</div>
			</div>
		</div>
        <?php
			$page_layout = templ_get_page_layout();
			if ($page_layout == 'full_width')
			{
				if ($pcount == 3)
				{
					$pcount = 0;
				?>
                <div class="hr clearfix"></div>
				<?php
				}
			} else if ($pcount == 2)
			{
				$pcount = 0;
			?>
            <div class="hr clear"></div>
		<?php } ?>
		
		<?php
		}
		if ($all_total_pages > $recordsperpage)
		{
			echo '<div style="text-align:right" >' . get_pagination($deal_targetpage, $all_total_pages, $recordsperpage, $all_pagination) . '</div>';
		}
	} else
	{
		echo '<h3>' . NO_DEAL . '</h3>';
	}?>	