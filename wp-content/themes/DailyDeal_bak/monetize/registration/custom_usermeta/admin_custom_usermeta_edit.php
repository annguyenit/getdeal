<?php
global $wpdb,$custom_usermeta_db_table_name;
$cf = $_REQUEST['cf'];
if($cf){
	$post_meta_info = $wpdb->get_results("select * from $custom_usermeta_db_table_name where cid= \"$cf\"");
}

if($post_meta_info){
	$post_val = $post_meta_info[0];
}else
{
	$post_val->sort_order = $wpdb->get_var("select max(sort_order)+1 from  $custom_usermeta_db_table_name");
}
if($_POST)
{
	$admin_title = $_POST['admin_title'];
	$site_title = $_POST['site_title'];
	$ctype = $_POST['ctype'];
	$htmlvar_name = $_POST['htmlvar_name'];
	$admin_desc = $_POST['admin_desc'];
	$clabels = $_POST['clabels'];
	$default_value = $_POST['default_value'];
	$sort_order = $_POST['sort_order'];
	$is_active = $_POST['is_active'];
	$show_on_listing = $_POST['show_on_listing'];
	$show_on_detail = $_POST['show_on_detail'];
	$post_type = $_POST['post_type'];
	$option_values = $_POST['option_values'];
	$is_require = $_POST['is_require'];
	if($_REQUEST['cf'])
	{
		$cf = $_REQUEST['cf'];
		if($_REQUEST['is_delete']=='1'){
			$sql = "update $custom_usermeta_db_table_name set admin_title=\"$admin_title\" ,site_title=\"$site_title\"  ,admin_desc=\"$admin_desc\" ,clabels=\"$clabels\" ,default_value=\"$default_value\" ,sort_order=\"$sort_order\" where cid=\"$cf\"";
		}else{
		$sql = "update $custom_usermeta_db_table_name set admin_title=\"$admin_title\" ,post_type=\"$post_type\",site_title=\"$site_title\" ,ctype=\"$ctype\" ,htmlvar_name=\"$htmlvar_name\",admin_desc=\"$admin_desc\" ,clabels=\"$clabels\" ,default_value=\"$default_value\" ,sort_order=\"$sort_order\",is_active=\"$is_active\",is_require=\"$is_require\",show_on_listing=\"$show_on_listing\",show_on_detail=\"$show_on_detail\", option_values=\"$option_values\" where cid=\"$cf\"";
		}
		$wpdb->query($sql);
	}else
	{
		$sql = "insert into $custom_usermeta_db_table_name (admin_title,post_type,site_title,ctype,htmlvar_name,admin_desc,clabels,default_value,sort_order,is_active,is_require,show_on_listing,show_on_detail,option_values) values (\"$admin_title\",\"$post_type\",\"$site_title\",\"$ctype\",\"$htmlvar_name\",\"$admin_desc\",\"$clabels\",\"$default_value\",\"$sort_order\",\"$is_active\",\"$is_require\",\"$show_on_listing\",\"$show_on_detail\",\"$option_values\")";
		$wpdb->query($sql);
		$cf = $wpdb->get_var("select max(cid) from $custom_usermeta_db_table_name");
	}
	
	$url = site_url().'/wp-admin/admin.php';
	echo '<form action="'.$url.'#option_add_custom_fields" method="get" id="frm_edit_custom_fields" name="frm_edit_custom_fields">
	<input type="hidden" value="custom_usermeta" name="page"><input type="hidden" value="success" name="msg">
	</form>
	<script>document.frm_edit_custom_fields.submit();</script>
	';exit;
}
?>
<h3><?php
if($_REQUEST['cf'])
{
	 _e('Edit custom user-info field','templatic');	
}else
{
	 _e('Add a custom user-info field','templatic');
}
?></h3>
<?php
if($_REQUEST['msg']=='success')
{
	$message = __('User-info field saved successfully.','templatic');	
}
?>
<?php if($message){?>
<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
  <?php echo $message;?>
</div>
<?php }?>
<script type="text/javascript">
function chk_field_form()
{
	if(document.custom_fields_frm.site_title.value == "")

	{

		alert("<?php _e('Please enter Frontend title','templatic');?>");

		document.custom_fields_frm.site_title.focus();

		return false;

	}
	if(document.custom_fields_frm.htmlvar_name.value == "")

	{

		alert("<?php _e('Please enter HTML variable name','templatic');?>");

		document.custom_fields_frm.htmlvar_name.focus();

		return false;

	}
}
</script><p><?php _e('You can add a new custom user-info field here. Users will be able to add / edit their information on their profile page.','templatic');?></p>
<form action="<?php echo site_url();?>/wp-admin/admin.php?page=custom_usermeta&act=addedit" method="post" name="custom_fields_frm" onsubmit="return chk_field_form();">
<input type="hidden" name="save" value="1" /> <input type="hidden" name="is_delete" value="<?php echo $post_val->is_delete;?>" />
<?php if($_REQUEST['cf']){?>
<input type="hidden" name="cf" value="<?php echo $_REQUEST['cf'];?>" />
<?php }?>
<input type="hidden" name="post_type" id="post_type" value="registration" />
<input type="hidden" name="clabels" id="clabels" value="<?php echo $post_val->clabels;?>" />

