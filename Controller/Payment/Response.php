<?php

/**
 * Created by ST Infotech pvt ltd.
 * Author: Amit Patel
 * Date: 20/06/2018
 * Time: 4:40 PM
 */

namespace Payscrow\PayscrowGateway\Controller\Payment;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Action\Action;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\OrderFactory;

class Response extends AbstractPayment
{
    /**
     * @var OrderFactory
     */
    
    protected $_modelOrderFactory;

    public function __construct(Context $context, 
        OrderFactory $modelOrderFactory)
    {
        $this->_modelOrderFactory = $modelOrderFactory;

        parent::__construct($context);
    }

    /**
     * The response being returned by gateway is processed here
     */
    
    public function execute()
    {
        if ($this->getRequest()->isPost())
        {
            $response = file_get_contents('php://input');
            $params = json_decode($response, true);

            $orderId = isset($params[ 'ref' ]) ? $params[ 'ref' ]: null; // Generally sent by gateway

            //                        lets validate the response is from payscrow
            if (isset($params[ 'transactionId' ]))
            {
                $gatewayUrl = "https://www.payscrow.net/api/paymentconfirmation?transactionId={$params['transactionId']}";
                $result = $this->verifyRequest($gatewayUrl);
            }
            else
            {
                $result = false;
            }

            if (isset($params['statusCode']))
            {
                $statusDescription = "Payscrow confirmed this order as: {$params[ 'statusDescription' ]}";

                switch ($params[ 'statusCode' ])
                {
                    case "00":

                        if ($result && $result[ 'statusCode' ] == $params[ 'statusCode' ])
                        {
                            // Payment was successful, so update the order's state, send order email and move to the success page
                            $order = $this->_modelOrderFactory->create();

                            $order->loadByIncrementId($orderId);
                            $grandTotal = number_format($order->getBaseGrandTotal(), 2, '.', '');

                            if ((float) $grandTotal == ( isset($result[ 'amountPaid' ])
                                    ? $result[ 'amountPaid' ]
                                    : null )
                            )
                            {
                                $order->setState( Order::STATE_PROCESSING, true, $statusDescription
                                );

                                $order->sendNewOrderEmail();
                                $order->setEmailSent(true);

                                $order->save();

                                ObjectManager::getInstance()->get('Magento\Checkout\Model\Session')->unsQuoteId();
                            }
                        }
                        break;
                    case "01":

                        if ($result && $result[ 'statusCode' ] == $params[ 'statusCode' ])
                        {
                            // payment refunded
                            $order = $this->_modelOrderFactory->create();
                            $order->loadByIncrementId($orderId);
                            $order->setState(
                                Order::STATE_CLOSED, true, $statusDescription
                            );
                            $order->sendRefundOrderEmail();
                            $order->setEmailSent(true);
                            $order->save();
                        }
                        break;

                    case "03":
                        /**
                         * The cancel action is triggered when an order is cancelled from gateway
                         */
                        // There is a problem in the response we got
                        
                        if ($result && $result[ 'statusCode' ] == $params[ 'statusCode' ])
                        {
                            if (ObjectManager::getInstance()->get('Magento\Checkout\Model\Session')->getLastRealOrderId())
                            {
                                $order = $this->_modelOrderFactory->create()->loadByIncrementId(
                                    ObjectManager::getInstance()->get('Magento\Checkout\Model\Session')->getLastRealOrderId()
                                );
                                if ($order->getId())
                                {
                                    // Flag the order as 'cancelled' and save it
                                    $order->cancel()->setState( Order::STATE_CANCELED, true, $statusDescription)->save();
                                }
                            }
                        }
                        break;
                }
            }
        }

        if ($this->getRequest()->isGet())
        {
            $params = $this->getRequest()->getParams();
            switch ($params[ 'statusCode' ])
            {
                case "00":

                    Action::_redirect( 'checkout/onepage/success', [ '_secure' => isset($_SERVER[ 'HTTPS' ]) && $_SERVER[ 'HTTPS' ] != 'off'? true : false ] );

                    break;
                case "01":
                    Action::_redirect('');
                    break;

                case "03":
                    /**
                     * The cancel action is triggered when an order is cancelled from gateway
                     */
                    // There is a problem in the response we got
                    
                    Action::_redirect(
                        'checkout/onepage/failure', [ '_secure' => isset($_SERVER[ 'HTTPS' ]) && $_SERVER[ 'HTTPS' ] != 'off' ? true : false ]
                    );
                    break;
                default:
                    // Back to merchant - reorder
                    Action::_redirect(
                        'vtweb/payment/reorder', [ '_secure' => isset($_SERVER[ 'HTTPS' ]) && $_SERVER[ 'HTTPS' ] != 'off' ? true : false ]
                    );
            }
        }

        else{
            Action::_redirect('');
        }



    }

    private function verifyRequest( $gatewayUrl )
    {
        if (function_exists('curl_init'))
        {
            $curl = curl_init();
            curl_setopt_array(
                $curl,  [ CURLOPT_URL => $gatewayUrl,
                         CURLOPT_RETURNTRANSFER => true,
                         CURLOPT_FOLLOWLOCATION => 1,
                         CURLOPT_HTTPHEADER => [ 'Content-Type: application/json', 'Accept: application/json'],
                         CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9'
                        ]
            );

            $result = curl_exec($curl);

            if ($errno = curl_errno($curl))
            {
                $error_message = curl_strerror($errno);
                //return "cURL error ({$errno}):\n {$error_message}";
            }

            curl_close($curl);
        }
        else
        {
            $result = file_get_contents(
                $gatewayUrl
            );
        }

        if ($result)
        {
            $result = json_decode($result, true);
        }

        return $result;
    }
    

}
