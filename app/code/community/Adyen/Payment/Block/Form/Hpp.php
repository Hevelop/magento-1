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
class Adyen_Payment_Block_Form_Hpp extends Mage_Payment_Block_Form
{

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('adyen/form/hpp.phtml');

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
            if (!$this->getHppOptionsDisabled()) {
                $imgFileName = substr($this->getMethod()->getCode(), 10);
                $result = Mage::getDesign()->getFilename("images/adyen/{$imgFileName}.png", array('_type' => 'skin'));

                $isConfigDemoMode = $this->getMethod()->getConfigDataDemoMode();
                if ($isConfigDemoMode) {
                    $adyenUrl = "https://test.adyen.com";
                } else {
                    $adyenUrl = "https://live.adyen.com";
                }

                if (file_exists($result)) {
                    $imageUrl = $this->getSkinUrl("images/adyen/{$imgFileName}.png");
                } else {
                    if ($this->getMethod()->getCode() != 'adyen_ideal') {
                        $imageUrl = "{$adyenUrl}/hpp/img/pm/{$imgFileName}.png";
                    } else {
                        $imageUrl = $this->getSkinUrl("images/adyen/img_trans.gif");
                    }
                }
            } else {
                $imageUrl = $this->getSkinUrl("images/adyen/img_trans.gif");
            }

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
     * @since 0.1.0.4
     * @return type
     */
    public function getHppOptionsDisabled()
    {
        return $this->getMethod()->getHppOptionsDisabled();
    }

    public function getIssuers()
    {
        return $this->getMethod()->getIssuers();
    }

}
