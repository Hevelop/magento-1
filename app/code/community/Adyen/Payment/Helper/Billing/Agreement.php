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
class Adyen_Payment_Helper_Billing_Agreement extends Mage_Core_Helper_Abstract
{

    /**
     * @return Mage_Customer_Model_Customer|null
     */
    public function getCurrentCustomer()
    {
        if (Mage::app()->getStore()->isAdmin()) {
            return Mage::getSingleton('adminhtml/session_quote')->getCustomer();
        }

        if ($customer = Mage::getSingleton('customer/session')->isLoggedIn()) {
            return Mage::getSingleton('customer/session')->getCustomer();
        }

        if ($this->_isPersistent()) {
            return $this->_getPersistentHelper()->getCustomer();
        }

        return null;
    }

    /**
     * Retrieve persistent helper
     *
     * @return Mage_Persistent_Helper_Session
     */
    protected function _getPersistentHelper()
    {
        return Mage::helper('persistent/session');
    }


    /**
     * @return bool
     */
    protected function _isPersistent()
    {
        if (!Mage::helper('core')->isModuleEnabled('Mage_Persistent')
            || Mage::getSingleton('customer/session')->isLoggedIn()) {
            return false;
        }

        if ($this->_getPersistentHelper()->isPersistent()) {
            return true;
        }

        return false;
    }
}