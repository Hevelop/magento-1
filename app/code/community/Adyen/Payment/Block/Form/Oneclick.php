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

/**
 * @method Adyen_Payment_Model_Adyen_Oneclick getMethod()
 */
class Adyen_Payment_Block_Form_Oneclick extends Adyen_Payment_Block_Form_Cc
{

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('adyen/form/oneclick.phtml');
    }


    /**
     * @return mixed|string
     */
    public function getMethodLabelAfterHtml()
    {
        $adyenHelper = Mage::helper('adyen');

        if (Mage::getStoreConfig('payment/adyen_abstract/title_renderer')
            == Adyen_Payment_Model_Source_Rendermode::MODE_TITLE) {
            return '';
        }

        if (!$this->hasData('_method_label_html')) {
            // get configuration of this specific payment method
            $methodCode = $this->getMethodCode();

            $variant = $adyenHelper->_getConfigData('variant', $methodCode);

            $result = Mage::getDesign()->getFilename("images/adyen/{$variant}.png", array('_type' => 'skin'));

            $imageUrl = file_exists($result)
                ? $this->getSkinUrl("images/adyen/{$variant}.png")
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
     * @return mixed
     */
    public function showCvc()
    {
        return $this->getMethod()->hasCustomerInteraction();
    }


    /**
     * @return mixed
     */
    public function getInstallments()
    {

        $adyenHelper = Mage::helper('adyen');
        $methodCode = $this->getMethodCode();
        $adyenCcType = $adyenHelper->_getConfigData('variant', $methodCode);
        if (empty($adyenCcType)) {
            $adyenCcType = $this->getRecurringDetails()['variant'];
        }

        $ccType = Mage::helper('adyen/data')->getMagentoCreditCartType($adyenCcType);
        $result = Mage::helper('adyen/installments')->getInstallmentForCreditCardType($ccType);
        return $result;
    }


    /**
     * @return mixed
     */
    public function getRecurringDetails()
    {
        return $this->getMethod()->getRecurringDetails();
    }
}
