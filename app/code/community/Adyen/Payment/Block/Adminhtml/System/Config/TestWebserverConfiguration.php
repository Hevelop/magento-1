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
class Adyen_Payment_Block_Adminhtml_System_Config_TestWebserverConfiguration extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    /**
     * @var string
     */
    protected $_wizardTemplate = 'adyen/system/config/test_webserver_configuration.phtml';

    /**
     * Set template to itself
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate($this->_wizardTemplate);
        }

        return $this;
    }

    /**
     * Unset some non-related element parameters
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Get the button and scripts contents
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $originalData = $element->getOriginalData();
        $elementHtmlId = $element->getHtmlId();
        $this->addData(
            array_merge(
                $this->_getButtonData($elementHtmlId, $originalData)
            )
        );
        return $this->_toHtml();
    }

    /**
     * Prepare button data
     *
     * @param string $elementHtmlId
     * @param array $originalData
     * @return array
     */
    protected function _getButtonData($elementHtmlId, $originalData)
    {
        return array(
            'button_label' => Mage::helper('adyen')->__($originalData['button_label']),
            'modus' => $originalData['modus'],
            'html_id' => $elementHtmlId,
            'url_webserver_validation' => Mage::helper('adminhtml')->getUrl('adminhtml/ValidateWebserverSettings'),
            'website' => Mage::app()->getRequest()->getParam('website'),
            'store' => Mage::app()->getRequest()->getParam('store')
        );
    }


}
