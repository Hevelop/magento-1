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
class Adyen_Payment_Block_Adminhtml_System_Config_Fieldset_Method
    extends Adyen_Payment_Block_Adminhtml_System_Config_Fieldset_Fieldset
{
    /**
     * Check whether current payment method is enabled
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @param callback|null $configCallback
     * @return bool
     */
    protected function _isPaymentEnabled($element)
    {
        $groupConfig = $this->getGroup($element)->asArray();
        $activityPath = isset($groupConfig['activity_path']) ? $groupConfig['activity_path'] : '';

        if (empty($activityPath)) {
            return false;
        }

        // for ideal look at adyen HPP configuration
        if ($activityPath == "payment/adyen_ideal/active") {
            $activityPath = "payment/adyen_hpp/active";
        }

        $isPaymentEnabled = (bool)(string)$this->_getConfigDataModel()->getConfigDataValue($activityPath);

        return (bool)$isPaymentEnabled;
    }

    /**
     * Return header title part of html for payment solution
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getHeaderTitleHtml($element)
    {
        $html = '<div class="entry-edit-head collapseable" ><a id="' . $element->getHtmlId()
            . '-head" href="#" onclick="Fieldset.toggleCollapse(\'' . $element->getHtmlId() . '\', \''
            . $this->getUrl('*/*/state') . '\'); return false;">';

        $html .= ' <img src="' . $this->getSkinUrl('images/adyen/logo.png') . '" height="20" style="vertical-align: text-bottom; margin-right: 5px;"/> ';
        $html .= $element->getLegend();
        if ($this->_isPaymentEnabled($element)) {
            $html .= ' <img src="' . $this->getSkinUrl('images/icon-enabled.png') . '" style="vertical-align: middle"/> ';
        }

        $html .= '</a></div>';
        return $html;
    }
}
