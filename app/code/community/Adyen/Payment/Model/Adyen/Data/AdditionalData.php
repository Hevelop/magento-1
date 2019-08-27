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
class Adyen_Payment_Model_Adyen_Data_AdditionalData extends Adyen_Payment_Model_Adyen_Data_Abstract
{
    public $entry = array();

    public function addEntry($key, $value)
    {
        $kv = new Adyen_Payment_Model_Adyen_Data_AdditionalDataKVPair();
        $kv->key = new SoapVar($key, XSD_STRING, "string", "http://www.w3.org/2001/XMLSchema");
        $kv->value = new SoapVar($value, XSD_STRING, "string", "http://www.w3.org/2001/XMLSchema");
        $this->entry[] = $kv;
    }

    public function toArray()
    {
        $data = array();
        foreach ($this->entry as $kv) {
            $data[$kv->key] = $kv->value;
        }

        return $data;
    }
}
