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
class Adyen_Payment_Block_Form_Boleto extends Mage_Payment_Block_Form
{

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('adyen/form/boleto.phtml');

        if (Mage::getStoreConfig('payment/adyen_abstract/title_renderer')
            == Adyen_Payment_Model_Source_Rendermode::MODE_TITLE_IMAGE) {
            $this->setMethodTitle('');
        }
    }

    public function getMethodLabelAfterHtml()
    {
        if (Mage::getStoreConfig('payment/adyen_abstract/title_renderer')
            == Adyen_Payment_Model_Source_Rendermode::MODE_TITLE) {
            return '';
        }

        if (!$this->hasData('_method_label_html')) {
            $labelBlock = Mage::app()->getLayout()->createBlock(
                'core/template', null, array(
                    'template' => 'adyen/payment/payment_method_label.phtml',
                    'payment_method_icon' => $this->getSkinUrl('images/adyen/img_trans.gif'),
                    'payment_method_label' => Mage::helper('adyen')->getConfigData(
                        'title',
                        $this->getMethod()->getCode()
                    ),
                    'payment_method_class' => $this->getMethod()->getCode()
                )
            );
            $labelBlock->setParentBlock($this);

            $this->setData('_method_label_html', $labelBlock->toHtml());
        }

        return $this->getData('_method_label_html');
    }

    /**
     * Retrieve availables boleto card types
     *
     * @return array
     */
    public function getBoletoAvailableTypes()
    {
        return $this->getMethod()->getAvailableBoletoTypes();
    }


    public function getFirstname()
    {
        $firstname = "";

        // check if user is logged in
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            /* Get the customer data */
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            $firstname = $customer->getFirstname();
        } else {
            $firstname = Mage::getSingleton('checkout/session')->getQuote()->getBillingAddress()->getFirstname();
        }

        return $firstname;
    }

    public function getLastname()
    {
        $lastname = "";

        // check if user is logged in
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            /* Get the customer data */
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            $lastname = $customer->getLastname();
        } else {
            $lastname = Mage::getSingleton('checkout/session')->getQuote()->getBillingAddress()->getLastname();
        }

        return $lastname;
    }

    public function getUseTaxvat()
    {
        return $this->getMethod()->getUseTaxvat();
    }

    public function getTaxvat()
    {
        $taxvat = "";

        // check if user is logged in
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            /* Get the customer data */
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            $taxvat = $customer->getTaxvat();
        } else {
            //getCustomerTaxvat
            $taxvat = Mage::getSingleton('checkout/session')->getQuote()->getCustomerTaxvat();
        }

        return $taxvat;
    }

}
