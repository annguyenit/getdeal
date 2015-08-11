<?php /*?><?php
global $General, $Cart;
$paymentOpts = $General->get_payment_optins($_POST['paymentmethod']);
$merchantid = $paymentOpts['merchantid'];
$returnUrl = $paymentOpts['returnUrl'];
$cancel_return = $paymentOpts['cancel_return'];
$notify_url = $paymentOpts['notify_url'];
$currency_code = $General->get_currency_code();
$cartInfo = $Cart->getcartInfo();
$itemArr = array();
for($i=0;$i<count($cartInfo);$i++)
{
	$product_att = preg_replace('/([(])([+-])([0-9]*)([)])/','',$cartInfo[$i]['product_att']);
	$itemArr[] = $cartInfo[$i]['product_qty'].' X '.$cartInfo[$i]['product_name']."($product_att)";
}
$item_name = implode(', ',$itemArr);
$amount = $Cart->getCartAmt();
?>
<form name="frm_payment_method" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" value="<?php echo $amount;?>" name="amount"/>
<input type="hidden" value="<?php echo $returnUrl;?>" name="return"/>
<input type="hidden" value="<?php echo $cancel_return;?>" name="cancel_return"/>
<input type="hidden" value="<?php echo $notify_url;?>" name="notify_url"/>
<input type="hidden" value="_xclick" name="cmd"/>
<input type="hidden" value="<?php echo $item_name;?>" name="item_name"/>
<!--<input type="hidden" value="0911091257765831-432" name="item_number"/>-->
<input type="hidden" value="<?php echo $merchantid;?>" name="business"/>
<input type="hidden" value="<?php echo $currency_code;?>" name="currency_code"/>
</form><?php */?>