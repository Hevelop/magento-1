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
class Adyen_Payment_Block_Form_Cc extends Mage_Payment_Block_Form_Cc
{

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('adyen/form/cc.phtml');

        if (Mage::getStoreConfig('payment/adyen_abstract/title_renderer')
            == Adyen_Payment_Model_Source_Rendermode::MODE_TITLE_IMAGE
        ) {
            $this->setMethodTitle('');
        }
    }

    public function getMethodLabelAfterHtml()
    {
        if (Mage::getStoreConfig('payment/adyen_abstract/title_renderer')
            == Adyen_Payment_Model_Source_Rendermode::MODE_TITLE
        ) {
            return '';
        }

        if (!$this->hasData('_method_label_html')) {
            $imgFileName = 'cc_border';
            $result = Mage::getDesign()->getFilename("images/adyen/{$imgFileName}.png", array('_type' => 'skin'));

            $imageUrl = file_exists($result)
                ? $this->getSkinUrl("images/adyen/{$imgFileName}.png")
                : $this->getSkinUrl("images/adyen/img_trans.gif");

            $labelBlock = Mage::app()->getLayout()->createBlock(
                'core/template', null, array(
                    'template' => 'adyen/payment/payment_method_label.phtml',
                    'payment_method_icon' => $imageUrl,
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
     * Retrieve availables credit card types
     *
     * @return array
     */
    public function getCcAvailableTypes()
    {
        return $this->getMethod()->getAvailableCCTypes();
    }

    public function getOriginKey()
    {
        $result = $this->getMethod()->originKeys();

        return $result;
    }

    public function getPossibleInstallments()
    {
        return $this->getMethod()->getPossibleInstallments();
    }

    public function hasInstallments()
    {
        return Mage::helper('adyen/installments')->isInstallmentsEnabled();
    }

    public function canCreateBillingAgreement()
    {
        return $this->getMethod()->canCreateBillingAgreement();
    }

    /**
     * If MOTO for backend orders is turned on don't show CVC field in backend order creation
     *
     * @return boolean
     */
    public function hasVerification()
    {

        // if backend order and moto payments is turned on don't show cvc
        if (Mage::app()->getStore()->isAdmin() && $this->getMethod()->getCode() == "adyen_cc") {
            $store = Mage::getSingleton('adminhtml/session_quote')->getStore();
            if (Mage::getStoreConfigFlag('payment/adyen_cc/enable_moto', $store)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return Mage_Sales_Model_Quote|null
     */
    protected function _getQuote()
    {
        if (Mage::app()->getStore()->isAdmin()) {
            return Mage::getSingleton('adminhtml/session_quote')->getQuote();
        }

        return Mage::helper('checkout/cart')->getQuote();
    }

    public function getQuoteId()
    {
        $quote = $this->_getQuote();
        return $quote->getId();
    }

}
