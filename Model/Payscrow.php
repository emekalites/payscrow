<?php


/**
 * Created by ST Infotech pvt ltd.
 * Author: Amit Patel
 * Date: 20/06/2018
 * Time: 4:40 PM
 */

namespace Payscrow\PayscrowGateway\Model;

use Magento\Payment\Model\Method\AbstractMethod;

class Payscrow extends AbstractMethod
{
    protected $_code = 'payscrowgateway';
    protected $_formBlockType = 'payscrowgateway/form_payscrowGateway';
    protected $_infoBlockType = 'payscrowgateway/info_payscrowGateway';
    protected $_isInitializeNeeded      = true;
    protected $_canUseInternal          = true;
    protected $_canUseForMultishipping  = false;

    public function getOrderPlaceRedirectUrl()
    {
       
		//$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//		$checkoutSession = $objectManager->create('\Magento\Checkout\Model\Session');
//		$_quoteManagement = $objectManager->create('\Magento\Quote\Model\QuoteManagement');
//		$_url = $objectManager->create('\Magento\Framework\UrlInterface');
//		$_responsefactory = $objectManager->create('\Magento\Framework\App\ResponseFactory');
//    	$quote = $checkoutSession->getQuote();
//                $checkoutSession
//                    ->setLastQuoteId($quote->getId())
//                    ->setLastSuccessQuoteId($quote->getId())
//                    ->clearHelperData();
//
//                $order = $_quoteManagement->submit($quote);
//
//                if ($order) {
//                    $checkoutSession->setLastOrderId($order->getId())
//                                       ->setLastRealOrderId($order->getIncrementId())
//                                       ->setLastOrderStatus($order->getStatus());
//                }
//               // $this->messageManager->addSuccess($result['message']);
//
//                //$this->_redirect('checkout/onepage/success');
//			$CustomRedirectionUrl = $_url->getUrl('payscrowgateway/payment/redirect');
//		$_responsefactory->create()->setRedirect($CustomRedirectionUrl)->sendResponse();
//		exit();
//        //return Mage::getUrl('payscrowgateway/payment/redirect', ['_secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? true : false ]);
    }

    public function isValid()
    {
        if (!$checkoutSession->getLastSuccessQuoteId()) {
            return false;
        }

        if (!$checkoutSession->getLastQuoteId() || !$checkoutSession->getLastOrderId()) {
            return false;
        }
        return true;
    }



}