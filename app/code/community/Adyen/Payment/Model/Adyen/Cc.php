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
class Adyen_Payment_Model_Adyen_Cc extends Adyen_Payment_Model_Adyen_Abstract implements Mage_Payment_Model_Billing_Agreement_MethodInterface
{

    protected $_code = 'adyen_cc';
    protected $_formBlockType = 'adyen/form_cc';
    protected $_infoBlockType = 'adyen/info_cc';
    protected $_paymentMethod = 'cc';
    protected $_canCreateBillingAgreement = true;
    protected $_ccTypes;
    protected $_canUseForMultishipping = true;

    /**
     * 1) Called everytime the adyen_cc is called or used in checkout
     * @description Assign data to info model instance
     *
     * @param   mixed $data
     * @return  Mage_Payment_Model_Info
     */
    public function assignData($data)
    {

        if (!($data instanceof Varien_Object)) {
            $data = new Varien_Object($data);
        }

        $info = $this->getInfoInstance();

        // set number of installements
        $info->setAdditionalInformation('number_of_installments', $data->getAdditionalData());

        // save value remember details checkbox
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $info->setAdditionalInformation('store_cc', $data->getStoreCc());
        }

        $info->setCcOwner($data->getCcOwner());

        if (empty($data->getEncryptedNumber()) || empty($data->getEncryptedExpiryMonth()) || empty($data->getEncryptedExpiryYear())) {
            Mage::throwException(Mage::helper('adyen')->__('Invalid credit number card.'));
        } else {
            $session = Mage::helper('adyen')->getSession();
            $method = $this->getCode();
            $session->setData('encrypted_number_' . $method, $data->getEncryptedNumber());
            $session->setData('encrypted_expiry_month_' . $method, $data->getEncryptedExpiryMonth());
            $session->setData('encrypted_expiry_year_' . $method, $data->getEncryptedExpiryYear());
            $session->setData('screen_height_' . $method, $data-> getScreenHeight());
            $session->setData('screen_width_' . $method,  $data->getScreenWidth());
            $session->setData('color_depth_' . $method,  $data->getColorDepth());
            $session->setData('time_zone_offset_' . $method,  $data->getTimeZoneOffset());
            $session->setData('language_' . $method,  $data->getLanguage());
            $session->setData('java_enabled_' . $method, $data->getJavaEnabled());

            if (!empty($data->getEncryptedCvc())) {
                $session->setData('encrypted_cvc_' . $method, $data->getEncryptedCvc());
            }
        }


        if ($info->getAdditionalInformation('number_of_installments') != "") {
            // recalculate the totals so that extra fee is defined
            $quote = (Mage::getModel('checkout/type_onepage') !== false) ? Mage::getModel('checkout/type_onepage')->getQuote() : Mage::getModel('checkout/session')->getQuote();
            $quote->setTotalsCollectedFlag(false);
            $quote->collectTotals();
        }

        return $this;
    }

    public function validate()
    {
        parent::validate();
    }

    public function getPossibleInstallments()
    {
        // retrieving quote
        $quote = (Mage::getModel('checkout/type_onepage') !== false) ? Mage::getModel('checkout/type_onepage')->getQuote() : Mage::getModel('checkout/session')->getQuote();

        // get selected payment method for now
        $payment = $quote->getPayment();

        $ccType = null;
        if (!empty($payment) && $payment->getMethod()) {
            $info = $payment->getMethodInstance();

            $instance = $info->getInfoInstance();
            $ccType = $instance->getCcType();
        }

        $result = Mage::helper('adyen/installments')->getInstallmentForCreditCardType($ccType);

        return $result;
    }

    /**
     * @desc Specific functions for 3d secure validation
     */

    public function getOrderPlaceRedirectUrl()
    {
        $redirectUrl = Mage::getSingleton('customer/session')->getRedirectUrl();

        if (!empty($redirectUrl)) {
            Mage::getSingleton('customer/session')->unsRedirectUrl();
            return Mage::getUrl($redirectUrl);
        } else {
            return parent::getOrderPlaceRedirectUrl();
        }
    }

    /**
     * This method is called for redirect to 3D secure
     *
     * @return mixed
     */
    public function getFormUrl()
    {
        $this->_initOrder();
        $order = $this->_order;
        $payment = $order->getPayment();
        return $payment->getAdditionalInformation('issuerUrl');
    }

    public function getFormName()
    {
        return "Adyen CC";
    }

    public function getFormFields()
    {
        $this->_initOrder();
        $order = $this->_order;
        $payment = $order->getPayment();

        $adyFields = array();
        $adyFields['PaReq'] = $payment->getAdditionalInformation('paRequest');
        $adyFields['MD'] = $payment->getAdditionalInformation('md');
        $adyFields['TermUrl'] = Mage::getUrl('adyen/process/validate3d');

        return $adyFields;
    }

    /**
     * @desc setAvailableCCypes to remove MAESTRO as creditcard type for the Adyen_Subscription module
     * @param $ccTypes
     */
    public function setAvailableCCypes($ccTypes)
    {
        $this->_ccTypes = $ccTypes;
    }

    /**
     * @return mixed
     */
    public function getAvailableCCTypes()
    {
        if (!$this->_ccTypes) {
            $types = Mage::helper('adyen')->getCcTypes();
            $availableTypes = $this->_getConfigData('cctypes', 'adyen_cc');
            if ($availableTypes) {
                $availableTypes = explode(',', $availableTypes);
                foreach ($types as $code => $name) {
                    if (!in_array($code, $availableTypes)) {
                        unset($types[$code]);
                    }
                }
            }

            $this->_ccTypes = $types;
        }

        return $this->_ccTypes;
    }

    public function canCreateAdyenSubscription()
    {

        // validate if recurringType is correctly configured
        $recurringType = $this->_getConfigData('recurringtypes', 'adyen_abstract');
        if ($recurringType == "RECURRING" || $recurringType == "ONECLICK,RECURRING") {
            return true;
        }

        return false;
    }

    /**
     * @param Mage_Sales_Model_Quote|null $quote
     * @return bool
     */
    public function isAvailable($quote = null)
    {
        $isAvailable = parent::isAvailable($quote);

        if (!is_null($quote)) {
            $disableZeroTotal = Mage::getStoreConfig('payment/adyen_cc/disable_zero_total', $quote->getStoreId());
        } else {
            $disableZeroTotal = Mage::getStoreConfig('payment/adyen_cc/disable_zero_total');
        }

        if (!is_null($quote) && $quote->getGrandTotal() <= 0 && $disableZeroTotal) {
            return false;
        }

        return $isAvailable;
    }
}
