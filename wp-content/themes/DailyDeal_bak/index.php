<?php
global $Cart, $General;
get_header(); ?>
<script type="text/javascript" >
var root_path_js = '<?php echo get_option('siteurl')."/";?>';
</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/jquery-ui-1.8.14.custom.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/timer.js"></script>
<script type="text/javascript">
jQuery.noConflict();
	function a()
	{
		return false;
	}
	jQuery(function() { 
		jQuery( "#slider-range-min-var" ).slider({
			range: "min",
			value: jQuery("#sellsqlinfo1").val(),
			min:  0,
			max: jQuery("#noofcoupon1").val(),
			enable: false,
			slide: function( event, ui ) {
				jQuery("#amount").val("$"+ ui.value );
			}
		});
		jQuery( "#amount" ).val( "$" + jQuery( "#slider-range-min-var" ).slider( "value" ) );
		
	});
</script>
<?php
/* Mail To Friend BOF */
if($_POST['sendact']=='email_frnd') {
	require_once (TEMPLATEPATH . '/monetize/send_to_friend/email_friend_frm.php');exit;
}
/* Mail To Friend EOF */
/* Home Page Deal Display BOF */
global $wpdb,$deal_db_table_name;	
date_default_timezone_set(get_option('timezone_string'));
$postmeta_db_table_name = $wpdb->prefix."postmeta";
$post_db_table_name = $wpdb->prefix."posts";
$destination_path = site_url().'/wp-content/uploads/';
$args = array('numberposts' => 1,'meta_query' => array(
		array(
			'key' => 'is_expired',
			'value' => '0',
		),array(
			'key' => 'status',
			'value' => '2',
		)),'post_status' => 'publish','post_type' => 'seller','meta_key' =>'is_show' , 'meta_value' =>'1' ,'orderby' => 'DESC');
$recent_posts = get_posts( $args );
if(mysql_affected_rows() > 0) { // 1st IF Condition BOF
	$post_large = bdw_get_images($destination_path.get_post_meta($post->ID,'file_name',true),'large');
	$post_images = bdw_get_images($destination_path.get_post_meta($post->ID,'file_name',true),'thumb'); ?>
	<div class="top_content">
<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('home_above')) { } else {  }?>
	</div>
<!-- top content #end -->
	<div class="box_header"></div>
	<div class="box_bg">
	<div class=" box_bottom">
