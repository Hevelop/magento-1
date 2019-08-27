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
class Adyen_Fee_Block_Checkout_PaymentFee extends Mage_Checkout_Block_Total_Default
{

    protected $_template = 'adyen/fee/checkout/paymentfee.phtml';
    protected $_adyenHelper;
    protected $_taxConfig;

    /**
     * initialize taxConfig model
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_taxConfig = Mage::getModel('adyen_fee/tax_config');
    }


    /**
     * Check if we need display payment fee include and exclude tax
     *
     * @return bool
     */
    public function displayBoth()
    {
        return $this->_taxConfig->displayCartPaymentFeeBoth($this->getStore());
    }

    /**
     * Check if we need display payment fee include tax
     *
     * @return bool
     */
    public function displayIncludeTax()
    {
        return $this->_taxConfig->displayCartPaymentFeeInclTax($this->getStore());
    }

    /**
     * Get payment fee amount include tax
     *
     * @return float
     */
    public function getPaymentFeeIncludeTax()
    {
        return $this->getTotal()->getAddress()->getPaymentFeeAmount() + $this->getTotal()->getAddress()->getPaymentFeeTax();
    }

    /**
     * Get payment fee amount exclude tax
     *
     * @return float
     */
    public function getPaymentFeeExcludeTax()
    {
        return $this->getTotal()->getAddress()->getPaymentFeeAmount();
    }

    /**
     * Get label for payment fee include tax
     *
     * @return float
     */
    public function getIncludeTaxLabel()
    {
        return $this->helper('adyen_fee')->__('Payment Fee Incl. Tax');
    }

    /**
     * Get label for payment fee exclude tax
     *
     * @return float
     */
    public function getExcludeTaxLabel()
    {
        return $this->helper('adyen_fee')->__('Payment Fee Excl. Tax');
    }
}