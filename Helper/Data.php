<?php

/**
 * Created by ST Infotech pvt ltd.
 * Author: Amit Patel
 * Date: 20/06/2018
 * Time: 4:40 PM
 */


namespace Payscrow\PayscrowGateway\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManager;
use Magento\Store\Model\ScopeInterface;
class Data extends AbstractHelper
{
	public function __construct(
        Context $context,
        StoreManager $storeManager,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }
	public function getConfigValue($identifier)
    {
        return $this->_scopeConfig->getValue(
            $identifier,
            ScopeInterface::SCOPE_STORE
        );
    }
}