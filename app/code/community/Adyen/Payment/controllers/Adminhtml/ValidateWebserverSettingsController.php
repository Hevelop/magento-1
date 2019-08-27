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
class Adyen_Payment_Adminhtml_ValidateWebserverSettingsController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $result = false;

        $modus = $this->getRequest()->getParam('modus');
        $username = $this->getRequest()->getParam('username');
        $password = $this->getRequest()->getParam('password');

        // check if password is encrypted if so get it from database
        if (preg_match('/^\*+$/', $password)) {
            $websiteCode = Mage::app()->getRequest()->getParam('website');
            $storeCode = Mage::app()->getRequest()->getParam('store');

            if ($storeCode) {
                $store = Mage::getModel('core/store')->load($storeCode);
                $storeId = $store->getId();
            } elseif ($websiteCode) {
                $website = Mage::getModel('core/website')->load($websiteCode);
                $storeId = $website->getDefaultGroup()->getDefaultStoreId();
            } else {
                // the default
                $storeId = 0;
            }

            if ($modus == 'test') {
                $configValue = 'ws_password_test';
            } else {
                $configValue = 'ws_password_live';
            }

            $password = Mage::helper('core')->decrypt(
                Mage::helper('adyen')->getConfigData(
                    $configValue,
                    'adyen_abstract', $storeId
                )
            );
        }

        $ch = curl_init();
        if ($modus == 'test') {
            curl_setopt($ch, CURLOPT_URL, "https://pal-test.adyen.com/pal/adapter/httppost?Payment");
        } else {
            curl_setopt($ch, CURLOPT_URL, "https://pal-live.adyen.com/pal/adapter/httppost?Payment");
        }

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $results = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpStatus == 200) {
            $result = true;
        }

        $this->getResponse()
            ->setHttpResponseCode(200)
            ->setHeader('Content-type', 'application/html', true)
            ->setBody($result);

        return $this;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/config/payment');
    }
}