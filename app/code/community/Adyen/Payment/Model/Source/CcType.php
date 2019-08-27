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
class Adyen_Payment_Model_Source_CcType
{

    public function toOptionArray()
    {
        $options = array();
        foreach (Mage::helper('adyen')->getCcTypes() as $code => $data) {
            $options[] = array(
                'value' => $code,
                'label' => $data['name']
            );
        }

        return $options;
    }

    public function toOptionHash()
    {
        $types = Mage::helper('adyen')->getCcTypes();

        //Return the following key-values: "Magento CC code" -> "CC name"
        return array_reduce(
            $types, function ($carry, $item) {
            $carry[$item['code']] = $item['name'];
            return $carry;
            }
        );
    }
}
