<?php session_start(); ?>

 <div class="wrapper" >
		<div class="clearfix container_message">
            	<h1 class="head2"><?php echo AUTHORISE_NET_MSG;?></h1>
            </div>

<?php
/*  Demonstration on using authorizenet.class.php.  This just sets up a
*  little test transaction to the authorize.net payment gateway.  You
*  should read through the SIM documentation at authorize.net to get
*  some familiarity with what's going on here.  You will also need to have
*  a login and password for an authorize.net SIM account and PHP with SSL and
*  curl support.
*
*  Reference http://www.authorize.net/support/SIM_guide.pdf for details on
*  the SIM API.
*/
$paymentOpts = get_payment_optins($_REQUEST['paymentmethod']);


global $payable_amount,$post_title,$last_postid,$current_user,$did1 ;
global $user_baddr,$user_bcity,$user_bstate,$user_bcountry,$user_bphone,$user_bpostalcode,$user_saddr,$user_scity ,$user_sstate,$user_scountry,$user_spostalcode,$user_sphone,$user_billing_name,$buser_shipping_name;
$display_name = $current_user->data->display_name;
$user_email = $current_user->data->user_email;
$desc = $post_title;
$payable_amt = $payable_amount;

require_once(TEMPLATEPATH . '/library/includes/payment/authorizenet/authorizenet.class.php');

require_once(TEMPLATEPATH . '/library/includes/payment/authorizenet/php_sdk/AuthorizeNet.php'); // Include the SDK you downloaded in Step 2
$api_login_id = $paymentOpts['loginid'];
$transaction_key = $paymentOpts['transkey'];
$amount = $payable_amt;
$fp_timestamp = time();
$fp_sequence = "DEAL" . time(); // Enter an invoice or other unique number.
$fingerprint = AuthorizeNetSIM_Form::getFingerprint($api_login_id,
  $transaction_key, $amount, $fp_sequence, $fp_timestamp)
?>

<form  name="frm_payment_auth"  method='post' action="https://test.authorize.net/gateway/transact.dll">
<input type="hidden" name="x_response_code" value="1"/>
<input type="hidden" name="x_response_subcode" value="1"/>
<input type="hidden" name="x_response_reason_code" value="1"/>
<input type="hidden" name="x_response_reason_text" value="This transaction has been approved."/>
<input type='hidden' name="x_recurring_billing" value="TRUE" />
<input type='hidden' name="x_login" value="<?php echo $api_login_id; ?>" />
<input type='hidden' name="x_email" value="<?php echo $user_email; ?>" />
<input type='hidden' name="x_Description" value="<?php echo $desc ; ?>" />
<input type='hidden' name="x_first_name" value="<?php echo $buser_shipping_name; ?>" />
<input type='hidden' name="x_phone" value="<?php echo $user_bphone; ?>" />
<input type='hidden' name="x_country" value="<?php echo $user_bcountry; ?>" />
<input type='hidden' name="x_zip" value="<?php echo $user_bpostalcode; ?>" />
<input type='hidden' name="x_state" value="<?php echo $user_bstate; ?>" />
<input type='hidden' name="x_city" value="<?php echo $user_bcity; ?>" />
<input type='hidden' name="x_address" value="<?php echo $user_baddr; ?>" />
<input type='hidden' name="x_fp_hash" value="<?php echo $fingerprint; ?>" />
<input type='hidden' name="x_amount" value="<?php echo $payable_amt; ?>" />
<input type='hidden' name="x_fp_timestamp" value="<?php echo $fp_timestamp; ?>" />
<input type='hidden' name="x_fp_sequence" value="<?php echo $fp_sequence; ?>" />
<INPUT TYPE="HIDDEN" name="x_test_request" VALUE="FALSE">
<input type='hidden' name="x_version" value="3.1">
<input type='hidden' name="x_show_form" value="payment_form">
<INPUT TYPE='hidden' name="x_receipt_link_method" VALUE="LINK">
<INPUT TYPE='hidden' name="x_receipt_link_text" VALUE="Click here to complete your transaction">
<INPUT TYPE='hidden' name="x_receipt_link_URL" VALUE="<?php echo site_url()."/?ptype=response&paymethod=anet&atransid=".$last_postid."&did=".$did1.""; ?>">
<INPUT TYPE='hidden' NAME="x_cust_id" value="<?php echo $display_name.$last_postid.$did1; ?>">
<input type='hidden' name="x_invoice_num" value="<?php echo "DEAL ".$last_postid; ?>">
<input type='hidden' name="x_cancel_url_text" value="Click here to cancel your transaction">
<input type='hidden' name="x_cancel_url" value="<?php echo site_url()."/?ptype=response&paymethod=anet&cancel_id=".$last_postid."&did=".$did1.""; ?>">

