<?php



/**
 * Created by ST Infotech pvt ltd.
 * Author: Amit Patel
 * Date: 20/06/2018
 * Time: 4:40 PM
 */

namespace Payscrow\PayscrowGateway\Block\Info;

use Magento\Payment\Block\Info;

class PayscrowGateway extends Info
{
    protected function _prepareSpecificInformation($transport = null)
    {
        if (null !== $this->_paymentSpecificInformation)
        {
            return $this->_paymentSpecificInformation;
        }

        $data = [];
        if ($this->getInfo()->getCustomFieldOne())
        {
            $data[__('Custom Field One')] = $this->getInfo()->getCustomFieldOne();
        }

        if ($this->getInfo()->getCustomFieldTwo())
        {
            $data[__('Custom Field Two')] = $this->getInfo()->getCustomFieldTwo();
        }

        $transport = parent::_prepareSpecificInformation($transport);

        return $transport->setData(array_merge($data, $transport->getData()));
    }
    
}