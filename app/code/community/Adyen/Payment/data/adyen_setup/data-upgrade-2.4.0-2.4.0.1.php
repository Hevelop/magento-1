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
 * clear the field payment/adyen_hpp/allowspecific because this is not a setting anymore
 */

$notificationPath = "payment/adyen_hpp/allowspecific";
updateConfigValueNotificationPath($notificationPath);


// needs to be unique function name otherwise clean install will fail
function updateConfigValueNotificationPath($path)
{
    try {
        $collection = Mage::getModel('core/config_data')->getCollection()
            ->addFieldToFilter('path', array('like' => $path));

        if ($collection->count() > 0) {
            foreach ($collection as $coreConfig) {
                $coreConfig->setValue('0')->save();
            }
        }
    } catch (Exception $e) {
        Mage::log($e->getMessage(), Zend_Log::ERR);
    }
}

