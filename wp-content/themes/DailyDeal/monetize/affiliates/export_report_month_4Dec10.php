<table width="100%" border="1">
      <thead>
         <tr>
            <th class="title"><?php _e('Ord ID'); ?> </th>
             <th class="title"><?php _e('Ord Date'); ?> </th>
            <th class="title"><?php _e('Affilate Name'); ?> </th>
            <th class="title"><?php _e('Ord Total'); echo ' ('. $General->get_currency_code().')'; ?> </th>
            <th class="title"><?php _e('Comission (%)');?> </th>
            <th class="title"><?php _e('Share Total'); echo ' ('.$General->get_currency_code().')'; ?> </th>
        </tr>
        <?php
		if($_REQUEST['srch_st_date'] == '' && $_REQUEST['srch_end_date'] =='')
		{
			$_REQUEST['srch_st_date'] = date('Y-m-').'1';
			$num = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')) ;
			$_REQUEST['srch_end_date'] = date('Y-m-').$num;
		}
		$affsql = "select oid,aff_uid,aff_commission,cart_amount,discount_amt,ord_date,(select u.user_login from $wpdb->users u where u.ID=aff_uid) as aff_name from $ord_db_table_name where aff_uid>0 and ostatus='approve'";
		if($_REQUEST['srch_st_date'] && $_REQUEST['srch_end_date'])
		{
			$srch_st_date = $_REQUEST['srch_st_date'];
			$srch_end_date = $_REQUEST['srch_end_date'];
			$affsql .= " and date_format(ord_date,'%Y-%m-%d') between \"$srch_st_date\" and \"$srch_end_date\"";
		}
		$affres = $wpdb->get_results($affsql);
		if($affres)
		{
			$order_total_amt = 0;
			$share_total = 0;
			foreach($affres as $userinfoObj)
			{
				$order_total = $userinfoObj->cart_amount-$userinfoObj->discount_amt;
				$aff_comm = $userinfoObj->aff_commission;
				$comission_amt = ($order_total*$aff_comm)/100;
				$share_total += $comission_amt;
				$order_total_amt += $order_total;
			  ?>
			<tr>
				<td class="row1" ><a href="<?php echo site_url();?>/wp-admin/admin.php?page=manageorders&amp;oid=<?php echo $userinfoObj->oid;?>"><?php echo $userinfoObj->oid;?></a></td>
                 <td class="row1" ><?php echo date('Y-m-d',strtotime($userinfoObj->ord_date));?></td>
                <td class="row1" ><a href="<?php echo site_url();?>/wp-admin/admin.php?page=affiliates&amp;user_id=<?php echo $userinfoObj->aff_uid;?>"><?php echo $userinfoObj->aff_name;?></a></td>
              	<td class="row1" ><?php echo $General->get_amount_format($order_total,0);?></td>
				<td class="row1" ><?php echo $userinfoObj->aff_commission;?></td>
				<td class="row1" ><?php echo $General->get_amount_format($comission_amt,0);?></td>
			</tr>   
			<?php
			}
			?>
            <tr>
				<td class="row1" >&nbsp;</td>
                <td class="row1" >&nbsp;</td>
                <td class="row1" align="right"><strong><?php _e('Total : ');?></strong></td>
                <td class="row1" ><strong><?php echo $General->get_amount_format($order_total_amt,0);?></strong></td>
				<td class="row1" align="right"><strong><?php _e('Total : ');?></strong></td>
				<td class="row1" ><strong><?php echo $General->get_amount_format($share_total,0);?></strong></td>
			</tr>  
            <?php
		}else
		{
        ?>
        <tr><td colspan="6" align="center"><?php _e('No affiliates share available.');?> </td></tr>
        <?php }?>
        </thead>
    </table>