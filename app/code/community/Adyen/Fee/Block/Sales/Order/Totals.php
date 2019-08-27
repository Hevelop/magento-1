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
class Adyen_Fee_Block_Sales_Order_Totals extends Mage_Sales_Block_Order_Totals
{

    /**
     * Initialize order totals array
     *
     * @return Mage_Sales_Block_Order_Totals
     */
    protected function _initTotals()
    {
        parent::_initTotals();

        if (((float)$this->getSource()->getPaymentFeeAmount()) != 0) {
            $this->addTotal(
                new Varien_Object(
                    array(
                        'code' => 'payment_fee',
                        'strong' => false,
                        'value' => $this->getSource()->getPaymentFeeAmount(),
                        'base_value' => $this->getSource()->getBasePaymentFeeAmount(),
                        'label' => $this->helper('adyen')->__('Payment Fee'),
                        'area' => '',
                    )
                ),
                'subtotal'
            );
        }

        if (((float)$this->getSource()->getPaymentPercentageFee()) != 0) {
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

        if (((float)$this->getSource()->getPaymentInstallmentFeeAmount()) != 0) {
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
}