<?php
/**
 * Payscrow Premium Escrow Service enables your store to easily connect with the Payscrow payment Service in Nigeria
 * Copyright (C) 2017  
 * 
 * This file is part of Payscrow/PaymentGateway.
 * 
 * Payscrow/PaymentGateway is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Payscrow\PaymentGateway\Model\Config\Source;

class OrderStatus implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [['value' => 'Pending', 'label' => __('Pending')],['value' => 'Complete', 'label' => __('Complete')],['value' => 'Processing', 'label' => __('Processing')],['value' => 'Cancelled', 'label' => __('Cancelled')]];
    }

    public function toArray()
    {
        return ['Pending' => __('Pending'),'Complete' => __('Complete'),'Processing' => __('Processing'),'Cancelled' => __('Cancelled')];
    }
}
