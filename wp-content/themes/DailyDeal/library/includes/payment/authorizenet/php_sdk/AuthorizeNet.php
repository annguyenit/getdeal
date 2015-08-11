<?php
/**
 * The AuthorizeNet PHP SDK. Include this file in your project.
 *
 * @package AuthorizeNet
 */
require TEMPLATEPATH . '/library/includes/payment/authorizenet/php_sdk/lib/shared/AuthorizeNetRequest.php';
require TEMPLATEPATH . '/library/includes/payment/authorizenet/php_sdk/lib/shared/AuthorizeNetTypes.php';
require TEMPLATEPATH . '/library/includes/payment/authorizenet/php_sdk/lib/shared/AuthorizeNetXMLResponse.php';
require TEMPLATEPATH . '/library/includes/payment/authorizenet/php_sdk/lib/shared/AuthorizeNetResponse.php';
require TEMPLATEPATH . '/library/includes/payment/authorizenet/php_sdk/lib/AuthorizeNetAIM.php';
require TEMPLATEPATH . '/library/includes/payment/authorizenet/php_sdk/lib/AuthorizeNetARB.php';
require TEMPLATEPATH . '/library/includes/payment/authorizenet/php_sdk/lib/AuthorizeNetCIM.php';
require TEMPLATEPATH . '/library/includes/payment/authorizenet/php_sdk/lib/AuthorizeNetSIM.php';
require TEMPLATEPATH . '/library/includes/payment/authorizenet/php_sdk/lib/AuthorizeNetDPM.php';
require TEMPLATEPATH . '/library/includes/payment/authorizenet/php_sdk/lib/AuthorizeNetTD.php';
require TEMPLATEPATH . '/library/includes/payment/authorizenet/php_sdk/lib/AuthorizeNetCP.php';

if (class_exists("SoapClient")) {
    require TEMPLATEPATH . '/library/includes/payment/authorizenet/php_sdk/lib/AuthorizeNetSOAP.php';
}
/**
 * Exception class for AuthorizeNet PHP SDK.
 *
 * @package AuthorizeNet
 */
class AuthorizeNetException extends Exception
{
}