<input type='hidden' name="x_ship_to_zip" value="<?php if($user_spostalcode !=""){ echo $user_spostalcode; }else{ echo $user_bpostalcode; } ?>">
<input type='hidden' name="x_ship_to_country" value="<?php if($user_scountry !=""){ echo $user_scountry; }else{ echo $user_bcountry; }  ?>">
<input type='hidden' name="x_ship_to_state" value="<?php if($user_sstate !=""){ echo $user_sstate; }else{ echo $user_bstate; } ?>">
<input type='hidden' name="x_ship_to_city" value="<?php if($user_scity !=""){ echo $user_scity; }else{ echo $user_bcity; }  ?>">
<input type='hidden' name="x_ship_to_address" value="<?php if($user_saddr !=""){ echo $user_saddr; }else{ echo $user_baddr; } ?>">
<input type='hidden' name="x_ship_to_first_name" value="<?php if($buser_shipping_name != ""){ echo $buser_shipping_name; }else{ echo $display_name; }  ?>">

<input type='hidden' name="x_method" value="<?php echo $_REQUEST['cc_type']; ?>">
<input type='hidden' name="x_card_num" value="<?php echo $_REQUEST['cc_number']; ?>">
<input type='hidden' name="x_exp_date" value="<?php echo $_REQUEST['cc_month'].substr($_REQUEST['cc_year'],2,strlen($_REQUEST['cc_year'])); ?>">
</form>
<script>
	setTimeout("document.frm_payment_auth.submit()",20); 
</script> 

