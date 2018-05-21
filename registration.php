<?php
/**
 * Created by PhpStorm.
 * User: emnity
 * Date: 5/21/18
 * Time: 5:08 AM
 */

\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'Payscrow_PaymentGateway',
    __DIR__
);