<?php foreach( $recent_posts as $post ){  // foreach loop BOF
		if(get_post_meta($post->ID,'status',true) == 2) { 
			if(get_post_meta($post->ID,'enddate',true) != '0'){
			deal_expire_process($post->ID); 
			}
			$home_deal_id = $post->ID;
			global $home_deal_id;
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
			if($date != ""){
			$tardate= date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));
			$targatedate= date("d-m-y H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));
			$tardate1= date("F d, Y",get_post_meta($post->ID,'coupon_end_date_time',true));
			}
			$stdate= date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_start_date_time',true));
			
			if(get_post_meta($post->ID,'enddate',true) != '0'){
			if(get_post_meta($post->ID,'coupon_end_date_time',true) != "") {
				if(date("Y-m-d H:i:s") >= $tardate1 && get_post_meta($post->ID,'enddate',true) != '0' ) {
					if(get_post_meta($post->ID,'is_expired',true)== '0' || get_post_meta($post->ID,'is_expired',true)== '')	{
						update_post_meta($post->ID,'is_expired','1');
					}
				}
			} else {
				if(get_post_meta($post->ID,'enddate',true) != '0' ) {
					if(get_post_meta($post->ID,'is_expired',true)== '0' || get_post_meta($post->ID,'is_expired',true)== '')	{
						update_post_meta($post->ID,'is_expired','1');
					}
				}
			} }
			$geo_longitude  = get_post_meta($post->ID,'geo_longitude',true);
			$geo_latitude  = get_post_meta($post->ID,'geo_latitude',true);
			$shhiping_address  = get_post_meta($post->ID,'shhiping_address',true);
			$coupon_type = get_post_meta($post->ID,'coupon_type',true);
			$no_of_coupon = get_post_meta($post->ID,'no_of_coupon',true); ?>
			<div class="content_left"> <a href="<?php the_permalink(); ?>">
			<?php if(get_post_meta($post->ID,'file_name',true) != "") { ?>
					<img src="<?php echo templ_thumbimage_filter(get_post_meta($post->ID,'file_name',true),330,250); ?>" alt="" />
			<?php } else { ?>
					<img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" width="330" height="250" alt="" />
			<?php } ?>
			</a> </div>
			<div class="content_right">
				<span class="title_yellow"><?php echo TODAY_DEAL; ?></span> 
				<span class="title_grey"><?php echo PROVIDE_BY; ?></span>
<?php		
				$user_db_table_name = get_user_table();
				$user_data = $wpdb->get_row("select * from $user_db_table_name where ID = '".$post->post_author."'");
				if(get_post_meta($post->ID,'coupon_type',true) == 1) { ?>
									<a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" title="<?php echo $user_data->display_name; ?>" class="top_lnk" target="_blank"><?php echo get_post_meta($post->ID,'owner_name',true);?></a>
			<?php 				} else { ?>
				<a href="<?php echo get_author_posts_url($post->post_author);?>" class="top_lnk" title="<?php echo get_post_meta($post->ID,'owner_name',true);?>"><?php echo get_post_meta($post->ID,'owner_name',true);?></a>
				<?php } ?>
				<h3><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></h3>
<?php 			
					if(get_post_meta($post->ID,'enddate',true) != '0'){
				    if(get_post_meta($post->ID,'no_of_coupon',true)== $sellsqlinfo || strtotime(date("F d, Y H:i:s"))>= strtotime($tardate) ){ 
					if(get_post_meta($post->ID,'is_expired',true)=='1') {
						?>
					<div class="i_expire"><?php echo THIS_DEAL;?><span><?php echo EXPIRED;?></span> <?php echo ON;?> <span><?php echo $tardate1;?></span></div>
<?php  					}
					if(get_post_meta($post->ID,'no_of_coupon',true)== $sellsqlinfo && get_post_meta($post->ID,'is_expired',true)!='1') { ?>
					<div class="i_start"><span><?php echo "Is Sold Out"; ?></span></div>
					<?php }
				} else {
					if(get_post_meta($post->ID,'coupon_end_date_time',true)){ ?>
						<div id="demo" style="pointer-events:none; cursor:default;display:block;position:relative;">
							<div id="slider-range-min-var"  ></div>
							<div style="position:absolute;width:104%;height:135%;z-index:10;top:-3px;left:-10px;" ></div>
						</div>
						<div class="deal_time_box">
							<div class="time_line"></div>
							<div id="countdowncontainer"></div>
							<div class="fr" id="fr_index" style="display:block;">
								<div class="price_main"> <span class="strike_rate"><?php echo get_currency_sym();?><?php echo $current_price;?></span> <span class="rate"><?php echo get_currency_sym();?><?php echo $our_price;?></span> </div>
<?php 								if(get_post_meta($post->ID,'coupon_type',true) == 1) { ?>
									<a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" title="<?php echo BUY_NOW;?>" class="btn_buy" target="_blank"><?php echo BUY_NOW;?></a>
<?php 								} else { ?>
									<a href="<?php echo get_option('siteurl');?>/?ptype=buydeal&amp;did=<?php _e($post->ID,'templatic'); ?>" title="<?php echo BUY_NOW;?>" class="btn_buy"><?php echo BUY_NOW;?></a>
<?php 								}?>
							</div>
							<?php
							$targatedate = explode(' ',$targatedate);
							$tar_date =  explode('-',$targatedate[0]);
							$tar_time =  explode(':',$targatedate[1]);
							$timezone = get_option('ptthemes_time_offset');
							$exp_year =  explode(',',$tardate1);
							?>
							<script>
							displayTZCountDown(setTZCountDown('<?php echo $tar_date[1]; ?>','<?php echo $tar_date[0]; ?>','<?php echo $tar_time[0]; ?>','<?php echo $timezone; ?>','<?php echo $exp_year[1]; ?>'),'countdowncontainer','fr_index','<?php echo $tardate1; ?>');
							</script>
							
						</div>
<?php 					} ?>
<?php 				} }?>
				<!-- Rate Summery BOF -->
				<ul class="rate_summery border_bottom">
					<li class="rate_current_price"><span><?php echo CURRENT_PRICE;?></span> <strong><small><?php echo get_currency_sym();?></small><?php echo $current_price;?></strong></li>
					<li class="rate_our_price"><span><?php echo OUR_PRICE;?></span> <strong><small><?php echo get_currency_sym();?></small><?php echo $our_price;?></strong></li>
					<li class="rate_percentage"><span><?php echo YOU_SAVE;?></span> <strong><?php echo @number_format($percentsave,2);?>%</strong></li>
					<li class="bdr_none rate_item_sold"><span><?php echo ITEMS_SOLD;?></span> <strong><?php echo $sellsqlinfo;?></strong>
<?php 					if($sellsqlinfo == 0 ) { 
						$enddate = explode(" ",$tardate); 
						$curdate = explode(" ",date("F d, Y H:i:s"));
						$enddate= str_replace(",","",$enddate[1]);
						$curdate =  str_replace(",","",$curdate[1]);
						$startdate = explode(" ",$stdate);
						$strdate = str_replace(","," ",$startdate[1]);
						$curtime = $enddate - $curdate;
						$totaltime =  ($enddate - $strdate);
						$nowremail = $curdate - $strdate; ?>
						<input type="hidden" value="<?php echo $nowremail ; ?>" name="sellsqlinfo1" id="sellsqlinfo1"/>
						<input type="hidden" value="<?php  echo ($enddate - $strdate) ; ?>" name="noofcoupon1" id="noofcoupon1"/>
<?php 					} else {  ?>
					  <input type="hidden" value="<?php echo $sellsqlinfo; ?>" name="sellsqlinfo1" id="sellsqlinfo1"/>
					  <input type="hidden" value="<?php echo $no_of_coupon; ?>" name="noofcoupon1" id="noofcoupon1"/>
<?php 					} ?></li>
				</ul>
				<?php 	if(get_post_meta($post->ID,'enddate',true) == '0' && get_option('ptttheme_view_opt') != 'Grid View' && (get_post_meta($post->ID,'status',true) == '1' || get_post_meta($post->ID,'status',true) == '2') ) { 
		
		?>
		<?php 		if(get_post_meta($post->ID,'coupon_type',true) == 1) {?>
						<a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" title="<?php echo BUY_NOW;?>" class="btn_buy_deal" target="_blank"><?php echo BUY_NOW;?></a>
		<?php 		} else { ?>
						<a href="<?php echo get_option('siteurl');?>/?ptype=buydeal&amp;did=<?php _e($post->ID,'templatic'); ?>" title="<?php echo BUY_NOW;?>" class="btn_buy_deal"><?php echo BUY_NOW;?></a>
		<?php 		}
				}?>
				<!-- Rate Summery EOF -->
				<div id="content" class="text_content" ><?php echo "".$post->post_excerpt."";  ?>
					<a href="<?php echo get_permalink($post->ID); ?>" class="readmore_link"><?php _e(get_option('ptthemes_content_excerpt_readmore'));?></a> </div>
				</div>
				<!-- Social Network Button Like: twitter,facebook,google + one BOF -->
				<div class="share_div index_share_spacer">
					<div class="twitt_like"><?php templ_show_twitter_button();	?></div>
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
					<?php templ_show_facebook_button(); ?>
					<a href="javascript:void(0);" onclick="show_hide_popup('basic-modal-content');" title="<?php echo MAIL_TO_A_FRIEND;?>" class="i_mail b_sendtofriend"><?php echo MAIL_TO_A_FRIEND;?></a> 
				</div>
				<!-- Social Network Button Like: twitter,facebook,google + one EOF -->
<?php 		} else {  ?>
				<div class="content_left">
					<h3><?php echo _e(NO_RECENT_DEAL,'templatic'); ?></h3>
				</div>
<?php 		} 
		}  // foreach loop BOF ?>
	</div>
	</div>
<?php
	} // 1st IF Condition EOF
/* Home Page Deal Display EOF */ ?>

<!-- main post #end -->
<div class="clear">
  <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('home_below')) { } else {  }?>
</div>
<?php include_once (TEMPLATEPATH . '/monetize/send_to_friend/popup_frms.php');?>
<?php get_footer(); ?>