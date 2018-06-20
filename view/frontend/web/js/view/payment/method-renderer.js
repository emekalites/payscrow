/*browser:true*/
/*global define*/

/**
 * Created by ST Infotech pvt ltd.
 * Author: Amit Patel
 * Date: 20/06/2018
 * Time: 4:40 PM
 */

define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'payscrowgateway',
                component: 'Payscrow_PayscrowGateway/js/view/payment/method-renderer/payscrowgateway'
            }
        );
        return Component.extend({});
    }
);