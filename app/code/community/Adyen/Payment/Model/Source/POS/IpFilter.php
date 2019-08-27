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
 * @author     AAOO
 * @property   AAOO Tech Ltd.
 * @copyright  Copyright (c) 2016 AAOO Tech Ltd. (http://www.aaoo-tech.com)
 */
class Adyen_Payment_Model_Source_POS_IpFilter
{
    public function toOptionArray()
    {
        $_options = array(
            array('value' => '0', 'label' => 'Disabled'),
            array('value' => '1', 'label' => 'Specific IPs'),
            array('value' => '2', 'label' => 'IP Range'),
        );
        return $_options;
    }

    public function toOptionHash()
    {
        return array(
            '0' => 'Disabled',
            '1' => 'Specific IPs',
            '2' => 'IP Range',
        );
    }
}
