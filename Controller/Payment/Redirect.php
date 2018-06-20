<?php

/**
 * Created by ST Infotech pvt ltd.
 * Author: Amit Patel
 * Date: 20/06/2018
 * Time: 4:40 PM
 */


namespace Payscrow\PayscrowGateway\Controller\Payment;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;

class Redirect extends \Magento\Framework\App\Action\Action
{
    /**
     * @var LayoutFactory
     */
    
    protected $_viewLayoutFactory;
	public function __construct(
		\Magento\Framework\App\Action\Context $context, PageFactory $pageFactory,
		\Magento\Sales\Model\Order $salesOrderFactory,
		\Magento\Checkout\Model\Session $checkoutSession,
		\Magento\Sales\Model\Order $_order,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Framework\UrlInterface $urlInterface,
		PageFactory $viewLayoutFactory,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
		)
		{
				 $this->_storeManager = $storeManager; 
				 $this->_resultPageFactory = $pageFactory;
				 $this->_checkoutSession = $checkoutSession;
				 $this->_order = $_order; // <-- new line
				 $this->resultPageFactory = $resultPageFactory;
				 $this->_urlInterface = $urlInterface;
				 $this->_scopeConfig = $scopeConfig;
				$this->_viewLayoutFactory = $viewLayoutFactory;
				return parent::__construct($context);
		}
    

    /**
     * The redirect action is triggered by submitting/placing order
     */
    
    public function execute()
    {
		$lastorderId = $this->_checkoutSession->getLastOrderId();
		//echo $lastorderId.'test';die;
       	$layout = $this->_view->loadLayout();
		$resultPage = $this->resultPageFactory ->create();
        $blockInstance = $resultPage->getLayout()->getBlock('payscrowgateway_form');
		$blockInstance->setOrderId($lastorderId);
        $this->_view->renderLayout();
    }
    
    
}
