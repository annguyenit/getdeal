<?php
define('TEMPL_PAYMENT_MODULE', __("Payment options",'templatic'));
define('TEMPL_PAYMENT_CURRENT_VERSION', '1.0.0');
define('TEMPL_PAYMENT_LOG_PATH','http://templatic.com/updates/monetize/paymethods/paymethods_change_log.txt');
define('TEMPL_PAYMENT_ZIP_FOLDER_PATH','http://templatic.com/updates/monetize/paymethods/paymethods.zip');
define('TT_PAYMENT_FOLDER','paymethods');
define('TT_PAYMENT_MODULES_PATH',TT_MODULES_FOLDER_PATH . TT_PAYMENT_FOLDER.'/');

//----------------------------------------------
     //MODULE AUTO UPDATE START//
//----------------------------------------------
add_action('templ_module_auto_update','templ_module_auto_update_paymethods_fun');
function templ_module_auto_update_paymethods_fun()
{
	$curversion = TEMPL_PAYMENT_CURRENT_VERSION;
	$liveversion = tmpl_current_framework_version(TEMPL_PAYMENT_LOG_PATH);
	$is_update = templ_is_updated( $curversion, $liveversion);
	if($is_update)
	{
?>
<table border="0" cellpadding="0" cellspacing="0" style="border:0px; padding:10px 0px;">
<tr>
<td class="module"><h3><?php echo TEMPL_PAYMENT_MODULE;?></h3></td>
</tr>
<tr>
<td>
<form method="post"  name="framework_update" id="framework_update">
<input type="hidden" name="action" value="<?php echo TT_PAYMENT_FOLDER;?>" />
<input type="hidden" name="zip" value="<?php echo TEMPL_PAYMENT_ZIP_FOLDER_PATH;?>" />
<input type="hidden" name="log" value="<?php echo TEMPL_PAYMENT_LOG_PATH;?>" />
<input type="hidden" name="path" value="<?php echo TT_PAYMENT_MODULES_PATH;?>" />
<?php wp_nonce_field('update-options'); ?>

<?php echo sprintf(__('<h4>A new version of Payment options Module is available.</h4>
<p>This updater will collect a file from the templatic.com server. It will download and extract the files to your current theme&prime;s functions folder. 
<br />We recommend backing up your theme files before updating. Only upgrade related module files if necessary.
<br />If you are facing any problem in auto updating the framework, then please download the latest version of the theme from members area and then just overwrite the "<b>%s</b>" folder.
<br /><br />&rArr; Your version: %s
<br />&rArr; Current Version: %s </p>','templatic'),TT_PAYMENT_MODULES_PATH,$curversion,$liveversion);?>

<input type="submit" class="button" value="<?php _e('Update','templatic');?>" onclick="document.getElementById('framework_upgrade_process_span_id').style.display=''" />
</form>
</td>
</tr>
<tr><td style="border-bottom:5px solid #dedede;">&nbsp;</td></tr>
</table>
<?php
	}
}
//----------------------------------------------
     //MODULE AUTO UPDATE END//
//----------------------------------------------

/////////admin menu settings start////////////////
add_action('templ_admin_menu', 'paymethod_add_admin_menu');
function paymethod_add_admin_menu()
{
	add_submenu_page('templatic_wp_admin_menu', __("Manage Payment options",'templatic'), __("Payment options",'templatic'), TEMPL_ACCESS_USER, 'paymentoptions', 'manage_paysettings');
}

function manage_paysettings()
{
	include_once(TT_MODULES_FOLDER_PATH . 'paymethods/admin_paymethods_list.php');
}
/////////admin menu settings end////////////////


function templ_payment_option_radio()
{
	do_action('templ_payment_option_radio');	
}
					 
add_action('templ_payment_option_radio','templ_payment_option_radio_fun');
function templ_payment_option_radio_fun()
{
	global $wpdb;
	$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_%' order by option_id";
	$paymentinfo = $wpdb->get_results($paymentsql);
	if($paymentinfo)
	{
	?>
	<h3> <?php echo SELECT_PAY_MEHTOD_TEXT; ?></h3>
	<ul class="payment_method">
	<?php
		$paymentOptionArray = array();
		$paymethodKeyarray = array();
		foreach($paymentinfo as $paymentinfoObj)
		{
			$paymentInfo = unserialize($paymentinfoObj->option_value);
			if($paymentInfo['isactive'])
			{
				$paymethodKeyarray[] = $paymentInfo['key'];
				$paymentOptionArray[$paymentInfo['display_order']][] = $paymentInfo;
			}
		}
		ksort($paymentOptionArray);
		$array_pay_options = array();
		if($paymentOptionArray)
		{
			foreach($paymentOptionArray as $key=>$paymentInfoval)
			{
				for($i=0;$i<count($paymentInfoval);$i++)
				{
					$paymentInfo = $paymentInfoval[$i];
					$jsfunction = 'onclick="showoptions(this.value);"';
					$chked = '';
					if($key==1)
					{
						$chked = 'checked="checked"';
					}
				?>
	<li id="<?php echo $paymentInfo['key'];?>"><label>
	  <input <?php echo $jsfunction;?>  type="radio" value="<?php echo $paymentInfo['key'];?>" id="<?php echo $paymentInfo['key'];?>_id" name="paymentmethod" <?php echo $chked;?> />  <?php echo $paymentInfo['name']?></label></li>
	 
	  <?php
					if(file_exists(TEMPLATEPATH.'/library/includes/payment/'.$paymentInfo['key'].'/'.$paymentInfo['key'].'.php'))
					{
					?>
	  <?php
						$array_pay_options[] =TEMPLATEPATH.'/library/includes/payment/'.$paymentInfo['key'].'/'.$paymentInfo['key'].'.php';
						?>
	  <?php
					} 
				 ?> 
	  <?php
				}
			}
		}else
		{
		?>
		<li><?php echo NO_PAYMENT_METHOD_MSG;?></li>
		<?php
		}
		
	?>
	
	</ul>
    <?php
    if($array_pay_options)
	{
		for($i=0;$i<count($array_pay_options);$i++)	
		{
			include_once($array_pay_options[$i]);	
		}
	}
	?>
    <script type="text/javascript">
    function showoptions(paymethod)
    {
    <?php
    for($i=0;$i<count($paymethodKeyarray);$i++)
    {
    ?>
    showoptvar = '<?php echo $paymethodKeyarray[$i]?>options';
    if(eval(document.getElementById(showoptvar)))
    {
    document.getElementById(showoptvar).style.display = 'none';
    if(paymethod=='<?php echo $paymethodKeyarray[$i]?>')
    {
    document.getElementById(showoptvar).style.display = '';
    }
    }
    <?php
    }
    ?>
    }
    <?php
    for($i=0;$i<count($paymethodKeyarray);$i++)
    {
    ?>
    if(document.getElementById('<?php echo $paymethodKeyarray[$i];?>_id').checked)
    {
    showoptions(document.getElementById('<?php echo $paymethodKeyarray[$i];?>_id').value);
    }
    <?php
    }	
    ?>
    </script>
	<?php
	}	
}

function templ_nopayment_redirect()
{
	if(apply_filters('templ_skip_payment_method','0'))
	{
	}else
	{
		wp_redirect(apply_filters('templ_nopayment_redirect_url',site_url('/?ptype=submition&backandedit=1&emsg=nopaymethod')));	
		exit;
	}
}

add_filter('templ_submit_form_emsg_filter','templ_submit_form_emsg_payment');
function templ_submit_form_emsg_payment($msg)
{
	if($_REQUEST['emsg']=='nopaymethod')
	{
		return $msg.=__('Please select payment method on preview page.','templatic');
	}
}

?>