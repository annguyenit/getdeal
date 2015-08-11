<style>
h2 {
	color:#464646;
	font-family:Georgia, "Times New Roman", "Bitstream Charter", Times, serif;
	font-size:24px;
	font-size-adjust:none;
	font-stretch:normal;
	font-style:italic;
	font-variant:normal;
	font-weight:normal;
	line-height:35px;
	margin:0;
	padding:14px 15px 3px 0;
	text-shadow:0 1px 0 #FFFFFF;
}
</style>
<?php
global $General;
if($_REQUEST['user_id'])
{
	include_once(TEMPLATEPATH . '/monetize/affiliates/admin_affiliate_sale_report_detail.php');
}else
{
	?>
    <br />
	<h2><?php _e(AFF_MEMBERS_PAGE_TITLE,'templatic'); ?></h2>
	<?php
	global $wpdb;
	$targetpage = site_url().'/wp-admin/admin.php?page=affiliate_report';
	$recordsperpage = 30;
	$pagination = $_REQUEST['pagination'];
	$total_pages = $wpdb->get_var("SELECT COUNT(u.ID) FROM $wpdb->users u,$wpdb->usermeta um WHERE um.user_id=u.ID and um.meta_key='wp_capabilities' and um.meta_value like \"%affiliate%\"");
	if($pagination == '')
	{
		$pagination = 1;
	}
	$strtlimit = ($pagination-1)*$recordsperpage;
	$endlimit = $strtlimit+$recordsperpage;
	
	$usersql = "select u.ID,u.user_login from $wpdb->users u ,$wpdb->usermeta um WHERE um.user_id=u.ID and um.meta_key='wp_capabilities' and um.meta_value like \"%affiliate%\" order by user_login";
    $userinfo = $wpdb->get_results($usersql);
	if($userinfo)
	{
		?>
		<table width="100%"  class="widefat post fixed" >
		  <thead>
			 <tr>
				<th class="title"><?php _e(AFF_USER_NAME_TEXT,'templatic'); ?> </th>
				<th class="title"><?php _e(AFF_TOTAL_SALES_AMOUNT_TEXT,'templatic'); ?> </th>
				<th class="title"><?php _e(AFF_TOTAL_SHARE_AMT_TEXT,'templatic'); ?> </th>
			</tr>
			<?php
			foreach($userinfo as $userinfoObj)
			{
				global $transection_db_table_name;
				$affsql = "select trans_id,aff_uid,aff_commission,payable_amt,ord_date,(select u.user_login from $wpdb->users u where u.ID=aff_uid) as aff_name from $transection_db_table_name where aff_uid>0 and status='1' and aff_uid  =".$userinfoObj->ID;
				$affres = $wpdb->get_results($affsql);
			
					$order_total_amt = 0;
					$share_total = 0;
					foreach($affres as $userinfoObj1)
					{
						$order_total = $userinfoObj1->payable_amt-$userinfoObj1->discount_amt;
						$aff_comm = $userinfoObj1->aff_commission;
						$comission_amt = ($order_total*$aff_comm)/100;
						$share_total += $comission_amt;
						$order_total_amt += $order_total;
					}
						$user_role = get_usermeta($userinfoObj->ID,'wp_capabilities');
						if($user_role['affiliate'])
						{
							$total_amt_array = get_total_share_amt($userinfoObj->ID);
							?>
							<tr>
								<td class="row1" ><a href="<?php echo site_url();?>/wp-admin/admin.php?page=affiliates&user_id=<?php echo $userinfoObj->ID;?>"><?php echo $userinfoObj->user_login;?></a>
								(<?php _e('paypal ID:');?><?php echo get_user_meta($userinfoObj->ID,'affiliate_payment_account',true);?>)
								</td>
								<td class="row1" ><?php  echo $order_total_amt." ".get_option('ptttheme_currency_symbol'); ?></td>
								<td class="row1" ><?php echo $share_total." ".get_option('ptttheme_currency_symbol'); ?></td>
							</tr>   
							<?php
						}
			
			}
			?>
            <tr><td colspan="3" align="center">
            <?php
            if($total_pages>$recordsperpage)
			{
			echo $General->get_pagination($targetpage,$total_pages,$recordsperpage,$pagination);
			}
			?>
            </td></tr>
			</thead>
		</table>
	<?php
	}
}

function get_total_share_amt($user_id)
{
	$user_affiliate_data = get_usermeta($user_id,'user_affiliate_data');
	if($user_affiliate_data)
	{
		$order_amt_total = 0;
		$share_total = 0;
		$total_orders = 0;
		$product_qty = 0;
		foreach($user_affiliate_data as $key => $val)
		{
			$order_user_id = preg_replace('/(([_])[0-9]*)/','',$val['orderNumber']);
			$order_number = preg_replace('/([0-9]*([_]))/','',$val['orderNumber']);
			if(!is_array(get_usermeta($order_user_id,'user_order_info')))
			{
				$user_order_info = unserialize(get_usermeta($order_user_id,'user_order_info'));
			}else
			{
				$user_order_info = get_usermeta($order_user_id,'user_order_info');
			}
			$order_info1 = $user_order_info[$order_number-1][0];
			$cart_info = $order_info1['cart_info']['cart_info'];
			$order_info = $order_info1['order_info'];
			if($order_info['order_status'] == 'approve')
			{
				$total_orders++;
				$share_amt = ($val['order_amt']*$val['share_amt'])/100;
				$share_total = $share_total + $share_amt; 
				$order_amt_total = $order_amt_total + $val['order_amt'];
				for($c=0;$c<count($cart_info);$c++)
				{
					$product_qty = $product_qty + $cart_info[$c]['product_qty'];
				}
			}
		}
	}
	return array($share_total,$order_amt_total,$total_orders,$product_qty);
}
?>