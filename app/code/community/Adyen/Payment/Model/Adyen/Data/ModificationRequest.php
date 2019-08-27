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
class Adyen_Payment_Model_Adyen_Data_ModificationRequest extends Adyen_Payment_Model_Adyen_Data_Abstract
{

    public $anyType2anyTypeMap;
    public $authorisationCode;
    public $merchantAccount;
    public $merchantReference;
    public $modificationAmount;
    public $originalReference;
    public $applicationInfo;

    public function create(Varien_Object $payment, $amount, $merchantAccount, $pspReference = null)
    {
        $order = $payment->getOrder();
        $currency = $order->getOrderCurrencyCode();
        $incrementId = $order->getIncrementId();

        $this->anyType2anyTypeMap = null;
        $this->authorisationCode = null;
        $this->merchantAccount = $merchantAccount;
        $this->reference = $incrementId;
        if ($amount) {
            $this->modificationAmount = new Adyen_Payment_Model_Adyen_Data_Amount();
            $this->modificationAmount->value = Mage::helper('adyen')->formatAmount($amount, $currency);
            $this->modificationAmount->currency = $currency;
        }

        $this->originalReference = $pspReference;
        $this->applicationInfo = new Adyen_Payment_Model_Adyen_Data_ApplicationInfo();

        return $this;
    }

}
