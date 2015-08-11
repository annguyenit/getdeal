<?php include 'tab_header.php'; ?>
<link href="<?php echo PLUGIN_STYLEURL_REPORT;?>admin.css" rel="stylesheet" type="text/css" />
<div class="block" id="option_saller_report">
	<?php 
	include_once(TT_MODULES_FOLDER_PATH . 'report/admin_report_list.php');
	 ?>
</div>
<div class="block" id="option_trans_report">
	<?php 
		include_once(TT_MODULES_FOLDER_PATH . 'report/admin_transaction_report.php');
	?>

</div>
<div class="block" id="option_deal_report">
	<?php 
		include_once(TT_MODULES_FOLDER_PATH . 'report/admin_deal_report.php');
	?>

</div>

<script type="text/javascript">
function showdetail(custom_id)
{
	if(document.getElementById('detail_'+custom_id).style.display=='none')
	{
		document.getElementById('detail_'+custom_id).style.display='';
	}else
	{
		document.getElementById('detail_'+custom_id).style.display='none';	
	}
}
function reportshowdetail(custom_id)
{
	if(document.getElementById('reprtdetail_'+custom_id).style.display=='none')
	{
		document.getElementById('reprtdetail_'+custom_id).style.display='';
	}else
	{
		document.getElementById('reprtdetail_'+custom_id).style.display='none';	
	}
}

</script>
<?php include TT_ADMIN_TPL_PATH.'footer.php';?>