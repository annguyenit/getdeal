<script type="text/javascript">
<?php
global $validation_info;
$js_code = 'jQuery(document).ready(function()
{
';
//$js_code .= '//global vars ';
$js_code .= 'var userform = jQuery("#userform"); 
'; //form Id
$jsfunction = array();
for($i=0;$i<count($validation_info);$i++)
{
	$name = $validation_info[$i]['name'];
	$espan = $validation_info[$i]['espan'];
	$type = $validation_info[$i]['type'];
	$text = $validation_info[$i]['text'];
	
	$js_code .= '
	var '.$name.' = jQuery("#'.$name.'"); 
	';
	$js_code .= '
	var '.$espan.' = jQuery("#'.$espan.'"); 
	';

	if($type=='select' || $type=='checkbox' || $type=='multicheckbox' || $type=='catcheckbox')
	{
		$msg = sprintf("Please select %s",$text);
	}else
	{
		$msg = sprintf("Please Enter %s",$text);
	}
	
	if($type=='multicheckbox' || $type=='catcheckbox')
	{
		$js_code .= '
		function validate_'.$name.'()
		{
			var chklength = document.getElementsByName("'.$name.'[]").length;
			var flag      = false;
			var temp	  = "";
			for(i=1;i<=chklength;i++)
			{
				if(eval(\'document.getElementById("'.$name.'_"+i+"")\'))
				{
				   temp = document.getElementById("'.$name.'_"+i+"").checked; 
				   if(temp == true)
				   {
						flag = true;
						break;
					}
				}
			}
			if(flag == false)
			{
				'.$espan.'.text("'.$msg.'");
				'.$espan.'.addClass("message_error2");
				return false;
			}
			else{			
				'.$espan.'.text("");
				'.$espan.'.removeClass("message_error2");
				return true;
			}
			
			return true;
		}
	';
	}else
	{
		$js_code .= '
		function validate_'.$name.'()
		{';
		if($type=='checkbox')
		{
			$js_code .='if(!document.getElementById("'.$name.'").checked)';
		}else
		{
			$js_code .= '
				if(jQuery("#'.$name.'").val() == "")
			';
		}
		$js_code .= '
			{
				'.$name.'.addClass("error");
				'.$espan.'.text("'.$msg.'");
				'.$espan.'.addClass("message_error2");
				return false;
			}
			else';
		if($name=='user_email')
		{
			$js_code .= '
			if(jQuery("#'.$name.'").val() != "")
			{
				var a = jQuery("#'.$name.'").val();
				var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
				if(filter.test(a)){
					'.$name.'.removeClass("error");
					'.$espan.'.text("");
					'.$espan.'.removeClass("message_error2");
					return true;
				}else{
					'.$name.'.addClass("error");
					'.$espan.'.text("'.$msg.'");
					'.$espan.'.addClass("message_error2");
					return false;	
				}
			}else
			';
		}
		$js_code .= '{
				'.$name.'.removeClass("error");
				'.$espan.'.text("");
				'.$espan.'.removeClass("message_error2");
				return true;
			}
		}
		';
	}
	//$js_code .= '//On blur ';
	$js_code .= $name.'.blur(validate_'.$name.'); ';
	
	//$js_code .= '//On key press ';
	$js_code .= $name.'.keyup(validate_'.$name.'); ';
	
	$jsfunction[] = 'validate_'.$name.'()';
}

if($jsfunction)
{
	$jsfunction_str = implode(' & ', $jsfunction);	
}

//$js_code .= '//On Submitting ';
$js_code .= '	
userform.submit(function()
{
	if('.$jsfunction_str.')
	{
		return true
	}
	else
	{
		return false;
	}
});
';

$js_code .= '
});';
echo $js_code;
?>
</script>