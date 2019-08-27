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
 * Fieldset renderer for Adyen export settings button
 */
class Adyen_Payment_Block_Adminhtml_System_Config_Fieldset_Fieldset
    extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{

    /**
     * Get config data model
     *
     * @return Mage_Adminhtml_Model_Config_Data
     */
    protected function _getConfigDataModel()
    {
        if (!$this->hasConfigDataModel()) {
            $this->setConfigDataModel(Mage::getSingleton('adminhtml/config_data'));
        }

        return $this->getConfigDataModel();
    }

    /**
     * Return collapse state
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return bool
     */
    protected function _getCollapseState($element)
    {
        $extra = Mage::getSingleton('admin/session')->getUser()->getExtra();
        if (isset($extra['configState'][$element->getId()])) {
            return $extra['configState'][$element->getId()];
        }

        return false;
    }
}