<input type="hidden" name="default_value" id="default_value" value="<?php echo $post_val->default_value;?>" />
<input type="hidden" name="admin_title" id="admin_title" value="<?php echo $post_val->admin_title;?>" />

<table  class="widefat post fixed" style="width:100%;">
<tr>
  <td width="30%"><strong><?php _e('Field type : ','templatic');?></strong></td>
  <td align="left">
   <select name="ctype" id="ctype" onchange="show_option_add(this.value)" <?php if($post_val->is_delete=='1'){?> disabled="disabled" <?php }?>>
  <option value="text" <?php if($post_val->ctype=='text'){ echo 'selected="selected"';}?>><?php _e('Text','templatic');?></option>
   <option value="texteditor" <?php if($post_val->ctype=='texteditor'){ echo 'selected="selected"';}?>><?php _e('Text Editor','templatic');?></option>
   <option value="head" <?php if($post_val->ctype=='head'){ echo 'selected="selected"';}?>><?php _e('Text Heading','templatic');?></option>
  <option value="checkbox" <?php if($post_val->ctype=='checkbox'){ echo 'selected="selected"';}?>><?php _e('Checkbox','templatic');?></option>
  <option value="date" <?php if($post_val->ctype=='date'){ echo 'selected="selected"';}?>><?php _e('Date Picker','templatic');?></option>
   <option value="multicheckbox" <?php if($post_val->ctype=='multicheckbox'){ echo 'selected="selected"';}?>><?php _e('Multi Checkbox','templatic');?></option>
  <option value="radio" <?php if($post_val->ctype=='radio'){ echo 'selected="selected"';}?>><?php _e('Radio','templatic');?></option>
  <option value="select" <?php if($post_val->ctype=='select'){ echo 'selected="selected"';}?>><?php _e('Select','templatic');?></option>
  <option value="textarea" <?php if($post_val->ctype=='textarea'){ echo 'selected="selected"';}?>><?php _e('Textarea','templatic');?></option>
   <option value="upload" <?php if($post_val->ctype=='upload'){ echo 'selected="selected"';}?>><?php _e('Upload','templatic');?></option>
  </select>
