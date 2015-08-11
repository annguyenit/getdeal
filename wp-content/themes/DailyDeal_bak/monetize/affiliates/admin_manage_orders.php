<?php
global $wpdb,$transection_db_table_name;		
if($_POST['submitact']=='delete')
{
	if($_POST['list'])
	{
		$list_str = implode(',',$_POST['list']);
	}
	$delete_prd = "delete from $transection_db_table_name where trans_id in ($list_str)";
	$wpdb->query($delete_prd);
	$delete_ord = "delete from $transection_db_table_name where trans_id in ($list_str)";
	$wpdb->query($delete_ord);
	wp_redirect(site_url("/wp-admin/admin.php?page=affiliates&msg=delete#option_orders"));
}elseif($_POST['submitact']=='change_status')
{
	if($_POST['list'])
	{
		$list_str = implode(',',$_POST['list']);
	}
	$order_status = $_REQUEST['order_status'];	
	for($i=0; $i < sizeof($_POST['list']); $i++ ){
	$trans_id = $_POST['list'][$i];
		// Send Mail BOF
	$issendEmail = 0;
	if($orderinfoObj->status != $order_status)
	{
		$issendEmail = 1;
	}
	
	$issendEmail = 1;
	$wpdb->query("update $transection_db_table_name set status='".$order_status."' where trans_id='".$trans_id."'");
	$display_message = "Order updated successfully.";
	if($issendEmail)
	{
		
		$ordersql = "select * from $transection_db_table_name where trans_id='".$trans_id."'";
		$orderinfo = $wpdb->get_results($ordersql);
		if($orderinfo)
		{
			foreach($orderinfo as $orderinfoObj)
			{
			}
		}
		
		$fromEmail = get_option('admin_email');
		$fromEmailName = get_option('template');
		
		$subject_default = "Order ".$order_status ." Email, Order Number:#".$trans_id;
		$message = "";
		global $wpdb,$transection_db_table_name;
		
		$user_info = "select u.user_email,u.display_name from $wpdb->users u join $transection_db_table_name ot on ot.uid=u.ID and ot.trans_id=\"$trans_id\"";
		$user_info_arr = $wpdb->get_results($user_info);
		if($user_info_arr)
		{
			$toEmailName = $user_info_arr[0]->display_name;
			$toEmail = $user_info_arr[0]->user_email;
		}
		///////////admin email//////////
		if($order_status=='approve')
		{
			$subject = get_option('order_approval_client_email_subject');
			$admin_message = get_option('order_approval_client_email_content');
		}elseif($order_status=='shipping')
		{
			$subject = get_option('order_shipping_client_email_subject');
			$admin_message = get_option('order_shipping_client_email_content');
		}elseif($order_status=='delivered')
		{
			$subject = get_option('order_shipping_client_email_subject');
			$admin_message = get_option('order_shipping_client_email_content');
		}elseif($order_status=='reject')
		{
			$subject = get_option('order_rejection_client_email_subject');
			$admin_message = get_option('order_rejection_client_email_content');
		}
		$order_info = get_order_detailinfo_tableformat($trans_id);
		$store_name = $fromEmailName;
		$search_array = array('[#$user_name#]','[#$to_name#]','[#$order_info#]','[#$store_name#]');
		$replace_array = array($orderinfoObj->billing_name,$orderinfoObj->billing_name,$order_info,$store_name);
		$client_message = apply_filters('order_approved_admin_email_content_filter',str_replace($search_array,$replace_array,$admin_message));
		if($order_status=='1'){
			templ_sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$client_message,$extra='');///approve/reject email			
		}else
		if($order_status=='3' && $General->is_send_order_reject_email_wpadmin())
		{
			templ_sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$client_message,$extra='');///approve/reject email	
		}
				
		///AFFILIATE START//
		if(get_option('is_active_affiliate'))
		{
			if($order_status=='1')  // send affiliate email
			{
				$aid = $orderinfoObj->aff_uid;
				if($aid)
				{
					$usersql = "SELECT user_nicename,user_email FROM $wpdb->users WHERE ID=\"$aid\"";
					$userinfo = $wpdb->get_results($usersql);
					$toEmailName = $userinfo[0]->user_nicename;
					$toEmail = $userinfo[0]->user_email;
					$user_affiliate_data = get_usermeta($aid,'user_affiliate_data');
					$cart_amt = str_replace(',','',$orderinfoObj->payable_amt);
					if($user_affiliate_data)
					foreach($user_affiliate_data as $key => $val)
					{
						$share_amt = ($cart_amt*$val['share_amt'])/100;
					}			
					
					$product_name = $wpdb->get_var("select group_concat(p.post_title) from $wpdb->posts p join $transection_db_table_name op on op.post_id=p.ID where op.trans_id='".$trans_id."'");
					$product_qty = $wpdb->get_var("select sum(prd_qty) from $wpdb->posts where trans_id='".$trans_id."'");
					
					$subject = __('Your Affiliate Sale');
					$aff_message = __('
					<p>Dear '.$toEmailName.',</p>
					<p>
					New sale has been made by your affiliate link and<br />
					commission credited to your balance.<br />
					</p>
					<p>
					You may find sale details below:
					</p>
					<p>----</p>
					<p>Transaction Id : '.$orderinfoObj->trans_id.'</p>
					<p>Order Amount :       '.$orderinfoObj->payable_amt." ".get_option('currency_sym').'</p>
					<p>Qty :       '.$product_qty.'</p>
					<p>Product ordered: '.$product_name.'</p>
					<p>Your commission: '.$share_amt." ".get_option('currency_sym').'</p>
					<p>----</p>
					');
					templ_sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$aff_message,$extra='');///To affiliate email
				}
			}
		}
		///AFFILIATE END///	
	}
	// Send Mail EOF
	}
	wp_redirect(site_url("/wp-admin/admin.php?page=affiliates&msg=statusupdate#option_orders"));
}
?>
<div id="wrapper">
<div id="page" > 
<script>
	function checkAll(field)
	{
	for (i = 0; i < field.length; i++)
		field[i].checked = true ;
	}
	
	function uncheckAll(field)
	{
	for (i = 0; i < field.length; i++)
		field[i].checked = false ;
	}
	
	function selectCheckBox()
	{
		field = document.getElementsByName('list[]');
		var i;
		ch	= document.getElementById('check');
		if(ch.checked)
		{
			checkAll(field);
		}
		else
		{
			uncheckAll(field);
		}
	}
	
	function recordAction(ordstst)
	{
		var chklength = document.getElementsByName("list[]").length;
		var flag      = false;
		var temp	  ='';
		for(i=1;i<=chklength;i++)
		{
		   temp = document.getElementById("check_"+i+"").checked; 
		   if(temp == true)
		   {
		   		flag = true;
				break;
			}
		}
		
		if(ordstst=='delete')
		{
			var order_act = 'delete';
			var msg1 = '<?php _e('Please select atleast one record to delete.')?>';
			var msg2 = '<?php _e('Are you sure want to continue?');?>';
		}else //status 
		{
			if(document.getElementById("order_status").value=='')
			{
				alert('<?php _e('Select Status to set');?>');
				document.getElementById("order_status").focus();
				return false;
			}else
			{
				document.getElementById("submitact").value = 'change_status';
				var order_act = document.getElementById("order_status").value;
				var msg1 = '<?php _e('Please select atleast one record to ')?>'+order_act;
				var msg2 = '<?php _e('Are you sure want to continue?');?>';
			}
		}
		if(flag == false)
		{
			alert(msg1);
			return false;
		}
		
		if(!confirm(msg2))
		{
		 return false;
		}
		return true;
	
	} 
