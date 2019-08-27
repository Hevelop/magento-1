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
class Adyen_Fee_Block_Adminhtml_Sales_Order_Invoice_Totals extends Mage_Adminhtml_Block_Sales_Order_Invoice_Totals
{

    /**
     * Initialize order totals array
     *
     * @return Mage_Sales_Block_Order_Totals
     */
    protected function _initTotals()
    {
        parent::_initTotals();

        $store = $this->getOrder()->getStore()->getId();
        $taxConfig = Mage::getModel('adyen_fee/tax_config');

        if ($taxConfig->displaySalesPaymentFeeBoth($store)) {
            $this->addPaymentFeeWithTax(true);
            $this->addPaymentFeeWithoutTax(true);
        } elseif ($taxConfig->displaySalesPaymentFeeInclTax($store)) {
            $this->addPaymentFeeWithTax();
        } else {
            $this->addPaymentFeeWithoutTax();
        }

        if ($this->getSource()->getPaymentPercentageFee() != 0) {
            $this->addTotal(
                new Varien_Object(
                    array(
                        'code' => 'payment_percentage_fee',
                        'strong' => false,
                        'value' => $this->getSource()->getPaymentPercentageFee(),
                        'base_value' => $this->getSource()->getBasePaymentPercentageFee(),
                        'label' => $this->helper('adyen')->__('Payment Percentage Fee'),
                        'area' => '',
                    )
                ),
                'subtotal'
            );
        }

        if ($this->getSource()->getPaymentInstallmentFeeAmount() != 0) {
            $this->addTotal(
                new Varien_Object(
                    array(
                        'code' => 'payment_installment_fee',
                        'strong' => false,
                        'value' => $this->getSource()->getPaymentInstallmentFeeAmount(),
                        'base_value' => $this->getSource()->getBasePaymentInstallmentFeeAmount(),
                        'label' => $this->helper('adyen')->__('Payment Fee Installments'),
                        'area' => '',
                    )
                ),
                'subtotal'
            );
        }

        return $this;
    }

    /**
     * Add PaymentFee without Tax to totals array
     *
     * @param bool|false $addTaxIndicationLabel
     */
    protected function addPaymentFeeWithoutTax($addTaxIndicationLabel = false)
    {
        if ($addTaxIndicationLabel) {
            $label = $this->helper('adyen')->__('Payment Fee (Excl.Tax)');
        } else {
            $label = $this->helper('adyen')->__('Payment Fee');
        }

        if ($this->getSource()->getPaymentFeeAmount() != 0) {
            $this->addTotal(
                new Varien_Object(
                    array(
                        'code' => 'payment_fee_excl',
                        'strong' => false,
                        'value' => $this->getSource()->getPaymentFeeAmount(),
                        'base_value' => $this->getSource()->getBasePaymentFeeAmount(),
                        'label' => $label,
                        'area' => '',
                    )
                ),
                'subtotal'
            );
        }
    }

    /**
     * Add PaymentFee with Tax to totals array
     *
     * @param bool|false $addTaxIndicationLabel
     */
    protected function addPaymentFeeWithTax($addTaxIndicationLabel = false)
    {
        if ($addTaxIndicationLabel) {
            $label = $this->helper('adyen')->__('Payment Fee (Incl.Tax)');
        } else {
            $label = $this->helper('adyen')->__('Payment Fee');
        }

        if ($this->getSource()->getPaymentFeeAmount() != 0) {
            $this->addTotal(
                new Varien_Object(
                    array(
                        'code' => 'payment_fee_incl',
                        'strong' => false,
                        'value' => $this->getSource()->getPaymentFeeAmount() + $this->getSource()->getPaymentFeeTax(),
                        'base_value' => $this->getSource()->getBasePaymentFeeAmount() + $this->getSource()->getPaymentFeeTax(),
                        'label' => $label,
                        'area' => '',
                    )
                ),
                'subtotal'
            );
        }
    }
}