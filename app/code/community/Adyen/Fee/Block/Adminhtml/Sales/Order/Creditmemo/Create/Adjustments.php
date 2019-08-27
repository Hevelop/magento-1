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
class Adyen_Fee_Block_Adminhtml_Sales_Order_Creditmemo_Create_Adjustments extends Mage_Adminhtml_Block_Template
{
    protected $_source;

    /**
     * Initialize creditmemo agjustment totals
     *
     * @return Mage_Tax_Block_Sales_Order_Tax
     */
    public function initTotals()
    {
        $parent = $this->getParentBlock();
        $this->_source = $parent->getSource();
        $total = new Varien_Object(
            array(
                'code' => 'adjust_adyen_fee_payment_fee',
                'block_name' => $this->getNameInLayout()
            )
        );

        // remove totals because you only want to show editable field
        $parent->removeTotal('payment_fee_excl');
        $parent->removeTotal('payment_fee_incl');

        $parent->addTotalBefore($total, 'agjustments'); // Yes, misspelled in Magento Core
        return $this;
    }

    public function getSource()
    {
        return $this->_source;
    }

    /**
     * Get credit memo shipping amount depend on configuration settings
     * @return float
     */
    public function geAdyenPaymentInvoiceFeeAmount()
    {
        $fee = null;
        $creditmemo = $this->getSource();
        if ($creditmemo) {
            if ($creditmemo->getPaymentFeeAmount() !== null) {
                $source = $this->getSource();
                $taxConfig = Mage::getSingleton('adyen_fee/tax_config');

                if ($taxConfig->displaySalesPaymentFeeInclTax($source->getOrder()->getStoreId())) {
                    $fee = $creditmemo->getPaymentFeeAmount() + $creditmemo->getPaymentFeeTax();
                } else {
                    $fee = $creditmemo->getPaymentFeeAmount();
                }

                $fee = Mage::app()->getStore()->roundPrice($fee);
            }
        }

        return $fee;
    }

    /**
     * Get label for shipping total based on configuration settings
     * @return string
     */
    public function getAdyenPaymentFeeInvoiceFeeLabel()
    {
        $taxConfig = Mage::getSingleton('adyen_fee/tax_config');
        $source = $this->getSource();

        if ($taxConfig->displaySalesPaymentFeeInclTax($source->getOrder()->getStoreId())) {
            $label = $this->helper('adyen')->__('Refund') . " " . $this->helper('adyen')->__('Payment Fee (Incl.Tax)');
        } elseif ($taxConfig->displaySalesPaymentFeeBoth($source->getOrder()->getStoreId())) {
            $label = $this->helper('adyen')->__('Refund') . " " . $this->helper('adyen')->__('Payment Fee (Excl.Tax)');
        } else {
            $label = $this->helper('adyen')->__('Refund') . " " . $this->helper('adyen')->__('Payment Fee ');
        }

        return $label;
    }

}