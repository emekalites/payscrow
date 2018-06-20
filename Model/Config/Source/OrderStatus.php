<?php
/**
 * Created by PhpStorm.
 * User: emnity
 * Date: 6/20/18
 * Time: 1:18 PM
 */

namespace Payscrow\PayscrowGateway\Model\Config\Source;

class OrderStatus implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [['value' => 'Pending', 'label' => __('Pending')], ['value' => 'Complete', 'label' => __('Complete')], ['value' => 'Processing', 'label' => __('Processing')], ['value' => 'Cancelled', 'label' => __('Cancelled')]];
    }
    public function toArray()
    {
        return ['Pending' => __('Pending'), 'Complete' => __('Complete'), 'Processing' => __('Processing'), 'Cancelled' => __('Cancelled')];
    }
}