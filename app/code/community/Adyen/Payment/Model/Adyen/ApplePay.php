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
class Adyen_Payment_Model_Adyen_ApplePay extends Adyen_Payment_Model_Adyen_Abstract
    implements Mage_Payment_Model_Billing_Agreement_MethodInterface
{

    protected $_canUseInternal = false;
    protected $_code = 'adyen_apple_pay';
    protected $_formBlockType = 'adyen/form_applePay';
    protected $_infoBlockType = 'adyen/info_applePay';
    protected $_paymentMethod = 'apple_pay';
    protected $_canCreateBillingAgreement = true;

    /**
     * Adyen_Payment_Model_Adyen_ApplePay constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $showInCheckout = $this->getConfigData('show_in_payment_step_checkout');
        if (!$showInCheckout) {
            $this->_canUseCheckout = false;
        }
    }

    /**
     * @param $data
     * @return $this
     */
    public function assignData($data)
    {
        if (!($data instanceof Varien_Object)) {
            $data = new Varien_Object((array)$data);
        }

        $info = $this->getInfoInstance();

        $info->setAdditionalInformation('allow_apple_pay', $data->getAllowApplePay());

        // save value remember details checkbox
        $info->setAdditionalInformation('token', $data->getToken());

        return $this;
    }

    /**
     * @return $this\
     */
    public function validate()
    {
        parent::validate();
        $info = $this->getInfoInstance();

        if (!$info->getAdditionalInformation('allow_apple_pay')) {
            Mage::throwException(Mage::helper('adyen')->__('ApplePay is not available make sure you have active cards in your wallet and you use a supported browser. Please select a different payment method'));
        }

        return $this;
    }
}
