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


/*
 * update the notification_password, ws_password_test and ws_password_live to a secure password
 */

$notificationPath = "payment/adyen_abstract/notification_password";
updateConfigValue($notificationPath);

$wsPasswordTestPath = "payment/adyen_abstract/ws_password_test";
updateConfigValue($wsPasswordTestPath);

$wsPasswordLivePath = "payment/adyen_abstract/ws_password_live";
updateConfigValue($wsPasswordLivePath);


function updateConfigValue($path)
{
    try {
        $collection = Mage::getModel('core/config_data')->getCollection()
            ->addFieldToFilter('path', array('like' => $path));

        if ($collection->count() > 0) {
            foreach ($collection as $coreConfig) {
                $oldValue = $coreConfig->getValue();

                //encrypt the data and save this
                $encryptedValue = Mage::helper('core')->encrypt($oldValue);
                $coreConfig->setValue($encryptedValue)->save();
            }
        }
    } catch (Exception $e) {
        Mage::log($e->getMessage(), Zend_Log::ERR);
    }
}

