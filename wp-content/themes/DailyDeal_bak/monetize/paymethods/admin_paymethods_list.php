<?php include 'tab_header.php'; ?>
<?php
global $wpdb;

if($_GET['status']!='' && $_GET['id']!='')
{
	$paymentupdsql = "select option_value from $wpdb->options where option_id='".$_GET['id']."'";
	$paymentupdinfo = $wpdb->get_results($paymentupdsql);
	if($paymentupdinfo)
	{
		foreach($paymentupdinfo as $paymentupdinfoObj)
		{
			$option_value = unserialize($paymentupdinfoObj->option_value);
			$option_value['isactive'] = $_GET['status'];
			$option_value_str = serialize($option_value);
			$message = "Status Updated Successfully.";
		}
	}
	
	$updatestatus = "update $wpdb->options set option_value= '$option_value_str' where option_id='".$_GET['id']."'";
	$wpdb->query($updatestatus);
}

///////////update options start//////
if($_GET['payact']=='setting' && $_GET['id']!='')
{
	include_once(TT_MODULES_FOLDER_PATH . 'paymethods/admin_paymethods_add.php');
	exit;
}
//////////update options end////////

$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_%'";
$paymentinfo = $wpdb->get_results($paymentsql);
?>
<div class="block" id="option_payment">
<p><?php _e('Edit, activate &amp; deactivate payment gateway options here.','templatic');?></p>
<?php if($message){?>
<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
  <?php echo $message;?>
</div>
<?php }?>
<table style=" width:50%"  class="widefat post fixed" >
  <thead>
    <tr>
      <th width="190"><?php _e('Method Name','templatic');?></th>
      <th width="85" align="center"><?php _e('Activated?','templatic');?></th>
      <th width="100" align="center"><?php _e('Display order','templatic');?></th>
      <th width="85" align="center"><?php _e('Action','templatic');?></th>
      <th width="55" align="center"><?php _e('Settings','templatic');?></th>
    </tr>
    <?php
if($paymentinfo)
{
	foreach($paymentinfo as $paymentinfoObj)
	{
		$paymentInfo = unserialize($paymentinfoObj->option_value);
		$option_id = $paymentinfoObj->option_id;
		$paymentInfo['option_id'] = $option_id;
		$paymentOptionArray[$paymentInfo['display_order']][] = $paymentInfo;
	}
	ksort($paymentOptionArray);
	foreach($paymentOptionArray as $key=>$paymentInfoval)
	{
		for($i=0;$i<count($paymentInfoval);$i++)
		{
			$paymentInfo = $paymentInfoval[$i];
			$option_id = $paymentInfo['option_id'];
		?>
	<tr>
      <td ><?php echo $paymentInfo['name'];?></td>
      <td align="center"><?php if($paymentInfo['isactive']){ _e("Yes",'templatic');}else{	_e("No",'templatic');}?></td>
      <td align="center"><?php echo $paymentInfo['display_order'];?></td>
      <td align="left"><?php if($paymentInfo['isactive']==1)
	{
		echo '<a href="'.site_url().'/wp-admin/admin.php?page=paymentoptions&status=0&id='.$option_id.'#option_payment">'.__('Deactivate','templatic').'</a>';
	}else
	{
		echo '<a href="'.site_url().'/wp-admin/admin.php?page=paymentoptions&status=1&id='.$option_id.'#option_payment">'.__('Activate','templatic').'</a>';
	}
	?></td>
      <td align="center"><?php
    echo '<a href="'.site_url().'/wp-admin/admin.php?page=paymentoptions&payact=setting&id='.$option_id.'#option_payment">'.__('Edit','templatic').'</a>';
	?></td>
    
    </tr>
	
	
    <?php
		}
	}
}
?>
  </thead>
</table>
</div>
 <?php include TT_ADMIN_TPL_PATH.'footer.php';?>