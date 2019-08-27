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
class Adyen_Fee_Model_Sales_Quote_Address_Total_PaymentFee extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    protected $_code = 'payment_fee';

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);

        // Makes sure you only use the address type shipping
        $items = $this->_getAddressItems($address);
        if (!count($items)) {
            return $this;
        }

        // reset totals by default (needed for some external checkout modules)
        $address->setPaymentFeeAmount(0);
        $address->setBasePaymentFeeAmount(0);

        $adyenFeeHelper = Mage::helper('adyen_fee');
        $this->_setAmount(0);
        $this->_setBaseAmount(0);
        $quote = $address->getQuote();
        $val = $adyenFeeHelper->isPaymentFeeEnabled($quote);


        if ($address->getAllItems() && $val) {
            $basePaymentFee = $adyenFeeHelper->getPaymentFeeExclVat($address);

            if ($basePaymentFee) {
                $address->setPaymentFeeAmount($address->getQuote()->getStore()->convertPrice($basePaymentFee));
                $address->setBasePaymentFeeAmount($basePaymentFee);

                $address->setGrandTotal($address->getGrandTotal() + $address->getPaymentFeeAmount());
                $address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getBasePaymentFeeAmount());
            }
        }

        return $this;
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $amt = $address->getPaymentFeeAmount();

        if ($amt != 0) {
            $address->addTotal(
                array(
                    'code' => $this->getCode(),
                    'title' => Mage::helper('adyen_fee')->__('Payment Fee'),
                    'value' => $amt
                )
            );
        } else {
            Mage::helper('adyen_fee')->removeTotal($address, $this->getCode());
        }

        return $this;
    }
}