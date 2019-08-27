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
class Adyen_Payment_Block_Form_ApplePay extends Adyen_Payment_Block_Form_Abstract
{

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('adyen/form/apple_pay.phtml');

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
                'core/template', 'adyen-apple-pay-method-label', array(
                    'template' => 'adyen/payment/payment_method_label.phtml',
                    'payment_method_icon' => $this->getSkinUrl('images/adyen/apple_pay.png'),
                    'payment_method_label' => Mage::helper('adyen')->getConfigData(
                        'title',
                        $this->getMethod()->getCode()
                    ),
                    'payment_method_class' => $this->getMethod()->getCode()
                )
            );

            $this->setData('_method_label_html', $labelBlock->toHtml());
        }

        return $this->getData('_method_label_html');
    }

    public function getMerchantIdentifier()
    {
        return Mage::helper('adyen')->getApplePayMerchantIdentifier();
    }
}