<br />    <p><?php _e('Select the type of this custom field.','templatic');?></p>
  </td>
  </tr>
  <tr id="ctype_option_tr_id"  <?php if($post_val->ctype=='select'){?> style="display:block;" <?php }else{?> style="display:none;" <?php }?>>
  <td ><strong><?php _e('Option values : ','templatic');?></strong></td>
  <td align="left"><input type="text" name="option_values" id="option_values" value="<?php echo $post_val->option_values;?>" size="50" />
   <br />    <p><?php _e('Specify multiple option values seperated by a comma.','templatic');?></p>
  </td>
  </tr>
  <tr id="admin_title_id"  <?php if($post_val->ctype=='head'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
  </tr>
  
  <tr>
  <td ><strong><?php _e('Field name: ','templatic');?></strong></td>
  <td align="left"><input type="text" name="site_title" id="site_title" value="<?php echo $post_val->site_title;?>" size="50" />
<br />    <p><?php _e('The name you provide here will be displayed as the field\'s name (label) in the front-end.','templatic');?></p>
  </td>
  </tr>
   <tr>
  <td ><strong><?php _e('Description: ','templatic');?></strong></td>
  <td align="left"><input type="text"name="admin_desc" id="admin_desc" value="<?php echo $post_val->admin_desc;?>" size="50" />
<br />    <p><?php _e('Custom field description which will appear in the front-end as well as the backend.','templatic');?></p>
  </td>
  </tr>
  <tr>
  <td ><strong><?php _e('HTML variable name: ','templatic');?></strong></td>
  <td align="left"><input type="text" name="htmlvar_name" id="htmlvar_name" value="<?php echo $post_val->htmlvar_name;?>" size="50" <?php if($post_val->is_delete=='1'){?>  readonly="readonly"<?php }?> />
  <br />    <p><?php _e('The HTML variable name for the custom field. IMPORTANT: It should be a unique name.','templatic');?></p>
  </td>
  </tr>

 <tr id="admin_label_id"  <?php if($post_val->ctype=='head'){?> style="display:none;" <?php }else{?>  style="display:block;" <?php }?>>
  <tr id="admin_desc_id"  <?php if($post_val->ctype=='head'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
  </tr>
  <tr id="default_value_id"  <?php if($post_val->ctype=='head'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
 
  </tr>
 
  <tr>
  <td ><strong><?php _e('Position (Display order): ','templatic');?></strong></td>
  <td align="left"><input type="text" name="sort_order" id="sort_order"  value="<?php echo $post_val->sort_order;?>" size="50" />
      <br />    <p><?php _e('This is a numeric value that determines the position of the custom field in the front-end and the back-end. e.g. 5','templatic');?></p>
  </td>
  </tr>
  <tr>
  <td ><strong><?php _e('Activated?: ','templatic');?></strong></td>
  <td align="left">
  <select name="is_active" id="is_active" <?php if($post_val->is_delete=='1'){?> disabled="disabled" <?php }?>>
  <option value="1" <?php if($post_val->is_active=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','templatic');?></option>
  <option value="0" <?php if($post_val->is_active=='0'){ echo 'selected="selected"';}?>><?php _e('No','templatic');?></option>
  </select>
      <br />    <span><?php _e('This setting activates/de-activates the custom field in the front-end and the back-end.','templatic');?></span>
 </td>
  </tr>
   <tr id="is_require_id"  <?php if($post_val->ctype=='head'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
  <td ><strong><?php _e('Compulsory?:','templatic');?></strong></td>
  <td align="left">
  <select name="is_require" id="is_require" <?php if($post_val->is_delete=='1'){?> disabled="disabled" <?php }?>>
  <option value="1" <?php if($post_val->is_require=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','templatic');?></option>
  <option value="0" <?php if($post_val->is_require=='0'){ echo 'selected="selected"';}?>><?php _e('No','templatic');?></option>
  </select>
      <br />    <span><?php _e('Specify whether or not this field is required to be filled in compulsarily by users.','templatic');?></span>
 </td>
  </tr>
  <tr id="show_on_listing_id"  <?php if($post_val->ctype=='head'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
  <td ><strong><?php _e('Show on registration page?: ','templatic');?></strong></td>
  <td align="left">
  <select name="show_on_listing" id="show_on_listing" <?php if($post_val->is_delete=='1'){?> disabled="disabled" <?php }?>>
  <option value="1" <?php if($post_val->show_on_listing=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','templatic');?></option>
  <option value="0" <?php if($post_val->show_on_listing=='0'){ echo 'selected="selected"';}?>><?php _e('No','templatic');?></option>
  </select>
      <br />    <span><?php _e('Specify whether or not this field be shown on the &lsquo;Registration page&rsquo;.','templatic');?></span>
  </td>
  </tr>
  <tr id="show_on_detail_id"  <?php if($post_val->ctype=='head'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
  <td ><strong><?php _e('Show on Profile page ? : ','templatic');?></strong></td>
  <td align="left">
  <select name="show_on_detail" id="show_on_detail" <?php if($post_val->is_delete=='1'){?> disabled="disabled" <?php }?>>
  <option value="1" <?php if($post_val->show_on_detail=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','templatic');?></option>
  <option value="0" <?php if($post_val->show_on_detail=='0'){ echo 'selected="selected"';}?>><?php _e('No','templatic');?></option>
  </select>
      <br />    <span><?php _e('Specify whether or not this field be shown on the &lsquo;Profile page&rsquo;.','templatic');?></span>
  </td>
  </tr>
    <tr>
  <td >&nbsp;</td>
  <td align="left"><input type="submit" class="button" name="save" id="save" value="<?php _e('Save','templatic');?>" /> <a href="<?php echo site_url();?>/wp-admin/admin.php?page=custom_usermeta"><input type="button" name="cancel" value="<?php _e('Cancel','templatic');?>" class="button" /></a></td>
  </tr>
</table>
</form>
<script type="text/javascript">
function show_option_add(htmltype)
{
	if(htmltype=='select' || htmltype=='multiselect' || htmltype=='radio' || htmltype=='multicheckbox')
	{
		document.getElementById('ctype_option_tr_id').style.display='';		
	}else
	{
		document.getElementById('ctype_option_tr_id').style.display='none';	
	}
	
	if(htmltype=='head')
	{
		document.getElementById('admin_title_id').style.display='none';	
		document.getElementById('admin_label_id').style.display='none';	
		document.getElementById('admin_desc_id').style.display='none';	
		document.getElementById('default_value_id').style.display='none';	
		document.getElementById('show_on_listing_id').style.display='none';	
		document.getElementById('show_on_detail_id').style.display='none';	
		document.getElementById('is_require_id').style.display='none';	
	}
	else
	{
		document.getElementById('admin_title_id').style.display='';	
		document.getElementById('admin_label_id').style.display='';	
		document.getElementById('admin_desc_id').style.display='';	
		document.getElementById('default_value_id').style.display='';	
		document.getElementById('show_on_listing_id').style.display='';	
		document.getElementById('show_on_detail_id').style.display='';	
		document.getElementById('is_require_id').style.display='';	
	}
}
if(document.getElementById('ctype').value)
{
	show_option_add(document.getElementById('ctype').value)	;
}
</script>