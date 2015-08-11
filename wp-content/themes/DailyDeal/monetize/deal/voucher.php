<!DOCTYPE html >
<html>
<head>
	<title><?php wp_title ( '|', true,'right' ); ?></title>
    <style type="text/css">
    
	/*----------------------------------------------------------------------------------- 
	CSS Reset & Clearfix
----------------------------------------------------------------------------------*/
html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,font,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td{margin:0;padding:0;border:0;outline:0;font-size:100%;vertical-align:baseline;background:transparent;}
body{line-height:1;text-align:left;}
ol,ul{list-style:none;}
blockquote,q{quotes:none;}
blockquote:before,blockquote:after,q:before,q:after{content:'';content:none;}
:focus {outline:0;}
ins{text-decoration:none;}
del{text-decoration:line-through;}
table{border-collapse:collapse;border-spacing:0;}
.none { display:none; }

body { font:14px Arial, Helvetica, sans-serif; }
.clear:after {content: "."; display: block; height: 0; clear: both; visibility: hidden;}
.left { float: left;}
.right { float: right;}

.wrapper{ margin:0 auto; width:800px; }

.box{ padding:5px; border:1px solid #555; margin-top:10px; height:100%; overflow:hidden; position: relative;}
.box .logo{ background:#555; padding:15px; margin-bottom:10px; height:100%; overflow:hidden; }
.box .site-title a{ font: 30px Georgia, Geneva, "Times New Roman", times; text-transform:uppercase; text-decoration:none; font-weight:bold; color:#fff; float:left; text-shadow:1px 1px 1px #234874;}
.box  p.site-description { margin-left:10px; width: 80px; float: left; text-transform:uppercase; color:#fff; line-height:14px; padding-top:5px; }


.box .deal_title{ clear:both; float:left;font-size:25px; }
.box .coupon_code{ color:#FFFFFF; font-size:20px; position:absolute; right:20px; text-align:right; top:19px; width:275px;}
.box .billing_address{ clear:both; float:left;  line-height:17px;}
.box .shipping_address{ float:right; line-height:14px; width:200px; }
.box .deal_paid{ clear:both;}
.box .amount{ font-size:18px; }
.box p{ line-height:30px;}
a.i_print { background:url(<?php bloginfo('template_directory'); ?>/images/i_print.png) no-repeat left top; padding-left:22px; padding-top:1px; text-decoration:none;float:right;color:#000000;font-size:14px; }	
.notification_text  { text-align:center; font-size:15px; font-weight:bold; padding:20px 0; background:#ededed; color:#333; -webkit-border-radius: 8px; -khtml-border-radius: 8px; border-radius: 8px; width:99%; }
    </style>
</head>
<body >
<div class="wrapper">
	<div class="box">
		<div class="logo">
			<?php
			templ_site_logo();
			global $wpdb,$current_user;
			$transaction_table = $wpdb->prefix."deal_transaction";
			$transaction_childdeal = $wpdb->get_row("select * from $transaction_table where trans_id = '".$_REQUEST['transaction_id']."' and user_id ='".$current_user->ID."'");
			?>
		</div>
		<?php 
		
		if($_SERVER['HTTP_REFERER'] != '' && $transaction_childdeal !=""){ ?>
		<a href="#" onClick="window.print();" class="i_print"><?php echo PRINT_LABEL;?></a>
		<p class="deal_title"><?php echo $transaction_childdeal->post_title;?></p>
		<p class="coupon_code"><?php echo COUPON_CODE ;?> : <?php echo $transaction_childdeal->deal_coupon;?></p>
		
		<p class="billing_address">
		<?php echo $transaction_childdeal->billing_name;?> <br />
		<strong><?php echo BUY_DEAL_BILLING_TEXT;?> :</strong><br /><?php echo $transaction_childdeal->billing_add;?></p>
		<?php  if($transaction_childdeal->shipping_name != '') {  ?>
		<p class="shipping_address">
		<?php if($transaction_childdeal->deal_type == '4') { echo $transaction_childdeal->shipping_name;?> <br />
		<strong><?php echo SHIPPING_ADDRESS;?> :</strong><br /> <?php echo $transaction_childdeal->shipping_add;?> 
		<?php } else { echo get_post_meta($transaction_childdeal->post_id,'voucher_text',true); }} ?></p>
		<p class="deal_paid"><?php echo PAID_AMOUNT;?> <span class="amount"><?php echo get_currency_sym().number_format($transaction_childdeal->payable_amt,2);?></span></p>
		<p class="coupon_expire"><?php if(get_post_meta($transaction_childdeal->post_id,'coupon_end_date_time',true) != ''){
			//echo EXPIRE_ON.date("F d,Y H:i:s",get_post_meta($transaction_childdeal->post_id,'coupon_end_date_time',true));
		} else {
			//echo START_FROM.date("F d,Y H:i:s",get_post_meta($transaction_childdeal->post_id,'coupon_start_date_time',true));
		}?></p>
		 <center><?php 
		 if(get_post_meta($transaction_childdeal->post_id,'coupon_type',true) == '4' && get_option(ptttheme_google_map_opt) == 'Enable' && get_option('pttheme_google_map_api') != '' ) {
		 $geo_longitude  = get_post_meta($transaction_childdeal->post_id,'geo_longitude',true);
		 $geo_latitude  = get_post_meta($transaction_childdeal->post_id,'geo_latitude',true);
		 $shipping_address  = get_post_meta($transaction_childdeal->post_id,'shhiping_address',true);
		 if($geo_longitude &&  $geo_latitude){?>
<?php include_once (TEMPLATEPATH . '/library/map/preview_map.php');?>
<?php show_address_google_map($geo_latitude,$geo_longitude,$shipping_address,$width='410',$height='400');?>
<?php }elseif($shipping_address){?>
<div class="map" id="map_canvas" style="width:400px; height:410px;margin-left:0px;"><iframe src="http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=<?php echo $shipping_address;?>&ie=UTF8&z=14&iwloc=A&output=embed" height="400" width="410"></iframe></div>
<?php }
}?></center><?php } else {
	echo '<script>location.href="'.site_url().'/index.php?ptype=login"</script>';
		exit;
}?>
	</div>
</div>
</body>
</html>