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
class Adyen_Fee_Model_Tax_Config extends Mage_Tax_Model_Config
{

    // tax classes
    const CONFIG_XML_PATH_PAYMENT_FEE_TAX_CLASS = 'tax/classes/payment_fee_tax_class';

    // tax calculation
    const CONFIG_XML_PATH_PAYMENT_FEE_INCLUDES_TAX = 'tax/calculation/payment_fee_includes_tax';

    /**
     * Shopping cart display settings
     */
    const XML_PATH_DISPLAY_CART_PAYMENT_FEE = 'tax/cart_display/payment_fee';

    /**
     * Shopping cart display settings
     */
    const XML_PATH_DISPLAY_SALES_PAYMENT_FEE = 'tax/sales_display/payment_fee';

    /**
     * @var $_paymentFeePriceIncludeTax bool
     */
    protected $_paymentFeePriceIncludeTax = null;

    /*
     * Will call normal Mage::getStoreConfig
     * It's in it's own function, so it can be mocked in tests
     *
     * @param string $field
     * @param string $storeId
     *
     * @return string
     */
    protected function _getConfigDataCall($field, $storeId)
    {
        return Mage::getStoreConfig($field, $storeId);
    }

    /**
     * Get tax class id specified for payment fee tax estimation
     *
     * @param   store $store
     * @return  int
     */
    public function getPaymentFeeTaxClass($store = null)
    {
        return (int)$this->_getConfigDataCall(self::CONFIG_XML_PATH_PAYMENT_FEE_TAX_CLASS, $store);
    }

    /**
     * Check if payment fee prices include tax
     *
     * @param   store $store
     * @return  bool
     */
    public function paymentFeePriceIncludesTax($store = null)
    {
        if ($this->_paymentFeePriceIncludeTax === null) {
            $this->_paymentFeePriceIncludeTax = (bool)$this->_getConfigDataCall(
                self::CONFIG_XML_PATH_PAYMENT_FEE_INCLUDES_TAX,
                $store
            );
        }

        return $this->_paymentFeePriceIncludeTax;
    }

    public function displayCartPaymentFeeInclTax($store = null)
    {
        return $this->_getConfigDataCall(
            self::XML_PATH_DISPLAY_CART_PAYMENT_FEE,
            $store
        ) == self::DISPLAY_TYPE_INCLUDING_TAX;
    }

    public function displayCartPaymentFeeExclTax($store = null)
    {
        return $this->_getConfigDataCall(
            self::XML_PATH_DISPLAY_CART_PAYMENT_FEE,
            $store
        ) == self::DISPLAY_TYPE_EXCLUDING_TAX;
    }

    public function displayCartPaymentFeeBoth($store = null)
    {
        return $this->_getConfigDataCall(self::XML_PATH_DISPLAY_CART_PAYMENT_FEE, $store) == self::DISPLAY_TYPE_BOTH;
    }

    public function displaySalesPaymentFeeInclTax($store = null)
    {
        return $this->_getConfigDataCall(
            self::XML_PATH_DISPLAY_SALES_PAYMENT_FEE,
            $store
        ) == self::DISPLAY_TYPE_INCLUDING_TAX;
    }

    public function displaySalesPaymentFeeExclTax($store = null)
    {
        return $this->_getConfigDataCall(
            self::XML_PATH_DISPLAY_SALES_PAYMENT_FEE,
            $store
        ) == self::DISPLAY_TYPE_EXCLUDING_TAX;
    }

    public function displaySalesPaymentFeeBoth($store = null)
    {
        return $this->_getConfigDataCall(self::XML_PATH_DISPLAY_SALES_PAYMENT_FEE, $store) == self::DISPLAY_TYPE_BOTH;
    }

}