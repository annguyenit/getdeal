<script>var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dhtmlgoodies_calendar.js"></script>
<link href="<?php bloginfo('template_directory'); ?>/library/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />
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
global $Cart,$wpdb,$prd_db_table_name,$ord_db_table_name;

//print_r($General);
?>
<br />
<h2><?php echo AFFLIATE_SHARE_HEAD; ?></h2>
<?php
if($_REQUEST['srch_st_date'] == '' && $_REQUEST['srch_end_date'] =='')
{
	$_REQUEST['srch_st_date'] = date('Y-m-').'01';
	$num = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')) ;
	$_REQUEST['srch_end_date'] = date('Y-m-').$num;
}
?>
    <form action="#option_sale_report" method="post" name="frm_srch">
 		<span><?php echo SEARCH_BY_TEXT;?> : <?php echo DATE_FROM;?></span>
 		<span><input type="text" name="srch_st_date"  id="srch_st_date"  value="<?php echo $_REQUEST['srch_st_date']; ?>" size="10" /></span>
 		<span><img src="<?php echo bloginfo('template_directory');?>/images/cal.png" alt="Calendar" onclick="displayCalendar(document.frm_srch.srch_st_date,'yyyy-mm-dd',this)" style="cursor: pointer;" align="absmiddle" border="0" /></span>
 		<span><?php _e('To');?></span>
 		<span><input type="text" name="srch_end_date"  id="srch_end_date"  value="<?php echo $_REQUEST['srch_end_date']; ?>" size="10" /></span>
 		<span><img src="<?php echo bloginfo('template_directory');?>/images/cal.png" alt="Calendar" onclick="displayCalendar(document.frm_srch.srch_end_date,'yyyy-mm-dd',this)" style="cursor: pointer;" align="absmiddle" border="0" /></span>
 		<span><input type="submit" name="submit" value="<?php echo SEARCH_TEXT;?>" class="highlight_input_btn" /></span>
 		<span><input type="button" name="default" onclick="window.location.href='<?php echo site_url();?>/wp-admin/admin.php?page=affiliates'" value="<?php _e('Default');?>" class="highlight_input_btn" /></span>  

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
    
 </form>
 <br />
    <table width="100%"  class="widefat post fixed">
      <thead>
         <tr>
            <th class="title" width="100"><?php echo ORDER_ID; ?> </th>
            <th class="title" width="100"><?php echo ORDER_DATE_TITLE; ?> </th>
            <th class="title"><?php echo AFFLIATE_NAME_TITLE; ?> </th>
            <!--<th class="title"><?php //echo TOTAL_ORDER_TITLE; echo ' ('. $General->get_currency_code().')'; ?> </th>-->
            <th class="title"><?php echo COMMITION_TITLE;?> </th>
            <!--<th class="title"><?php //echo SHARE_TOTAL_TITLE; echo ' ('.$General->get_currency_code().')'; ?> </th>-->
        </tr>
        <?php
		if($_REQUEST['srch_st_date'] == '' && $_REQUEST['srch_end_date'] =='')
		{
			$_REQUEST['srch_st_date'] = date('Y-m-').'1';
			$num = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')) ;
			$_REQUEST['srch_end_date'] = date('Y-m-').$num;
		}
		global $transection_db_table_name;
		$affsql = "select trans_id,aff_uid,aff_commission,payable_amt,payment_date,(select u.user_login from $wpdb->users u where u.ID=aff_uid) as aff_name from $transection_db_table_name where aff_uid>0 and status='1'";
		
		if($_REQUEST['srch_st_date'] && $_REQUEST['srch_end_date'])
		{
			$srch_st_date = $_REQUEST['srch_st_date'];
			$srch_end_date = $_REQUEST['srch_end_date'];
			$affsql .= " and date_format(payment_date,'%Y-%m-%d') between \"$srch_st_date\" and \"$srch_end_date\"";
		}
		//echo $affsql;
		$affres = $wpdb->get_results($affsql);
		if($affres)
		{
			$order_total_amt = 0;
			$share_total = 0;
			foreach($affres as $userinfoObj)
			{
				$order_total = $userinfoObj->payable_amt-$userinfoObj->discount_amt;
				$aff_comm = $userinfoObj->aff_commission;
				$comission_amt = ($order_total*$aff_comm)/100;
				$share_total += $comission_amt;
				$order_total_amt += $order_total;
			  ?>
			<tr>
				<td class="row1" ><a href="<?php echo site_url();?>/wp-admin/admin.php?page=affiliates&amp;oid=<?php echo $userinfoObj->trans_id;?>#option_orders"><?php echo $userinfoObj->trans_id;?></a></td>
                <td class="row1" ><?php echo date('Y-m-d',strtotime($userinfoObj->payment_date));?></td>
                <td class="row1" ><a href="<?php echo site_url();?>/wp-admin/admin.php?page=affiliates&amp;user_id=<?php echo $userinfoObj->aff_uid;?>option_members"><?php echo $userinfoObj->aff_name;?></a></td>
              	<!--<td class="row1" ><?php //echo $General->get_amount_format($order_total,0);?></td>-->
				<td class="row1" ><?php echo $userinfoObj->aff_commission;?></td>
				<!--<td class="row1" ><?php //echo $General->get_amount_format($comission_amt,0);?></td>-->
			</tr>   
			<?php
			}
			?>
            <tr>
				<td class="row1" >&nbsp;</td>
                <td class="row1" >&nbsp;</td>
                <td class="row1" align="left"><?php echo TOTAL_SALE_TITLE; ?><strong><?php echo $order_total_amt." ".get_option('ptttheme_currency_symbol'); ?></strong></td>
				<td class="row1" align="left"><?php echo TOTAL_EARN_TITLE; ?><strong><?php echo $share_total." ".get_option('ptttheme_currency_symbol'); ?></strong></td>
				
			</tr>
            <?php
		}else
		{
        ?>
        <tr><td colspan="4" align="center"><?php echo NO_AFFILIATE_NOTE;?> </td></tr>
        <?php }?>
        </thead>
    </table>