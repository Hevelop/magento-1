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
class Adyen_Fee_Block_Adminhtml_System_Config_HppPaymentMethodFee
    extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    public function __construct()
    {
        $this->addColumn(
            'code', array(
                'label' => Mage::helper('adyen')->__('Payment Method Code'),
                'style' => 'width:250px',
            )
        );
        $this->addColumn(
            'amount', array(
                'label' => Mage::helper('core')->__('Fixed costs'),
                'style' => 'width:100px',
            )
        );

        $this->addColumn(
            'percentage', array(
                'label' => Mage::helper('core')->__('Variable costs (%)'),
                'style' => 'width:100px',
            )
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('core')->__('Add Fee');

        parent::__construct();
    }
}
