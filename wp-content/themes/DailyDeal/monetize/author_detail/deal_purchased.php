<h2><a href="#?totaldeal=1"><?php echo DEAL_PURCHASE; ?></a></h2>	

			<?php $transactiondeal = $wpdb->get_results("select * from $transaction_table where user_id = '".$curauth->ID."' and status = '1' order by payment_date DESC");
			if($transactiondeal){
				echo '<table class="purchase_table">
					<tr>
						<td class="td_title" style="width:300px;">'.DEAL_TITLE_TEXT.'</td>								
						<td class="td_title" style="width:100px;">'.COUPON_NO.'</td>
						<td class="td_title" style="width:200px;">'.EXPIRES.'</td>
						<td class="td_title" style="width:200px;"></td>';
						 
					echo '</tr>';
				foreach($transactiondeal as $transactiondeal_obj){ 
				$did = $transactiondeal_obj->post_id;
						$min_purchase = get_post_meta($did,'min_purchases',true);
						global $wpdb;
						$trans_tbl = $wpdb->prefix."deal_transaction";
						$trnsfordeal = mysql_query("select * from $trans_tbl where post_id = '".$did."'");
						$tpid = mysql_affected_rows(); ?>	
					<tr class="row">
						<td><a href="#" onclick="viewtransaction(<?php echo $UID ;?>,<?php echo $transactiondeal_obj->post_id;?>)" title="<?php echo $transactiondeal_obj->post_title;?>"><?php echo $transactiondeal_obj->post_title;?></a></td>						
                        <td><?php if($min_purchase <= $tpid )
								{ 
									echo $transactiondeal_obj->deal_coupon; 
								}
								else
								{
									_e(MIN_MSG,'templatic');
								} ?>
						</td>
						<td><?php if(get_post_meta($transactiondeal_obj->post_id,'coupon_end_date_time',true)) {echo date('d F, Y H:i:s',get_post_meta($transactiondeal_obj->post_id,'coupon_end_date_time',true)); } else { echo CONTINUE_DEAL;} ?></td>	
						<td><?php 
						
						
							if(get_post_meta($transactiondeal_obj->post_id,'coupon_type',true) == '2' && get_post_meta($transactiondeal_obj->post_id,'_wp_attached_file',true) != ''){

							if($min_purchase <= $tpid )
							{
								echo '<a href="'.get_post_meta($transactiondeal_obj->post_id,'_wp_attached_file',true).'" class="i_download" title="'.DOWNLOAD.'">'.DOWNLOAD.'</a> | ';

								}else{
									_e(MIN_MSG,'templatic');
								}
							}
						
						if($min_purchase <= $tpid )
						{						
						?>
						
						<a href="?ptype=voucher&amp;transaction_id=<?php echo $transactiondeal_obj->trans_id;?>" title="<?php echo PRINT_TEXT;?>" target="_blank" class="i_print"><?php echo PRINT_TEXT;?></a></td>	<?php }else{ 
						_e(MIN_MSG,'templatic'); } ?>
					</tr>
		<?php 	} 
		echo '</table>'; ?>
		<div class="notes"><p class="min_notes"><span class="error">(*)</span><?php _e(MINSALES_NOTES,'templatic');?></p></div>
		<?php
			} else {
				echo '<center><h4>'.NO_DEAL_PURCHASED.'</h4></center>';
			}?>	