</script>
<?php 
if($_REQUEST['msg']=='delete')
{
	$message= DELETED_SUC_MSG;
}elseif($_REQUEST['msg']=='statusupdate')
{
	$message= UPDATED_STATUS_SUC_MSG;
}
if($message){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e($message,'templatic');?> </p>
</div>
<?php }?>
<table width="100%">
  <tr>
    <td>
    <form method="post" action="<?php echo site_url('/wp-admin/admin.php?page=affiliates#option_orders');?>" name="ordersearch_frm">
        <table>
		<tr>
            <td valign="top"><strong>
              <?php echo SEARCH_SIMPLE_TEXT; ?> 
              :</strong></td>
            <td valign="top">&nbsp;</td>
            <td width="25" valign="top">&nbsp;</td>
            <td colspan="2" valign="top"><strong>
              <?php echo ORDER_STATUS_TEXT; ?> 
              :</strong></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><?php if ($_REQUEST['srch_orderno']){
			$srch_orderno=$_REQUEST['srch_orderno']; }else
			{
				$srch_orderno = 'order number';
			} ?>
              <input type="text" value="<?php echo $srch_orderno;?>" name="srch_orderno" id="srch_orderno" onblur="if(this.value=='') this.value = '<?php _e('order number');?>';" onfocus="if(this.value=='<?php _e('order number');?>') this.value= '';"   /><br /></td>
            <td valign="top"><?php
			global $wpdb;
				$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_%' order by option_id";
				$paymentinfo = $wpdb->get_results($paymentsql);
				if($paymentinfo)
				{
					foreach($paymentinfo as $paymentinfoObj)
					{
						$paymentInfo = unserialize($paymentinfoObj->option_value);
						$paymethodKeyarray[$paymentInfo['key']] = $paymentInfo['key'];
						ksort($paymethodKeyarray);
					}
				} ?>
              <select name="srch_payment"  style="width:115px">
                <option value=""> <?php echo SELECT_PAYMENT_TEXT; ?> </option>
                <?php
				foreach($paymethodKeyarray as $key=>$value)
				{
					if($value)
					{
				?>
                <option value="<?php echo $value;?>" <?php if($value==$_REQUEST['srch_payment']){?> selected<?php }?>><?php echo $value;?></option>
                <?php }}?>
              </select></td>
				<td valign="top">&nbsp;</td>
				<td valign="top"> 
              <select name="srch_status" style="width:70px">
                <option value=""> <?php echo SELECT_STATUS_TEXT;?> </option>
                    <option value="0" <?php if($_REQUEST['srch_status']=='0'){?> selected<?php }?>><?php echo ORDER_PROCESSING_TEXT;?></option>
                    <option value="1" <?php if($_REQUEST['srch_status']=='1'){?> selected<?php }?>><?php echo ORDER_APPROVE_TEXT;?></option>
                    <option value="2" <?php if($_REQUEST['srch_status']=='2'){?> selected<?php }?>><?php echo ORDER_REJECT_TEXT;?></option>
              </select></td>
			  <td valign="top">&nbsp;&nbsp;
              <input type="submit" name="Search" value="<?php echo SEARCH_SIMPLE_TEXT; ?>" class="button-secondary action" onclick="chkfrm();" />
              &nbsp;
              <script type="text/javascript">
				function chkfrm()
				{
					if(document.getElementById('srch_orderno').value=='order number')
					{
						document.getElementById('srch_orderno').value = '';
					}
				}
			 </script>
            </td>
            <td valign="top"><input type="button" name="Default" value="<?php echo LIST_ALL_ORDERS_TEXT; ?>" onclick="window.location.href='<?php echo site_url('/wp-admin/admin.php?page=affiliates#option_orders');?>'" class="button-secondary action" /></td>
          </tr>
          <tr>
            <td colspan="7">&nbsp;</td>
          </tr>
          <tr><td colspan="7"><small><?php _e('<u><b>Note</b></u> : you can search multiple orders by enter "Order Number"  comma seperated. example : 1,2,3,4');?></small></td></tr>
          <tr>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
            <td height="2" valign="top"></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr>
    <td><?php
