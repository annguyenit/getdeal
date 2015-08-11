<?php
global $wpdb;

if($_GET['status']!='' && $_GET['lid']!='')
{
	$affiliate_links = get_option('affiliate_links');
	$affiliate_links[$_GET['lid']]['link_status'] = $_GET['status'];
	update_option('affiliate_links', $affiliate_links);
	$message = "Updated Successfully";
}
if($_GET['act']=='delete' && $_GET['lid']!='')
{
	$affiliate_links = get_option('affiliate_links');
	unset($affiliate_links[$_GET['lid']]);
	update_option('affiliate_links', $affiliate_links);
	$message = "Deleted Successfully";
}

$affiliate_links = get_option('affiliate_links');

?>
<h2><?php echo MANAGE_AFFILIATE_TITLE; ?></h2>
<?php 
if($_REQUEST['msg']=='success'){ $message = REC_UPDATE_SUCCESS_MSG;
if($message){?>

<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php echo $message;?> </p>
</div>

<?php } }?>

<p><a href="<?php echo site_url().'/wp-admin/admin.php?page=affiliates&pagetype=addedit#option_links"'?>"><strong><?php _e('Add Affiliate Link'); ?></strong></a> </p>

<table width="100%"  class="widefat post fixed" >
  <thead>
    <tr>
      <th width="22%"><strong><?php echo TITLE_TEXT; ?></strong></th>
      <th width="48%"><strong><?php echo LINK_URL_TITLE; ?></strong></th>
      <th width="15%"><strong><?php echo LINK_KEY_TITLE; ?></strong></th>
      <th width="15%" align="center"><strong><?php echo ACTION_TITLE; ?></strong></th>
    </tr>
<?php
if($affiliate_links)
{
	foreach($affiliate_links as $key=>$affiliate_links_Obj)
	{
	?>
    <tr>
      <td><a href="<?php echo site_url();?>/wp-admin/admin.php?page=affiliates&pagetype=addedit&lid=<?php echo $key;?>#option_links"" title="<?php _e('Edit');?> <?php echo $affiliate_links_Obj['link_title'];?>"><?php echo $affiliate_links_Obj['link_title'];?></a></td>
      <td><?php echo $affiliate_links_Obj['link_url'];?></td>
      <td><?php echo $affiliate_links_Obj['link_key'];?></td>
      <td>
       <div class="linkkey">
	  	<?php 
		if($affiliate_links_Obj['link_status']==1)
		{
			echo '<a href="'.site_url().'/wp-admin/admin.php?page=affiliates&status=0&lid='.$key.'#option_links">'.__('Hide').'</a>';
		}else
		{
			echo '<a href="'.site_url().'/wp-admin/admin.php?page=affiliates&status=1&lid='.$key.'#option_links">'.__('Show').'</a>';
		}
		?>
        |
       <a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=affiliates&act=delete&lid=<?php echo $key; ?>#option_links" onclick="return confirm_del();"><?php _e('Delete');?></a>
       </div>
      </td>
    </tr>
    <?php
    }
}else
{
?>
<tr><td colspan="4"><h4><?php echo NO_RECORD_MSG;?></h4></td></tr>
<?php
}
?>
  </thead>
</table>
<script language="javascript">
function confirm_del()
{
	if(confirm('<?php echo CONFIRM_DELETE_MSG; ?>'))
	{		
		return true;
	}else
	{
		return false;
	}
}
</script>