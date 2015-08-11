<?php 
date_default_timezone_set(get_option('timezone_string'));
get_header();
$destination_path = site_url().'/wp-content/uploads/';
?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/timer.js"></script>
<script>
function viewtransaction(cuid,did)
{
	location.href= "?author="+cuid+"&transid="+did;
}
</script>

<div  class="<?php templ_content_css();?>" >
  <!--  CONTENT AREA START -->
  <?php templ_before_single_entry(); // before single entry  hooks?>
  <?php if ( have_posts() ) : 
  while ( have_posts() ) : the_post(); ?>
  <div class="entry"> 
    <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">	  
      <div class="post-meta">
        <?php // echo templ_page_title_filter(get_the_title()); //page tilte filter?>
        <!--  Post Title Condition for Post Format-->
        <?php if ( has_post_format( 'chat' )){?>
        <?php  echo templ_page_title_filter(get_the_title()); //page tilte filter?>
        <?php }elseif(has_post_format( 'gallery' )){?>
        <?php  echo templ_page_title_filter(get_the_title()); //page tilte filter?>
        <?php }elseif(has_post_format( 'image' )){?>
        <?php  echo templ_page_title_filter(get_the_title()); //page tilte filter?>
        <?php }elseif(has_post_format( 'link' )){?>
        <?php  echo templ_page_title_filter(get_the_title()); //page tilte filter?>
        <?php }elseif(has_post_format( 'video' )){?>
        <?php  echo templ_page_title_filter(get_the_title()); //page tilte filter?>
        <?php }elseif(has_post_format( 'audio' )){?>
        <?php  echo templ_page_title_filter(get_the_title()); //page tilte filter?>
        <?php }else{?>
        <?php  echo templ_page_title_filter(get_the_title()); //page tilte filter?>
        <?php }?>
        <?php if ( has_post_format( 'chat' )){?>
        <div class="post-content">
          <?php the_content(); ?>
        </div>
        <?php }else{?>
        <?php }?>
        <!--  Post Title Condition for Post Format-->
        <?php //$post = get_post($post->ID);
				$postmeta_db_table_name = $wpdb->prefix . "postmeta";
				$post_db_table_name = $wpdb->prefix . "posts";
				
				deal_expire_process($post->ID); 
				$home_deal_id = '';
				$home_deal_id = $post->ID;
				global $home_deal_id;
				$coupon_website= get_post_meta($post->ID,'coupon_website',true);
				$owner_name= get_post_meta($post->ID,'owner_name',true);
				$our_price= get_post_meta($post->ID,'our_price',true);
				$current_price= get_post_meta($post->ID,'current_price',true);
				
				$sellsql = "select count(*) from $transection_db_table_name where post_id=".$post->ID." and status=1";
				$totdiff = $current_price - $our_price;
				$percent = $totdiff * 100;
				$percentsave = $current_price > 0 ? $percent/$current_price : 0;
                $sellsqlinfo = $wpdb->get_var($sellsql);
				$geo_longitude  = get_post_meta($post->ID,'geo_longitude',true);
				$geo_latitude  = get_post_meta($post->ID,'geo_latitude',true);
				$shhiping_address  = get_post_meta($post->ID,'shhiping_address',true);
				$coupon_type = get_post_meta($post->ID,'coupon_type',true);				
				if(get_post_meta($post->ID,'coupon_end_date_time',true) != "")
				{
				$date = get_post_meta($post->ID,'coupon_end_date_time',true);
				$tardate= date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));				
				$targatedate= date("d-m-y H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));				
				$tardate1= date("F d, Y",get_post_meta($post->ID,'coupon_end_date_time',true));
				$enddate1 = date("Y-m-d H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));
				}
				$stdate= date("F d, Y H:i:s",(int)get_post_meta($post->ID,'coupon_start_date_time',true));
				$no_of_coupon = get_post_meta($post->ID,'no_of_coupon',true);
				
				
				?>
        <?php if(get_post_format( $post->ID )){
        $format = get_post_format( $post->ID );
        ?>
        <em>&bull; </em> <a href="<?php echo get_post_format_link($format); ?>" title="<?php esc_attr_e( 'View '. $format, 'templatic' ); ?>">
        <?php _e( 'More '. $format, 'templatic' ); ?>
        </a>
        <?php } ?>
      </div>
      <?php templ_before_single_post_content(); // BEFORE  single post content  hooks?>
      <!--  Post Content Condition for Post Format-->
      <div class="product_image">
        <?php if(get_post_meta($post->ID,'file_name',true) != "") { ?>
        <img src="<?php echo templ_thumbimage_filter(get_post_meta($post->ID,'file_name',true),165,180);?>" width="165" height="180" alt="" />
        <?php }else{ ?>
	   	<img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" width="165" height="180" alt="" />
        <?php } ?>
		<div class="mp_deal_price">
			<div class="mp_current_price"><span class="mp_redline"></span><?php echo MP_CURENT_PRICE;?> <small><?php echo get_currency_sym();?></small><?php echo get_post_meta($post->ID,'current_price',true);?>,-</div>
			<div class="mp_our_price"><?php echo MP_OUR_PRICE;?> <strong><small><?php echo get_currency_sym();?></small><?php echo get_post_meta($post->ID,'our_price',true);?></strong></div>
		</div>
      </div>

      <!--  Post Content Condition for Post Format-->
      <div class="content_right content_right_inner">
        <?php 	if($_REQUEST['sendtofrnd']=='success') { ?>
        <p class="sucess_msg">
          <?php _e('Email to Friend sent successfully','templatic');?>
        </p>
        <?php 	}?>        
        <?php 									
				if(get_post_meta($post->ID,'coupon_end_date_time',true) !="")
				if(strtotime(date("F d, Y H:i:s"))>= strtotime(date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true))) || get_post_meta($post->ID,'no_of_coupon',true)==$sellsqlinfo || get_post_meta($post->ID,'is_expired',true)=='1')
				{
					if(get_post_meta($post->ID,'is_expired',true)=='1' ) 
					{
							if(get_post_meta($post->ID,'is_expired',true)== '0') {
								update_post_meta($post->ID,'is_expired','1');
							} ?>
							<div class="i_expire"><span><?php echo THIS_DEAL_IS_EXPIRED;?></span></div>
        <?php  		}
					if(get_post_meta($post->ID,'no_of_coupon',true)== $sellsqlinfo && get_post_meta($post->ID,'is_expired',true)!='1') { ?>
					<div class="i_start"><span><?php echo "Is Sold Out"; ?></span></div>
					<?php }
					?>
					<h3>Bekijk de actuele deals van vandaag</h3>
					<a href="<?php echo get_option('home');?>?ptype=taxonomy_live_deal_tab" title="Actuele Deals" class="actuele_deal_btn btn_buy" target="_self" style="clear: both;float: left;">Actuele Deals</a>
					<?php
				} else {
					if(get_post_meta($post->ID,'coupon_end_date_time',true)){ ?>
        <div id="demo" style="pointer-events:none; cursor:default;display:block;position:relative;">
          <div id="slider-range-min-var"  ></div>
		  <div style="position:absolute;width:104%;height:135%;z-index:10;top:-3px;left:-10px;" ></div>
        </div>
		<?php if(templ_is_show_post_category()){?>
        <div class="post_cats clearfix" style="margin-bottom: 15px;">
          <?php the_taxonomies(array('before'=>'<span class="categories">','sep'=>'</span><span class="tags">','after'=>'</span>')); ?>
        </div>
        <?php } ?>
        <div class="deal_time_box">
          <div class="time_line"></div>
          <div id="countdowncontainer1"></div>
        
          <div class="fr">
            <div class="price_main" style="clear: both; display: none;"> 
				<span class="strike_rate"><?php echo get_currency_sym();?><?php echo $current_price;?></span> <span class="rate"><?php echo get_currency_sym();?><?php echo $our_price;?></span> </div>
            <?php 
			if(get_post_meta($post->ID,'coupon_type',true) == 1) { ?>
            <a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" title="Buy now!" class="btn_buy" target="_blank" style="clear: both;float: left;"><?php _e(BUY_NOW, 'templatic');?></a>
            <?php } else { echo ""; ?>
            <a href="<?php echo get_option('siteurl');?>/?ptype=buydeal&amp;did=<?php _e($post->ID,'templatic'); ?>" title="Buy now!" class="btn_buy" style="clear: both;float: left;" ><?php _e(BUY_NOW, 'templatic');?></a>
            <?php }?>			
          </div>
		  <!-- twitter & facebook likethis option-->
      <div class="share_div single_share_spacer" style="padding: 10px 0 0 0;top: 7px;display: block;clear: both;position: relative;">
		<span style="float: left; color: #000;margin-right: 30px;font-size: 13px;line-height: 22px;"><strong>Win deze deal!</strong> Deel en maak kans!</span>	        
		<?php /*
       <div class="googleplus">
        <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
		<script type="text/javascript">
			gapi.plusone.render(gcontent,"href": "<?php the_permalink(); ?>", "state": "on");
			gapi.plusone.go("gcontent");

		</script>
		<div id="gcontent">
        <g:plusone href="<?php the_permalink(); ?>" size="medium"></g:plusone>
		</div>
      </div>
	  */?>
        <?php templ_show_facebook_button();?>
		<div class="twitt_like"><?php templ_show_twitter_button();	?></div>
        <a style="display: none;" href="javascript:void(0);" onclick="show_hide_popup('basic-modal-content');" title="Stuur naar een vriend" class="i_mail b_sendtofriend">
        <?php _e('Stuur door!','templatic');?>
        </a>
        <?php include_once (TEMPLATEPATH . '/monetize/send_to_friend/popup_frms.php');?>
      </div>
      <!--#end -->
		    <?php							
							$targatedate = explode(' ',$targatedate);
							$tar_date =  explode('-',$targatedate[0]);							
							$tar_time =  explode(':',$targatedate[1]);
							$timezone = (int)get_option('ptthemes_time_offset');							
							$exp_year =  explode(',',$tardate1);
							?>
							<script>
							displayTZCountDown(setTZCountDown('<?php echo $tar_date[1]; ?>','<?php echo $tar_date[0]; ?>','<?php echo $tar_time[0]; ?>','<?php echo $tar_time[1]; ?>','<?php echo $tar_time[2]; ?>','<?php echo $timezone; ?>','<?php echo $exp_year[1]; ?>'),'countdowncontainer1','fr_<?php echo $post->ID; ?>','<?php echo $tar_date1; ?>');
							</script>
        </div>
        <?php 	} ?>
        <?php 	} ?>	
        <ul class="rate_summery" style="display: none">
		<?php $sellsqlinfo2= (int)get_post_meta($post->ID,'no_of_coupon',true) - (int)$sellsqlinfo;?>
          <li class="rate_current_price"><span>
             <?php echo CURRENT_PRICE;?>
            </span> <strong><small><?php echo get_currency_sym();?></small><?php echo get_post_meta($post->ID,'current_price',true);?></strong></li>
          <li class="rate_our_price"><span>
            <?php echo OUR_PRICE;?>
            </span> <strong><small><?php echo get_currency_sym();?></small><?php echo get_post_meta($post->ID,'our_price',true);?></strong></li>
          <li class="rate_percentage"><span>
            <?php echo YOU_SAVE;?>
            </span> <strong><?php echo @number_format($percentsave,2);?>%</strong></li>
          <li class="bdr_none rate_item_sold"><span>
            <?php echo ITEMS_SOLD;?>
            </span> <strong><?php echo $sellsqlinfo; ?></strong>
            <?php 	if($sellsqlinfo == 0 ) { 
						$enddate = explode(" ",$tardate); 
						$curdate = explode(" ",date("F d, Y H:i:s"));
						$enddate= str_replace(",","",$enddate[1]);
					    $curdate =  str_replace(",","",$curdate[1]);
						$startdate = explode(" ",$stdate);
						$strdate = str_replace(","," ",$startdate[1]);
						$curtime = $enddate - $curdate;
						$totaltime =  ($enddate - $strdate);
						$nowremail = $curdate - $strdate;
						?>
            <input type="hidden" value="<?php echo $nowremail ; ?>" name="sellsqlinfo1" id="sellsqlinfo1"/>
            <input type="hidden" value="<?php  echo ($enddate - $strdate) ; ?>" name="noofcoupon1" id="noofcoupon1"/>
            <?php 	} else {  ?>
            <input type="hidden" value="<?php echo $sellsqlinfo; ?>" name="sellsqlinfo1" id="sellsqlinfo1"/>
            <input type="hidden" value="<?php echo $no_of_coupon; ?>" name="noofcoupon1" id="noofcoupon1"/>
            <?php 	} ?>
          </li>
        </ul>        
        <?php 
						
						$categories = get_the_category($postID);
						count($categories)	;
						if(count($categories) == '0'){
							foreach($categories as $c){
									echo $c;
							}
						}
						?>
        <div id="post_category"></div>
		<?php 	if((get_post_meta($post->ID,'enddate',true) == '0' ) && (get_post_meta($post->ID,'status',true) == '1' || get_post_meta($post->ID,'status',true) == '2')  && get_post_meta($post->ID,'is_expired',true) == '0') { 
		
		?>
		<?php 		if(get_post_meta($post->ID,'coupon_type',true) == 1) {?>
						<a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" title="<?php echo BUY_NOW ;?>" class="btn_buy_deal" target="_blank"><?php echo BUY_NOW ;?></a>
		<?php 		} else { ?>
						<a href="<?php echo get_option('siteurl');?>/?ptype=buydeal&amp;did=<?php _e($post->ID,'templatic'); ?>" title="<?php echo BUY_NOW ;?>" class="btn_buy_deal"><?php echo BUY_NOW ;?></a>
		<?php 		}
				}?>
        <div id="content" class="text_content">
          <?php 
 					the_content(); 
					echo '<ul>'.get_post_custom_listing_single_page($post->ID,'<li><span><strong>{#TITLE#}</strong></span> : {#VALUE#}</li>').'</ul>';
					if($coupon_type == '4' && get_option(ptttheme_google_map_opt) == 'Enable') {
					echo "<p><h5 class='title'>Seller's location : </h5></p>";
					if($geo_longitude &&  $geo_latitude){
							include_once (TEMPLATEPATH . '/library/map/preview_map.php');?>
          <?php show_address_google_map($geo_latitude,$geo_longitude,$shhiping_address,$width='410',$height='400');?>
          <?php }elseif($shhiping_address){?>
          <iframe src="http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=<?php echo $shhiping_address;?>&ie=UTF8&z=14&iwloc=A&output=embed" height="300" width="250"></iframe>
          <?php }
}?>
        </div>


      </div>
      <?php templ_after_single_post_content(); 
		// after single post content hooks?>      
    </div>
	<p style="font-size:18px; color:#272a2c; margin-bottom:5px; font-weight:bold;">Wat vind je van deze aanbieding?</p>
				<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-comments" data-href="<?php the_permalink() ?>" data-width="675" data-num-posts="10"></div>
	
    <div class="post-navigation clear">
      <?php
            $prev_post = get_adjacent_post(false, '', true);
            $next_post = get_adjacent_post(false, '', false); ?>
      <?php if ($prev_post) : $prev_post_url = get_permalink($prev_post->ID); $prev_post_title = $prev_post->post_title; ?>
      <a class="post-prev" href="<?php echo $prev_post_url; ?>"><em><?php echo PREVIOUS_DEAL; ?></em><span><?php echo $prev_post_title; ?></span></a>
      <?php endif; ?>
      <?php if ($next_post) : $next_post_url = get_permalink($next_post->ID); $next_post_title = $next_post->post_title; ?>
      <a class="post-next" href="<?php echo $next_post_url; ?>"><em><?php echo NEXT_DEAL; ?></em><span><?php echo $next_post_title; ?></span></a>
      <?php endif; ?>
    </div>
	<?php $post_id=$post->ID;
		$search_string = $search_string.'&numberposts=3&exclude='.$post->ID.'&orderby=rand&post_type='.CUSTOM_POST_TYPE1;
		$post_content = get_posts($search_string);
		if($post_content) { ?>
			<br/><br/><br/>
			<h2 class="relatedtitle"> <?php echo RELATED_DEAL;?> </h2>
<?php			foreach($post_content as $key=>$val) {
					$post = $val;?>
					<div class="releateddeal">
						<div class="product_image">
							<a href="<?php the_permalink(); ?>">
					<?php if(get_post_meta($post->ID,'file_name',true) != "") { ?>
							<img src="<?php echo templ_thumbimage_filter(get_post_meta($post->ID,'file_name',true),165,180);?>" width="165" height="180" alt="" />
					<?php } else{ ?>
						<img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" width="165" height="180" alt="" />
					<?php } ?>							
							</a>
							<div class="mp_deal_price">
								<div class="mp_current_price"><span class="mp_redline"></span><?php echo MP_CURENT_PRICE;?> <small><?php echo get_currency_sym();?></small><?php echo get_post_meta($post->ID,'current_price',true);?>,-</div>
								<div class="mp_our_price"><?php echo MP_OUR_PRICE;?> <strong><small><?php echo get_currency_sym();?></small><?php echo get_post_meta($post->ID,'our_price',true);?></strong></div>
							</div>
						</div>
						<div class="content_right content_right_inner" style="margin-left:10px;"><h3><a href="<?php the_permalink(); ?>"><?php echo $post->post_title; ?></a></h3>						       
						<?php 	
								if(get_post_meta($post->ID,'coupon_end_date_time',true) !="")
								if(strtotime(date("F d, Y H:i:s"))>= strtotime(date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true))) || get_post_meta($post->ID,'no_of_coupon',true)==$sellsqlinfo || get_post_meta($post->ID,'is_expired',true)=='1')
								{
									if(get_post_meta($post->ID,'is_expired',true)=='1' ) 
									{
											if(get_post_meta($post->ID,'is_expired',true)== '0') {
												update_post_meta($post->ID,'is_expired','1');
											} ?>
											<div class="i_expire"><span><?php echo THIS_DEAL_IS_EXPIRED;?></span></div>
						<?php  					}
									if(get_post_meta($post->ID,'no_of_coupon',true)== $sellsqlinfo && get_post_meta($post->ID,'is_expired',true)!='1') { ?>
									<div class="i_start"><span><?php echo "Is Sold Out"; ?></span></div>
									<?php }
								} else {
									if(get_post_meta($post->ID,'coupon_end_date_time',true)){ ?>						
						<?php if(templ_is_show_post_category()){?>
						<div class="post_cats clearfix" style="margin-bottom: 15px;">
						  <?php the_taxonomies(array('before'=>'<span class="categories">','sep'=>'</span><span class="tags">','after'=>'</span>')); ?>
						</div>
						<?php } ?>
						<div class="deal_time_box">
						  <div class="time_line"></div>
						  <div id="countdowncontainer<?php echo $post->ID;?>"></div>												  
							<!-- twitter & facebook likethis option-->					  
							<!--#end -->
							
							<?php
										if(get_post_meta($post->ID,'coupon_end_date_time',true) != "")
										{
											$date = get_post_meta($post->ID,'coupon_end_date_time',true);
											$tardate= date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));
											$targatedate= date("d-m-y H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));
											$tardate1= date("F d, Y",get_post_meta($post->ID,'coupon_end_date_time',true));
											$enddate1 = date("Y-m-d H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));
										}
											$targatedate = explode(' ',$targatedate);
											$tar_date =  explode('-',$targatedate[0]);
											$tar_time =  explode(':',$targatedate[1]);
											$timezone = (int)get_option('ptthemes_time_offset');
											$exp_year =  explode(',',$tardate1);
											?>
											<script>
											displayTZCountDown(setTZCountDown('<?php echo $tar_date[1]; ?>','<?php echo $tar_date[0]; ?>','<?php echo $tar_time[0]; ?>','<?php echo $tar_time[1]; ?>','<?php echo $tar_time[2]; ?>','<?php echo $timezone; ?>','<?php echo $exp_year[1]; ?>'),'countdowncontainer<?php echo $post->ID;?>','fr_<?php echo $post->ID; ?>','<?php echo $tardate1; ?>');

											</script>
						</div>
						<?php 	} ?>
						<?php 	} ?>							       
						<?php 										
										$categories = get_the_category($postID);
										count($categories)	;
										if(count($categories) == '0'){
											foreach($categories as $c){
													echo $c;
											}
										}
										?>
						<div id="post_category"></div>		
						<?php echo "".$post->post_excerpt."";  ?><a href="<?php the_permalink(); ?>" class="readmore_link"><?php _e(get_option('ptthemes_content_excerpt_readmore'));?> </a>						
					</div>
					</div>
<?php				}
				}?>  
	
	
  </div>

  <?php endwhile; ?>
  <?php endif; ?>


      <?php if(get_option('ptthemes_dealcomments') == 'Yes') { the_post(); ?>
  <?php comments_template(); ?>
  <?php } ?>
  <?php templ_after_single_entry(); // after single entry  hooks?>

  <!--  CONTENT AREA END -->
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>