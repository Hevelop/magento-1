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

/**
 * @category   Payment Gateway
 * @package    Adyen_Payment
 * @author     Adyen
 * @property   Adyen B.V
 * @copyright  Copyright (c) 2014 Adyen BV (http://www.adyen.com)
 */
class Adyen_Payment_Block_Checkout_Success extends Mage_Checkout_Block_Onepage_Success
{
    private $order;


    /*
     * check if payment method is boleto
     */
    public function isBoletoPayment()
    {
        $this->order = Mage::getModel('sales/order')->loadByIncrementId($this->getOrderId());

        if ($this->order->getPayment() && $this->order->getPayment()->getMethod() == "adyen_boleto") {
            return true;
        }

        return false;
    }

    /*
     * get the boleto pdf url from order
     */
    public function getUrlBoletoPDF()
    {
        $result = "";

        // if isBoletoPayment is not called first load the order
        if ($this->order == null) {
            $this->order = Mage::getModel('sales/order')->loadByIncrementId($this->getOrderId());
        }

        if ($this->order->getPayment()->getMethod() == "adyen_boleto") {
            $result = $this->order->getAdyenBoletoPdf();
        }

        return $result;
    }

    /*
     * check if payment method is multibanco
     */
    public function isMultibancoPayment()
    {
        $this->order = Mage::getModel('sales/order')->loadByIncrementId($this->getOrderId());

        if ($this->order->getPayment() && $this->order->getPayment()->getMethod() == 'adyen_multibanco') {
            return true;
        }

        return false;
    }
}
