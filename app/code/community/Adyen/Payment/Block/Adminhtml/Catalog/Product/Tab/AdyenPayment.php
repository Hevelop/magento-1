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
class Adyen_Payment_Block_Adminhtml_Catalog_Product_Tab_AdyenPayment extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{


//    protected function _prepareForm()
//    {
//        $product = Mage::registry('product');
//
//        $form = new Varien_Data_Form();
//        $fieldset = $form->addFieldset('tiered_price', array('legend' => Mage::helper('catalog')->__('Tier Pricing')));
//
//        $fieldset->addField('default_price', 'label', array(
//            'label' => Mage::helper('catalog')->__('Default Price'),
//            'title' => Mage::helper('catalog')->__('Default Price'),
//            'name' => 'default_price',
//            'bold' => true,
//            'value' => $product->getPrice()
//        ));
//
//        $this->setForm($form);
//    }

    /**
     * @return Mage_Catalog_Model_Product
     */
    protected function _getProduct()
    {
        return Mage::registry('product');
    }

    /**
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Adyen');
    }

    /**
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Adyen');
    }

    public function canShowTab()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

}