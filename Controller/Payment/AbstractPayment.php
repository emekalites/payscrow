<?php



/**
 * Created by ST Infotech pvt ltd.
 * Author: Amit Patel
 * Date: 20/06/2018
 * Time: 4:40 PM
 */

namespace Payscrow\PayscrowGateway\Controller\Payment;

use Magento\Framework\App\Action\Action;

abstract class AbstractPayment extends Action
{
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
