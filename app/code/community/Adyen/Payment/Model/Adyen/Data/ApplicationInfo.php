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
 * @copyright  Copyright (c) 2018 Adyen BV (http://www.adyen.com)
 */
class Adyen_Payment_Model_Adyen_Data_ApplicationInfo extends Adyen_Payment_Model_Adyen_Data_Abstract
{
    public $adyenPaymentSource = array(
        "name" => "adyen-magento"
    );
    public $externalPlatform = array(
        "name" => "Magento"
    );

    public function __construct()
    {
        $this->externalPlatform['version'] = Mage::getVersion();
        $this->adyenPaymentSource['version'] = Mage::helper('adyen')->getExtensionVersion();
    }
}
