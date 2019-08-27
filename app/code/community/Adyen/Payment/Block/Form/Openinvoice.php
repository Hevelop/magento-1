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
class Adyen_Payment_Block_Form_Openinvoice extends Mage_Payment_Block_Form
{

    protected $_dateInputs = array();

    /**
     * Sales Qoute Billing Address instance
     *
     * @var Mage_Sales_Model_Quote_Address
     */
    protected $_address;

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('adyen/form/openinvoice.phtml');

        if (Mage::getStoreConfig('payment/adyen_abstract/title_renderer')
            == Adyen_Payment_Model_Source_Rendermode::MODE_TITLE_IMAGE) {
            $this->setMethodTitle('');
        }

        /* Check if the customer is logged in or not */
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            /* Get the customer data */
            $customer = Mage::getSingleton('customer/session')->getCustomer();

            // set the default value
            $this->setDate($customer->getDob());
            $this->setGender($customer->getGender());
        }
    }

    public function getMethodLabelAfterHtml()
    {
        if (Mage::getStoreConfig('payment/adyen_abstract/title_renderer')
            == Adyen_Payment_Model_Source_Rendermode::MODE_TITLE) {
            return '';
        }

        if (!$this->hasData('_method_label_html')) {
            $openinvoiceType = Mage::helper('adyen')->_getConfigData("openinvoicetypes", "adyen_openinvoice");

            $imageUrl = $this->getSkinUrl("images/adyen/{$openinvoiceType}.png");


            $labelBlock = Mage::app()->getLayout()->createBlock(
                'core/template', null, array(
                    'template' => 'adyen/payment/payment_method_label.phtml',
                    'payment_method_icon' => $imageUrl,
                    'payment_method_label' => Mage::helper('adyen')->getConfigData(
                        'title',
                        $this->getMethod()->getCode()
                    ) //,
                    //'payment_method_class' => 'adyen_openinvoice_' . $openinvoiceType
                )
            );
            $labelBlock->setParentBlock($this);

            $this->setData('_method_label_html', $labelBlock->toHtml());
        }

        return $this->getData('_method_label_html');
    }


    public function setDate($date)
    {
        $this->setTime($date ? strtotime($date) : false);
        $this->setData('date', $date);
        return $this;
    }

    public function getDay()
    {
        return $this->getTime() ? date('d', $this->getTime()) : '';
    }

    public function getMonth()
    {
        return $this->getTime() ? date('m', $this->getTime()) : '';
    }

    public function getYear()
    {
        return $this->getTime() ? date('Y', $this->getTime()) : '';
    }

    /**
     * Returns format which will be applied for DOB in javascript
     *
     * @return string
     */
    public function getDateFormat()
    {
        return Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
    }

    /**
     * Add date input html
     *
     * @param string $code
     * @param string $html
     */
    public function setDateInput($code, $html)
    {
        $this->_dateInputs[$code] = $html;
    }

    /**
     * Sort date inputs by dateformat order of current locale
     *
     * @return string
     */
    public function getSortedDateInputs()
    {
        $strtr = array(
            '%b' => '%1$s',
            '%B' => '%1$s',
            '%m' => '%1$s',
            '%d' => '%2$s',
            '%e' => '%2$s',
            '%Y' => '%3$s',
            '%y' => '%3$s'
        );

        $dateFormat = preg_replace('/[^\%\w]/', '\\1', $this->getDateFormat());

        return sprintf(
            strtr($dateFormat, $strtr),
            $this->_dateInputs['m'], $this->_dateInputs['d'], $this->_dateInputs['y']
        );
    }

    public function genderShow()
    {
        return $this->getMethod()->genderShow();
    }

    public function dobShow()
    {
        return $this->getMethod()->dobShow();
    }

    public function telephoneShow()
    {
        return $this->getMethod()->telephoneShow();
    }

    public function getAddress()
    {
        if (is_null($this->_address)) {
            if (Mage::getSingleton('customer/session')->isLoggedIn()) {
                $quote = Mage::helper('checkout/cart')->getQuote();
                $this->_address = $quote->getBillingAddress();
            } else {
                $this->_address = Mage::getModel('sales/quote_address');
            }
        }

        return $this->_address;
    }

    public function isRatePay()
    {
        return $this->getMethod()->isRatePay();
    }

    public function getRatePayId()
    {
        return $this->getMethod()->getRatePayId();
    }

    public function calculateDeviceIdentToken()
    {
        $quote = Mage::helper('checkout/cart')->getQuote();
        return md5($quote->getReservedOrderId() . date('c'));
    }

}