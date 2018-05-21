<?php
/**
 * Created by PhpStorm.
 * User: emnity
 * Date: 5/21/18
 * Time: 9:02 AM
 */

namespace Payscrow\PaymentGateway\Model;

class PaymentGateway extends \Magento\Payment\Model\Method\AbstractMethod
{
    protected $_code = 'payscrowgateway';
//    protected $_formBlockType = 'payscrowgateway/form_payscrowGateway';
//    protected $_infoBlockType = 'payscrowgateway/info_payscrowGateway';
//    protected $_isInitializeNeeded      = true;
//    protected $_canUseInternal          = true;
//    protected $_canUseForMultishipping  = false;

    public function getOrderPlaceRedirectUrl()
    {
        return $this->getUrl('payscrowgateway/payment/redirect', array('_secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ));
    }
}