<div id="wrapper">

 <h3><?php echo DETAIL_REPORT_TITLE; ?></h3>
 <div id="page" >
<script>var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dhtmlgoodies_calendar.js"></script>
<link href="<?php bloginfo('template_directory'); ?>/library/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />

<?php
global $Cart,$General,$wpdb,$prd_db_table_name,$transection_db_table_name;
?>
<?php
$user_id = $_REQUEST['user_id'];
$affsql = "select count(trans_id) as oid_count, payable_amt as order_total, sum((payable_amt*aff_commission)/100) as earn_total from $transection_db_table_name where aff_uid=\"$user_id\" and status='1'";
$aff_total_res = $wpdb->get_results($affsql);
$user_name = $wpdb->get_var("select u.user_login from $wpdb->users u where u.ID=\"$user_id\"");
?>
<table width="100%"  class="widefat post" >
<thead>

<tr><td colspan="8"><h3><?php echo $user_name; _e("'s Affiliate Detail Report"); ?></h3></td></tr>
<tr>
<td><?php echo NO_OF_ORDER_TITLE; ?> </td>
<th><?php echo  $aff_total_res[0]->oid_count;?> </th>
<td><?php echo TOTAL_SALE_TITLE; ?> </td>
<th><?php echo  number_format($aff_total_res[0]->order_total,2);?> </th>
<td><?php echo TOTAL_EARN_TITLE; ?> </td>
<th><?php echo number_format($aff_total_res[0]->earn_total,2);?> </th>
</tr>

</thead>

</table>
<form action="" method="post" name="frm_srch">
 <?php echo SEARCH_BY_TITLE;?> : 
     <?php _e('Date From','templatic');?>  <input type="text" name="srch_st_date"  id="srch_st_date"  value="<?php echo $_REQUEST['srch_st_date']; ?>" size="10"/>
    &nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal.png" alt="Calendar" onclick="displayCalendar(document.frm_srch.srch_st_date,'yyyy-mm-dd',this)" style="cursor: pointer;" align="absmiddle" border="0">
    <?php _e('To');?> <input type="text" name="srch_end_date"  id="srch_end_date"  value="<?php echo $_REQUEST['srch_end_date']; ?>" size="10"/>
    &nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal.png" alt="Calendar" onclick="displayCalendar(document.frm_srch.srch_end_date,'yyyy-mm-dd',this)" style="cursor: pointer;" align="absmiddle" border="0">
     <input type="submit" name="submit" value="<?php _e('Search');?>" class="highlight_input_btn" />
      <input type="button" name="default" onclick="window.location.href='<?php echo site_url();?>/wp-admin/admin.php?page=affiliate_report&user_id=<?php echo $userId;?>'" value="<?php _e('Default');?>" class="highlight_input_btn" />
     <?php
     $params = '';
	 if($_REQUEST['srch_st_date'] != '' && $_REQUEST['srch_end_date'] =='')
	 {
	 	$params = "&srch_st_date=".$_REQUEST['srch_st_date'];
	 }else
	 if($_REQUEST['srch_st_date'] == '' && $_REQUEST['srch_end_date']!='')
	 {
	 	$params = "&srch_end_date=".$_REQUEST['srch_end_date'];
	 }else
	  if($_REQUEST['srch_st_date'] != '' && $_REQUEST['srch_st_date'] != '')
	 {
	 	$params = "&srch_st_date=".$_REQUEST['srch_st_date']."&srch_end_date=".$_REQUEST['srch_end_date'];
	 }
	 ?>
 <a href="<?php echo site_url();?>/?ptype=account&report_export=1&user_id=<?php echo $_REQUEST['user_id'];?><?php echo $params?>" target="_blank"><?php _e('Export to Excel');?></a>
 </form>
<br />
<?php
if($_REQUEST['user_id'])
{
	$user_id = $_REQUEST['user_id'];
	?>
	<table width="100%"  class="widefat post fixed">
	  <thead>
		 <tr>
			<th class="title"><?php echo DATE_TITLE; ?> </th>
			<th class="title"><?php echo ORDER_ID; ?> </th>
			<th class="title"><?php echo PAYMENT_STATUS_TITLE; ?> </th>
			<th class="title"><?php echo COMMITION_TITLE; ?> </th>
            <th class="title"><?php echo ORDER_AMOUNT_TITLE; ?> </th>
			<th class="title"><?php echo AFFLIATE_SHARE_HEAD; ?> </th>
		</tr>
<?php
$user_id = $_REQUEST['user_id'];
$affsql = "select * from $transection_db_table_name where aff_uid=\"$user_id\" and status='1'";
if($_REQUEST['srch_st_date'] && $_REQUEST['srch_end_date'])
{
	$srch_st_date = $_REQUEST['srch_st_date'];
	$srch_end_date = $_REQUEST['srch_end_date'];
	$affsql .= " and date_format(payment_date,'%Y-%m-%d') between \"$srch_st_date\" and \"$srch_end_date\"";
}
$aff_res = $wpdb->get_results($affsql);
if($aff_res)
{
	$share_total = 0;
	foreach($aff_res as $aff_res_obj)
	{
		$order_amt = $aff_res_obj->payable_amt;
		$aff_amt = ($order_amt*$aff_res_obj->aff_commission)/100;
		$share_total += $aff_amt;
	?>
		 <tr>
			<td class="row1" ><?php echo date('Y-m-d',strtotime($aff_res_obj->payment_date));?></td>
			<td class="row1" ><?php echo $aff_res_obj->trans_id;?></td>
			<td class="row1" ><?php 
			if($aff_res_obj->status == '1'){ echo "<span class='color_active'>Approve</span>"; 
			}else if($aff_res_obj->status == '0'){  
			echo "<span class='color_pending'>Pending</span>"; } ?></td>
			<td class="row1" ><?php echo $aff_res_obj->aff_commission;?></td>
            <td class="row1" ><?php echo $order_amt." ".get_option('ptttheme_currency_symbol');?></td>
			<td class="row1" ><?php echo $aff_amt." ".get_option('ptttheme_currency_symbol');?></td>
		</tr>   
		<?php
	}
?>
<tr><td colspan="4">&nbsp;</td><th><?php echo TOTAL_EARN_TITLE;?></th><th><?php echo $share_total." ".get_option('ptttheme_currency_symbol');?></th></tr>
<?php
}else
{
?>
<tr><td colspan="6"><h4><?php echo NO_RECORD_MSG;?></h4></td></tr>
<?php
}
}
?>  </thead>
</table>
</div> <!-- page #end -->
 </div>   <!-- wrapper #end -->