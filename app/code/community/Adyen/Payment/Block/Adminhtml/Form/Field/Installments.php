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
 * Adminhtml catalog inventory "Installments" field
 *
 * @category   Adyen
 * @package    Adyen_Payment
 * @author       Adyen, Amsterdam
 */
class Adyen_Payment_Block_Adminhtml_Form_Field_Installments extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{


    /**
     * Prepare to render
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'installment_currency', array(
                'label' => Mage::helper('adyen')->__('Currency'),
                'style' => 'width:100px',
            )
        );
        $this->addColumn(
            'installment_boundary', array(
                'label' => Mage::helper('adyen')->__('Amount (incl.)'),
                'style' => 'width:100px',
            )
        );
        $this->addColumn(
            'installment_frequency', array(
                'label' => Mage::helper('adyen')->__('Maximum Number of Installments'),
                'style' => 'width:100px',
            )
        );
        $this->addColumn(
            'installment_interest', array(
                'label' => Mage::helper('adyen')->__('Interest Rate (%)'),
                'style' => 'width:100px',
            )
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('adyen')->__('Add Installment Boundary');
    }

}