global $current_user,$transection_db_table_name;
$current_user_ID = $current_user->ID;
$targetpage = site_url('/wp-admin/admin.php?page=affiliates#option_orders');
$recordsperpage = 30;
$pagination = $_REQUEST['pagination'];
if($pagination == '')
{
	$pagination = 1;
}
$strtlimit = ($pagination-1)*$recordsperpage;
$endlimit = $strtlimit+$recordsperpage;
$orderCount = 0;
//----------------------------------------------------
$ordersql_select = "select u.ID,u.display_name ,o.* ";
$ordersql_count = "select count(o.trans_id) ";
$ordersql_from = " from $transection_db_table_name as o join $wpdb->users u on u.ID=o.user_id";
$ordersql_conditions= " where 1 ";
if($_REQUEST['user_id'])
{
	$user_id = $_REQUEST['user_id'];	
	$ordersql_conditions .= " and u.ID=\"$user_id\"";
}
if($_REQUEST['srch_orderno'])
{
	$srch_orderno = $_REQUEST['srch_orderno'];
	$ordersql_conditions .= " and o.trans_id in ($srch_orderno)";
}
if($_REQUEST['srch_payment'])
{
	$srch_payment = $_REQUEST['srch_payment'];
	$ordersql_conditions .= " and o.payment_method like \"$srch_payment\"";
}
if($_REQUEST['srch_status'])
{
	$srch_status = $_REQUEST['srch_status'];
	$ordersql_conditions .= " and o.status like \"$srch_status\"";
}	
if($_REQUEST['uid'])
{
	$uid = $_REQUEST['uid'];
	$ordersql_conditions .= " and o.user_id=\"$uid\"";
}
if($_REQUEST['pid'])
{
	$pid = $_REQUEST['pid'];
	$ordersql_conditions .= " and o.trans_id in (select trans_id from $wpdb->posts where ID=\"$pid\")";
}
$ordersql_limit=" order by o.trans_id desc limit $strtlimit,$endlimit";
//----------------------------------------------------
$total_pages = $wpdb->get_var($ordersql_count . $ordersql_from . $ordersql_conditions);
$orderinfo = $wpdb->get_results($ordersql_select.$ordersql_from.$ordersql_conditions.$ordersql_limit);
if($total_pages>0)
{
?>
      <form name="frmContentList1" action="" method="post">
      <input type="hidden" id="submitact" name="submitact" value="delete" />
        <table width="100%" cellpadding="5"  class="widefat post" >
          <thead>
            <tr>
              <th width="28" ><input name="check" onClick="return selectCheckBox();" style="border:0px;"id="check" type="checkbox"></th>
              <th width="120" ><strong><?php echo ORDER_NUM_TEXT; ?></strong></th>
              <th width="320" ><strong><?php echo CUSTOMER_NAME_TEXT; ?></strong></th>
              <th width="100" ><strong><?php echo PAY_AMT_TEXT; ?></strong></th>
              <th width="100" ><strong><?php echo PAY_TYPE_TEXT; ?></strong></th>
              <th width="100" ><strong><?php echo PAY_DATE_TEXT; ?></strong></th>
              <th width="85" ><strong><?php echo PAY_STATUS_TEXT; ?></strong></th>
              <th >&nbsp;</th>
            </tr>
            <?php
			
if($orderinfo)
{
	$counter = 0;
	foreach($orderinfo as $orderinfoObj)
	{ $counter++;
	?>
         <tr>

          <td align="center"><input name="list[]" id="check_<?php echo $counter;?>" value="<?php echo $orderinfoObj->trans_id;?>" type="checkbox"></td>
		  <td><?php echo $orderinfoObj->trans_id;?></td>
          <td><a href="<?php echo site_url('/wp-admin/admin.php?page=affiliates&amp;trans_id='.$orderinfoObj->trans_id.'#option_orders');?>"><div><?php echo $orderinfoObj->display_name;?></div></a></td>
          <td><?php echo $orderinfoObj->payable_amt." ".get_option('curremcy_sym');?></td>
          <td><?php echo $orderinfoObj->payment_method;?></td>
          <td><?php echo date('Y/m/d',strtotime($orderinfoObj->payment_date));?></td>
          <td><?php echo fetch_order_status($orderinfoObj->trans_id);?></td>
          <td>&nbsp;</td>
        </tr>
    <?php		
	}
}
?>
            <tr>
              <td colspan="8">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="5"><?php echo SET_STATUS_TO." : ";?> 
			  <table border='0'><tr><td>
			  <select name="order_status" id="order_status" style='width:200px; '>
                <option value=""> <?php echo SELECT_STATUS_TEXT;?> </option>
                    <option value="0" <?php if($_REQUEST['order_status']=='0'){?> selected<?php }?>><?php echo ORDER_PROCESSING_TEXT;?></option>
                    <option value="1" <?php if($_REQUEST['order_status']=='1'){?> selected<?php }?>><?php echo ORDER_APPROVE_TEXT;?></option>
                    <option value="2" <?php if($_REQUEST['order_status']=='2'){?> selected<?php }?>><?php echo ORDER_REJECT_TEXT;?></option>
			</select></td><td>
			<input name="submit" value="<?php echo SUBMIT_BUTTON_TEXT; ?>" onclick="return recordAction('status');" type="submit"  class="b_common"/></td><td>
			<input name="submit" value="<?php echo DELETE_TEXT; ?>" onclick="return recordAction('delete');" type="submit"  class="b_common" /></td></tr></table>
              </td>
              <td colspan="3" align="right"><strong><?php echo AFF_TOTAL_TEXT; ?> : <?php echo $total_pages;?> <?php _e('orders'); ?></strong></td>
            </tr>
            <tr><td colspan="8" align="center">
            <?php
			if($total_pages>$recordsperpage)
			{
			echo $General->get_pagination($targetpage,$total_pages,$recordsperpage,$pagination);
			}?>
            </td></tr>
          </thead>
        </table>
      </form>
      <?php
}else
{
?>
      <br />
      <br />
      <p><strong><?php echo NO_ORDER_MSG; ?></strong></p>
      <?php
}
?>
    </td>
  </tr>
</table>

	</div> <!-- page #end -->
 </div>   <!-- wrapper #end -->