<?php
   $errors = array();
 
    if ($_POST)
    {
        $credit_card           = sanitize($_REQUEST['cc_number']);
        $expiration_month      = (int) sanitize($_POST['cc_month']);
        $expiration_year       = (int) sanitize(substr($_REQUEST['cc_year'],2,strlen($_REQUEST['cc_year'])));
        $cvv                   = sanitize($_POST['cv2']);
        $cardholder_first_name = sanitize($display_name);
        $cardholder_last_name  = sanitize('');

        $email                 = sanitize($user_email);
       

        if (!validateCreditcard_number($credit_card))
        {
            $errors['credit_card'] = "Please enter a valid credit card number";
        }
        if (!validateCreditCardExpirationDate($expiration_month, $expiration_year))
        {
            $errors['expiration_month'] = "Please enter a valid exopiration date for your credit card";
        }
        if (!validateCVV($credit_card, $cvv))
        {
            $errors['cvv'] = "Please enter the security code (CVV number) for your credit card";
        }
        if (empty($cardholder_first_name))
        {
            $errors['cardholder_first_name'] = "Please provide the card holder's first name";
        }
        if (empty($cardholder_last_name))
        {
            $errors['cardholder_last_name'] = "Please provide the card holder's last name";
        }
        
        // If there are no errors let's process the payment
        if (count($errors) === 0)
        {
            // Format the expiration date
            $expiration_date = sprintf("%04d-%02d", $expiration_year, $expiration_month);

            // Include the SDK
            require_once('./config.php');

            // Process the transaction using the AIM API
            $transaction = new AuthorizeNetAIM;
            $transaction->setSandbox(AUTHORIZENET_SANDBOX);
            $transaction->setFields(
                array(
                'amount' => '1.00',
                'card_num' => $credit_card,
                'exp_date' => $expiration_date,
                'first_name' => $cardholder_first_name,
                'last_name' => $cardholder_last_name,
                'address' => $billing_address,
                'city' => $billing_city,
                'state' => $billing_state,
                'zip' => $billing_zip,
                'email' => $email,
                'card_code' => $cvv,
                'ship_to_first_name' => $recipient_first_name,
                'ship_to_last_name' => $recipient_last_name,
                'ship_to_address' => $shipping_address,
                'ship_to_city' => $shipping_city,
                'ship_to_state' => $shipping_state,
                'ship_to_zip' => $shipping_zip,
                )
            );
            if ($response->approved)
            {
                // Transaction approved. Collect pertinent transaction information for saving in the database.
                $transaction_id     = $response->transaction_id;
                $authorization_code = $response->authorization_code;
                $avs_response       = $response->avs_response;
                $cavv_response      = $response->cavv_response;

                // Put everything in a database for later review and order processing
                // How you do this depends on how your application is designed
                // and your business needs.

                // Once we're finished let's redirect the user to a receipt page
               	$redirectUrl = site_url("/?ptype=payment_success&pid=".$last_postid);
				wp_redirect($redirectUrl);
                exit;
            }
            else if ($response->declined)
            {
                // Transaction declined. Set our error message.
                $errors['declined'] = 'Your credit card was declined by your bank. Please try another form of payment.';
            }
            else
            {
                // And error has occurred. Set our error message.
                $errors['error'] = 'We encountered an error while processing your payment. Your credit card was not charged. Please try again or contact customer service to place your order.';
            }
        }
    }

    function sanitize($value)
    {
        return trim(strip_tags($value));
    }

    function validateCreditcard_number($credit_card_number)
    {
        $firstnumber = substr($credit_card_number, 0, 1);

        switch ($firstnumber)
        {
            case 3:
                if (!preg_match('/^3\d{3}[ \-]?\d{6}[ \-]?\d{5}$/', $credit_card_number))
                {
                    return false;
                }
                break;
            case 4:
                if (!preg_match('/^4\d{3}[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $credit_card_number))
                {
                    return false;
                }
                break;
            case 5:
                if (!preg_match('/^5\d{3}[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $credit_card_number))
                {
                    return false;
                }
                break;
            case 6:
                if (!preg_match('/^6011[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $credit_card_number))
                {
                    return false;
                }
                break;
            default:
                return false;
        }

        $credit_card_number = str_replace('-', '', $credit_card_number);
        $map = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 2, 4, 6, 8, 1, 3, 5, 7, 9);
        $sum = 0;
        $last = strlen($credit_card_number) - 1;
        for ($i = 0; $i <= $last; $i++)
        {
            $sum += $map[$credit_card_number[$last - $i] + ($i & 1) * 10];
        }
        if ($sum % 10 != 0)
        {
            return false;
        }

        return true;
    }

    function validateCreditCardExpirationDate($month, $year)
    {
        if (!preg_match('/^\d{1,2}$/', $month))
        {
            return false;
        }
        else if (!preg_match('/^\d{4}$/', $year))
        {
            return false;
        }
        else if ($year < date("Y"))
        {
            return false;
        }
        else if ($month < date("m") && $year == date("Y"))
        {
            return false;
        }
        return true;
    }

    function validateCVV($cardNumber, $cvv)
    {
        $firstnumber = (int) substr($cardNumber, 0, 1);
        if ($firstnumber === 3)
        {
            if (!preg_match("/^\d{4}$/", $cvv))
            {
                return false;
            }
        }
        else if (!preg_match("/^\d{3}$/", $cvv))
        {
            return false;
        }
        return true;
    }
if (count($errors) === 0)
{
    // Format the expiration date
    $expiration_date = sprintf("%04d-%02d", $expiration_year, $expiration_month);

    // Include the SDK
    require_once('./config.php');

    // Process the transaction using the AIM API
    $transaction = new AuthorizeNetAIM;
    $transaction->setSandbox(AUTHORIZENET_SANDBOX);
    $transaction->setFields(
        array(
        'amount' => '1.00',
        'card_num' => $credit_card,
        'exp_date' => $expiration_date,
        'first_name' => $cardholder_first_name,
        'last_name' => $cardholder_last_name,
        'address' => $billing_address,
        'city' => $billing_city,
        'state' => $billing_state,
        'zip' => $billing_zip,
        'email' => $email,
        'card_code' => $cvv,
        'ship_to_first_name' => $recipient_first_name,
        'ship_to_last_name' => $recipient_last_name,
        'ship_to_address' => $shipping_address,
        'ship_to_city' => $shipping_city,
        'ship_to_state' => $shipping_state,
        'ship_to_zip' => $shipping_zip,
        )
    );
    $response = $transaction->authorizeAndCapture();
    if ($response->approved)
    {
        // Transaction approved. Collect pertinent transaction information for saving in the database.
        $transaction_id     = $response->transaction_id;
        $authorization_code = $response->authorization_code;
        $avs_response       = $response->avs_response;
        $cavv_response      = $response->cavv_response;

        // Put everything in a database for later review and order processing
        // How you do this depends on how your application is designed
        // and your business needs.

        // Once we're finished let's redirect the user to a receipt page
        header('Location: thank-you-page.php');
        exit;
    }
    else if ($response->declined)
    {
        // Transaction declined. Set our error message.
        $errors['declined'] = 'Your credit card was declined by your bank. Please try another form of payment.';
    }
    else
    {
        // And error has occurred. Set our error message.
        $errors['error'] = 'We encountered an error while processing your payment. Your credit card was not charged. Please try again or contact customer service to place your order.';

        // Collect transaction response information for possible troubleshooting
        // Since our application won't be doing this we'll comment this out for now.
        //
        // $response_subcode     = $response->response_subcode;
        // $response_reason_code = $response->response_reason_code;
    }
}