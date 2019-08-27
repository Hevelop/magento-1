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
class Adyen_Payment_Model_Adyen_Boleto extends Adyen_Payment_Model_Adyen_Abstract
{

    protected $_code = 'adyen_boleto';
    protected $_formBlockType = 'adyen/form_boleto';
    protected $_infoBlockType = 'adyen/info_boleto';
    protected $_paymentMethod = 'boleto';
    protected $_canUseCheckout = true;
    protected $_canUseInternal = true;
    protected $_canUseForMultishipping = true;

    /**
     * 1)Called everytime the adyen_boleto is called or used in checkout
     * @descrition Assign data to info model instance
     *
     * @param   mixed $data
     * @return  Mage_Payment_Model_Info
     */
    public function assignData($data)
    {
        if (!($data instanceof Varien_Object)) {
            $data = new Varien_Object($data);
        }

        // get delivery date
        $delivery_days = (int)$this->_getConfigData('delivery_days', 'adyen_boleto');
        $delivery_days = (!empty($delivery_days)) ? $delivery_days : 5;
        $delivery_date = date(
            "Y-m-d\TH:i:s ",
            mktime(date("H"), date("i"), date("s"), date("m"), date("j") + $delivery_days, date("Y"))
        );

        $info = $this->getInfoInstance();
        $boleto = array(
            'firstname' => $data->getFirstname(),
            'lastname' => $data->getLastname(),
            'social_security_number' => $data->getSocialSecurityNumber(),
            'selected_brand' => $data->getBoletoType(),
            'delivery_date' => $delivery_date
        );

        $info = $this->getInfoInstance();
        $info->setPoNumber(serialize($boleto));
        $info->setCcType($data->getBoletoType());

        return $this;
    }

    public function getUseTaxvat()
    {
        return $this->_getConfigData('use_taxvat', 'adyen_boleto');
    }
}
