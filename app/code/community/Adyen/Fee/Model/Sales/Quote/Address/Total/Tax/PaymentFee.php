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
class Adyen_Fee_Model_Sales_Quote_Address_Total_Tax_PaymentFee extends Mage_Sales_Model_Quote_Address_Total_Tax
{

    protected $_code = 'payment_fee_tax';

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        // Makes sure you only use the address type shipping
        $items = $this->_getAddressItems($address);
        if (!count($items)) {
            return $this;
        }

        // reset totals by default (needed for some external checkout modules)
        $address->setPaymentFeeTax(0);
        $address->setBasePaymentFeeTax(0);

        if ($address->getQuote()->getId() == null) {
            return $this;
        }

        if (!$address->getPaymentFeeAmount()) {
            return $this;
        }

        $items = $address->getAllItems();
        if (!count($items)) {
            return $this;
        }

        $config = Mage::getModel('adyen_fee/tax_config');

        $quote = $address->getQuote();
        $custTaxClassId = $quote->getCustomerTaxClassId();
        $store = $quote->getStore();
        $taxCalculationModel = Mage::getSingleton('tax/calculation');
        $request = $taxCalculationModel->getRateRequest($address, $quote->getBillingAddress(), $custTaxClassId, $store);

        $PaymentFeeTaxClass = $config->getPaymentFeeTaxClass($store);

        $paymentFeeTax = 0;
        $paymentFeeBaseTax = 0;

        if ($PaymentFeeTaxClass) {
            if ($rate = $taxCalculationModel->getRate($request->setProductClassId($PaymentFeeTaxClass))) {
                $paymentFeeTax = $taxCalculationModel->calcTaxAmount(
                    $address->getPaymentFeeAmount(), $rate, false,
                    true
                );
                $paymentFeeBaseTax = $taxCalculationModel->calcTaxAmount(
                    $address->getBasePaymentFeeAmount(), $rate,
                    false, true
                );

                $address->setTaxAmount($address->getTaxAmount() + $paymentFeeTax);
                $address->setBaseTaxAmount($address->getBaseTaxAmount() + $paymentFeeBaseTax);

                $address->setGrandTotal($address->getGrandTotal() + $paymentFeeTax);
                $address->setBaseGrandTotal($address->getBaseGrandTotal() + $paymentFeeBaseTax);
            }
        }

        $address->setPaymentFeeTax($paymentFeeTax);
        $address->setBasePaymentFeeTax($paymentFeeBaseTax);

        return $this;
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $store = $address->getQuote()->getStore();
        $taxConfig = Mage::getSingleton('tax/config');
        $salesHelper = Mage::helper('sales');

        if ($taxConfig->displayCartSubtotalBoth($store) || $taxConfig->displayCartSubtotalInclTax($store)) {
            if ($address->getSubtotalInclTax() > 0) {
                $subtotalInclTax = $address->getSubtotalInclTax();
            } else {
                $subtotalInclTax = $address->getSubtotal() + $address->getTaxAmount() - $address->getShippingTaxAmount() - $address->getPaymentFeeTax();
            }

            $address->addTotal(
                array(
                    'code' => 'subtotal',
                    'title' => $salesHelper->__('Subtotal'),
                    'value' => $subtotalInclTax,
                    'value_incl_tax' => $subtotalInclTax,
                    'value_excl_tax' => $address->getSubtotal(),
                )
            );
        }

        return $this;
    }


}