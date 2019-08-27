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
class Adyen_Payment_Model_Source_ApplePayShippingType
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'shipping', 'label' => Mage::helper('adyen')->__('Shipping Method')),
            array('value' => 'delivery', 'label' => Mage::helper('adyen')->__('Delivery Method')),
            array('value' => 'storePickup', 'label' => Mage::helper('adyen')->__('Store Pickup Method')),
            array('value' => 'servicePickup', 'label' => Mage::helper('adyen')->__('Service Pickup Method'))
        );
    }

}