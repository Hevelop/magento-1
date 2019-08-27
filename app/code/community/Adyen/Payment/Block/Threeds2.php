<?php
/**
 *                       ######
 *                       ######
 * ############    ####( ######  #####. ######  ############   ############
 * #############  #####( ######  #####. ######  #############  #############
 *        ######  #####( ######  #####. ######  #####  ######  #####  ######
 * ###### ######  #####( ######  #####. ######  #####  #####   #####  ######
 * ###### ######  #####( ######  #####. ######  #####          #####  ######
 * #############  #############  #############  #############  #####  ######
 *  ############   ############  #############   ############  #####  ######
 *                                      ######
 *                               #############
 *                               ############
 *
 * Adyen Payment Module
 *
 * Copyright (c) 2019 Adyen B.V.
 * This file is open source and available under the MIT license.
 * See the LICENSE file for more info.
 *
 * Author: Adyen <magento@adyen.com>
 */

class Adyen_Payment_Block_Threeds2 extends Mage_Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('adyen/threeds2.phtml');
        parent::__construct();
    }

    protected function getCheckout()
    {
        return Mage::getSingleton('checkout/session');
    }

    protected function _getOrder()
    {
        if ($this->getOrder()) {
            return $this->getOrder();
        } else {
            // log the exception
            Mage::log("Could not load the order:", null, "adyen_api.log");
            return null;
        }
    }

    public function getThreeds2Type()
    {
        $order = $this->_getOrder();
        $payment = $order->getPayment();
        return $payment->getAdditionalInformation('threeDS2Type');
    }

    public function getThreeds2Token()
    {
        $order = $this->_getOrder();
        $payment = $order->getPayment();
        return $payment->getAdditionalInformation('threeDS2Token');
    }


}
