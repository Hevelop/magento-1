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
class Adyen_Payment_Model_Billing_Agreement_Observer
{
    /**
     * @event controller_action_predispatch
     * @param Varien_Event_Observer $observer
     */
    public function addMethodsToConfig(Varien_Event_Observer $observer = null)
    {
        if (Mage::app()->getStore()->isAdmin()) {
            $store = Mage::getSingleton('adminhtml/session_quote')->getStore();
        } else {
            $store = Mage::app()->getStore();
        }

        if (Mage::getStoreConfigFlag('payment/adyen_oneclick/active', $store)) {
            try {
                $this->_addOneClickMethodsToConfig($store);
                $store->setConfig('payment/adyen_oneclick/active', 0);
            } catch (Exception $e) {
                Adyen_Payment_Exception::logException($e);
            }
        }
    }


    /**
     * @param Mage_Core_Model_Store $store
     * @return $this
     */
    protected function _addOneClickMethodsToConfig(Mage_Core_Model_Store $store)
    {
        Varien_Profiler::start(__CLASS__ . '::' . __FUNCTION__);

        $customer = Mage::helper('adyen/billing_agreement')->getCurrentCustomer();

        if (!$customer || !$customer->getId()) {
            return $this;
        }

        // Get the setting Share Customer Accounts if storeId needs to be in filter
        $custAccountShareWebsiteLevel = Mage::getStoreConfig(
            Mage_Customer_Model_Config_Share::XML_PATH_CUSTOMER_ACCOUNT_SHARE,
            $store
        );

        $baCollection = Mage::getResourceModel('adyen/billing_agreement_collection');
        $baCollection->addFieldToFilter('customer_id', $customer->getId());

        if ($custAccountShareWebsiteLevel) {
            $baCollection->addFieldToFilter('store_id', $store->getId());
        }

        $baCollection->addFieldToFilter('method_code', 'adyen_oneclick');
        $baCollection->addActiveFilter();

        foreach ($baCollection as $billingAgreement) {
            // only create payment method when label is set
            if ($billingAgreement->getAgreementLabel() != null) {
                $this->_createPaymentMethodFromBA($billingAgreement, $store);
            }
        }

        Varien_Profiler::stop(__CLASS__ . '::' . __FUNCTION__);
    }


    /**
     * @param Adyen_Payment_Model_Billing_Agreement $billingAgreement
     * @param Mage_Core_Model_Store $store
     *
     * @return bool
     */
    protected function _createPaymentMethodFromBA(
        Adyen_Payment_Model_Billing_Agreement $billingAgreement,
        Mage_Core_Model_Store $store
    ) {
        $methodInstance = $billingAgreement->getPaymentMethodInstance();
        if (!$methodInstance || !$methodInstance->getConfigData('active', $store)) {
            return false;
        }

        $methodNewCode = 'adyen_oneclick_' . $billingAgreement->getReferenceId();

        $methodData = array('model' => 'adyen/adyen_oneclick')
            + $billingAgreement->getOneClickData()
            + Mage::getStoreConfig('payment/adyen_oneclick', $store);

        foreach ($methodData as $key => $value) {
            $store->setConfig('payment/' . $methodNewCode . '/' . $key, $value);
        }

        return true;
    }


    /**
     * @param string $methodCode ideal,mc,etc.
     * @param array $methodData
     * @param Mage_Core_Model_Store $store
     */
    public function createPaymentMethodFromOneClick($methodCode, $methodData = array(), Mage_Core_Model_Store $store)
    {
        $methodNewCode = 'adyen_oneclick_' . $methodCode;

        $methodData = $methodData + Mage::getStoreConfig('payment/adyen_oneclick', $store);
        $methodData['model'] = 'adyen/adyen_oneclick';
        $methodData['active'] = true;

        foreach ($methodData as $key => $value) {
            $store->setConfig('payment/' . $methodNewCode . '/' . $key, $value);
        }

        $store->setConfig('payment/adyen_oneclick/active', 0);
    }
}
