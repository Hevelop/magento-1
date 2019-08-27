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
class Adyen_Payment_Model_Adyen_Data_NotificationClassmap extends Varien_Object
{

    public $amount;
    public $notificationRequest;
    public $notificationRequestItem;

    public function __construct()
    {
        $this->amount = new Adyen_Payment_Model_Adyen_Data_Amount();
        $this->notificationRequest = new Adyen_Payment_Model_Adyen_Data_NotificationRequest();
        $this->notificationRequestItem = new Adyen_Payment_Model_Adyen_Data_NotificationRequestItem();
    }

    public function create()
    {
        return array(
            'Amount' => $this->amount,
            'NotificationRequest' => $this->notificationRequest,
            'NotificationRequestItem' => $this->notificationRequestItem,
        );
    }

}