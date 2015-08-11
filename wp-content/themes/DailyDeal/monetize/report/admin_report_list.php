<?php 
global $wpdb,$transection_db_table_name;
$post_table = $wpdb->prefix."posts";
$post_meta_table = $wpdb->prefix."postmeta";
$user_db_table_name1 = $wpdb->prefix . "users";
if($wpdb->get_var("SHOW TABLES LIKE \"$user_db_table_name1\"") != $user_db_table_name1)	{
	$tbl_users = $wpdb->get_var("SHOW TABLES LIKE \"%users\"");
	$user_db_table_name = $tbl_users;
} else{
	$user_db_table_name = $user_db_table_name1;
}
?>
<h3>Seller Report</h3>
<div class="divright"><a href="<?php echo get_template_directory_uri().'/monetize/report/export_report.php';?>" title="Export To CSV" class="i_export">Export To CSV</a></div>
  <form method="post" action="<?php echo site_url('/wp-admin/admin.php?page=report');?>" name="ordersearch_frm">
        <table cellspacing="1" cellpadding="4" border="1" width="100%" style="padding:5px;">
            <tr>
				<td valign="top" style="width:100px;"><strong><?php _e('Seller Name','templatic'); ?> :</strong></td>
				<td valign="top" style="width:210px;"><select name="saller_id" style="width:200px;"><option value="">Select Seller</option><?php echo saller_cmb();?></select></td>
				<td valign="top" >&nbsp;&nbsp;<input type="submit" name="Search" value="<?php _e('Search'); ?>" class="button-secondary action" onclick="chkfrm();" /></td>
			</tr>
    </table>
    </form><br />
  <?php
$recordsperpage = 30;
$targetpage = site_url("/wp-admin/admin.php?page=report");
$pagination = $_REQUEST['pagination'];
if($pagination == '')
{
	$pagination = 1;
}
$strtlimit = ($pagination-1)*$recordsperpage;
$endlimit = $strtlimit+$recordsperpage;
$orderCount = 0;
//----------------------------------------------------
$ordersql_select = "select DISTINCT u.ID,u.user_nicename ";
$ordersql_from= " from $user_db_table_name u,$post_table p ";
$ordersql_conditions= " where u.ID = p.post_author and p.post_type = '".CUSTOM_POST_TYPE1."' ";
if($_REQUEST['saller_id'] != '')
{
	$id = $_REQUEST['saller_id'];
	$ordersql_conditions .= " and u.ID = $id";
}
$ordersql_limit = " limit $strtlimit,$recordsperpage";
$priceinfo_count = $wpdb->get_results($ordersql_select.$ordersql_from.$ordersql_conditions);
$priceinfo = $wpdb->get_results($ordersql_select.$ordersql_from.$ordersql_conditions.$ordersql_limit);
$total_pages = count($priceinfo_count);
if($total_pages > 0) { 
	if($priceinfo) { ?>
<table style="100%" cellpadding="5" class="widefat post fixed" >
  <thead>
    <tr>
		<th width="30" align="left"><?php _e('ID','templatic'); ?></th>
		<th align="left"><?php _e('Seller','templatic'); ?></th>
		<th align="left" width="50"><?php _e('Deal','templatic'); ?></th>
		<th align="left" width="50"><?php _e('Sale','templatic'); ?></th>
		<th align="left" width="100"><?php _e('Customer','templatic'); ?></th>
		<th align="left"><?php _e('Action','templatic'); ?></th>
	</tr>
	<?php foreach($priceinfo as $priceinfoObj)
	{
?>
    <tr>
      <td><?php echo $priceinfoObj->ID;?></td>
      <td><?php echo $priceinfoObj->user_nicename;?></td>
      <td><?php echo deal_count_post($priceinfoObj->ID);?></td>
      <td><?php echo deal_salecount_post($priceinfoObj->ID);?></td>
      <td><?php echo deal_salecount_post($priceinfoObj->ID);?></td>
      <td><a href="javascript:void(0);showdetail('<?php echo $priceinfoObj->ID;?>');"><?php _e('Details','templatic');?></a> | <a href="<?php echo get_template_directory_uri().'/monetize/report/export_report.php?id='.$priceinfoObj->ID;?>"><?php _e('Export','templatic');?></a></td>
    </tr>
	<tr id="detail_<?php echo $priceinfoObj->ID;?>" style="display:none;">
		<td colspan="6">
			<?php deal_list_perauthor($priceinfoObj->ID);?>
		</td>
      </tr>	
	<?php
	}
}
?>
    <tr><td colspan="6" align="center">
            <?php
			if($total_pages>$recordsperpage)
			{
			echo get_pagination($targetpage,$total_pages,$recordsperpage,$pagination,'#option_saller_report');
			}?>
            </td></tr>
  </thead>
</table>
 <?php
}else
{
?>
<strong><?php _e('No Transaction Available'); ?></strong>
      <?php
}
?>
