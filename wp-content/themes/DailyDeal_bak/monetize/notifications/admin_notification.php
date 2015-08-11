<?php
include 'tab_header.php';
global $notification_email,$notification_msg;
if($_POST)
{
	if($notification_email)
	{
		foreach($notification_email as $notification)
		{
			$subject_name = stripslashes($notification['subject'][0]);
			$content_name = stripslashes($notification['content'][0]);

			update_option("$subject_name",$_POST["$subject_name"]);
			update_option("$content_name",$_POST["$content_name"]);
		}
	}

	if($notification_msg)
	{
		foreach($notification_msg as $notification)
		{
			$content_name = stripslashes($notification['content'][0]);
			update_option("$content_name",$_POST["$content_name"]);
		}
	}

	if(isset($_REQUEST['submitallow']))
	{
		global $wpdb;
		$table_setup = $wpdb->prefix."deal_setup";
		$udatedb = $wpdb->query("Update $table_setup set access = '".$_POST['mngoption']."' where sid='1'");
		echo "<script language='javascript'> location.href='admin.php?page=notification&successsetup=yes&addfield=new#option_global';</script>";
	}
}

?>

<div class="block" id="option_emails">

<p><?php _e('Notification emails are sent to the administrator and sellers at various events like submitting a deal, rejecting a deal request, expiration of deals, etc. You can customize these notification emails and messages here.','templatic');?></p>
<?php if($_REQUEST['msg']=='success'){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
<p><?php _e('updated successfully.','templatic'); ?></p>
</div>
<?php }?>
<form action="<?php echo site_url();?>/wp-admin/admin.php?page=notification" name="emails" method="post">
<?php if($notification_email){?>
<table width="100%" cellpadding="0" cellspacing="0" class="widefat post fixed" >
<thead>
<tr>
<th width="120" align="left"><?php _e('Email type','templatic'); ?></th>
<th width="120" align="left"><?php _e('Subject','templatic'); ?></th>
<th width="320" align="left"><?php _e('Message','templatic'); ?></th>
</tr>
</thead>
<?php
foreach($notification_email as $notification)
{
	if($notification)
	{
		$subject_name = stripslashes($notification['subject'][0]);
		$content_name = stripslashes($notification['content'][0]);
			
		$subject_val = stripslashes(get_option("$subject_name"));
		$content_val = stripslashes(get_option("$content_name"));
		if(!$subject_val){$subject_val = stripslashes($notification['subject'][1]);}
		if(!$content_val){$content_val = stripslashes($notification['content'][1]);}
		?>
		<tr>
		<td><?php echo $notification['title'];?></td>
		<td><textarea style="width:120px; height:150px;" name="<?php echo $subject_name;?>"><?php echo $subject_val;?></textarea></td>
		<td><textarea style="width:320px; height:150px;" name="<?php echo $content_name;?>"><?php echo $content_val;?></textarea></td>
		</tr>
    <?php
	}
}
?>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>
  <div class="info" style="background:none;border:none;">
  	<input type="submit" name="Submit" value="<?php _e('Save All Changes','templatic')?>" class="button-framework save-options button-framework-imp"> 
  </div>
  </td>
</tr>

</table>
</form>
<?php echo legend_notification(); }?>
</div>
<div class="block" id="option_messages">
<p><?php _e('Notification emails are sent to the administrator and sellers at various events like submitting a deal, rejecting a deal request, expiration of deals, etc. You can customize these notification emails and messages here.','templatic');?></p>
<form action="<?php echo site_url();?>/wp-admin/admin.php?page=notification" name="message" method="post">
<?php if($notification_msg){?>
<table width="100%" class="widefat post fixed" >
<thead>
<tr>
  <th width="138" align="left"><strong><?php _e('Title','templatic'); ?></strong></th>
  <th align="left" colspan="2"><strong><?php _e('Description','templatic'); ?></strong></th>
</tr>
</thead>
<?php
$counter = "";
foreach($notification_msg as $notification)
{
	echo $counter;
	if($notification)
	{
		$infoarr = $notification;
		$content_name = stripslashes($notification['content'][0]);
		$content_val = stripslashes(get_option("$content_name"));
		if(!$content_val){$content_val = stripslashes($notification['content'][1]);}
		?>
		<tr>
		<td><?php echo $notification['title'];?></td>
		<td colspan="2"><textarea rows="5" name="<?php echo $content_name;?>"><?php echo $content_val;?></textarea></td>
		</tr>
	<?php
	}
	$counter = $counter ++;
	
}
?>
<tr>
  <td>&nbsp;</td>
  <td colspan="2" style="text-align:right;">
  <div style="background:none;border:none;" class="info">
  	<input type="submit" name="Submit" value="<?php _e('Save All Changes','templatic')?>" class="button-framework save-options button-framework-imp" />
  </div>  
  </td>
</tr>
</table>
<?php echo legend_notification(); }?>
</form>
</div>

<div class="block" id="option_global">
<form action="<?php echo site_url();?>/wp-admin/admin.php?page=notification#option_global" name="globalsetting" method="post">
				<?php if(isset($_REQUEST['successsetup']))
				{ ?>
					<?php	switch ($_REQUEST['successsetup'])
					{
						case "yes" : echo "<div id='submitedsuccess' class='updated fade' style='height:25px; font-size:12px; padding-top:3px;'>Updated Successfully.
						</div>";
						break;
						
					}
				} ?>
									
	<p>
	<?php
	global $wpdb;
	$table_setup = $wpdb->prefix."deal_setup";
	$sqlsetup = $wpdb->get_row("select * from $table_setup where sid='1'");

	?>
	<h3>Allow user to edit / delete deal request</h3>
	<INPUT TYPE=RADIO NAME="mngoption" VALUE="1" id="allow" <?php if($sqlsetup->access == '1') { ?>checked="checked"<?php } ?>>Yes<BR>
	<INPUT TYPE=RADIO NAME="mngoption" VALUE="0" id="dontallow" <?php if($sqlsetup->access == '0' ) { ?>checked="checked"<?php }elseif($sqlsetup->access == ''){ ?>checked="checked"<?php } ?>>No<BR>
	</p>
	<input type="submit" name="submitallow" value="Save All Changes" class="button-framework save-options button-framework-imp"/>
</form>
</div>
<?php include TT_ADMIN_TPL_PATH.'footer.php';?>