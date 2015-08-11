<table width="100%"  border="1">
	  <thead>
		 <tr>
			<th class="title"><?php _e('Date'); ?> </th>
			<th class="title"><?php _e('Order ID'); ?> </th>
			<th class="title"><?php _e('Payment Status'); ?> </th>
			<th class="title"><?php _e('Comission(%)'); ?> </th>
			<th class="title"><?php _e('Currency'); ?> </th>
            <th class="title"><?php _e('Amount'); ?> </th>
			<th class="title"><?php _e('Affiliate Share'); ?> </th>
		</tr>
<?php
$user_id = $_REQUEST['user_id'];
$affsql = "select * from $transection_db_table_name where aff_uid=\"$user_id\" and ostatus='approve'";
if($_REQUEST['srch_st_date'] && $_REQUEST['srch_end_date'])
{
	$srch_st_date = $_REQUEST['srch_st_date'];
	$srch_end_date = $_REQUEST['srch_end_date'];
	$affsql .= " and date_format(ord_date,'%Y-%m-%d') between \"$srch_st_date\" and \"$srch_end_date\"";
}
$aff_res = $wpdb->get_results($affsql);
if($aff_res)
{
	$share_total = 0;
	foreach($aff_res as $aff_res_obj)
	{
		$order_amt = $aff_res_obj->cart_amount-$aff_res_obj->discount_amt;
		$aff_amt = ($order_amt*$aff_res_obj->aff_commission)/100;
		$share_total += $aff_amt;
	?>
		 <tr>
			<td class="row1" ><?php echo date('Y-m-d',strtotime($aff_res_obj->ord_date));?></td>
			<td class="row1" ><?php echo $aff_res_obj->oid;?></td>
			<td class="row1" ><?php echo $aff_res_obj->ostatus;?></td>
			<td class="row1" ><?php echo $aff_res_obj->aff_commission;?></td>
			<td class="row1" ><?php echo $aff_res_obj->currency_code;?></td>
            <td class="row1" ><?php echo $General->get_amount_format($order_amt,0);?></td>
			<td class="row1" ><?php echo $General->get_amount_format($aff_amt,0);?></td>
		</tr>   
		<?php
	}
?>
<tr><td colspan="5">&nbsp;</td><th><?php _e('Total Earn : ');?> </th><th><?php echo $General->get_amount_format($share_total,0);?></th></tr>
<?php
}else
{
?>
<tr><td colspan="7"><h4><?php _e('No record available');?></h4></td></tr>
<?php
}
?>  </thead>
</table>
