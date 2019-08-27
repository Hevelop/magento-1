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
class Adyen_Payment_Block_Adminhtml_System_Config_Fieldset_Gettingstarted
    extends Adyen_Payment_Block_Adminhtml_System_Config_Fieldset_Fieldset
{

    /**
     * Return header comment part of html for fieldset
     * Add the Export Settings button
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getHeaderCommentHtml($element)
    {
        $html = $element->getComment()
            ? '<div class="comment">' . $element->getComment() . '</div>'
            : '';
        $url = Mage::helper('adminhtml')->getUrl('adminhtml/ExportAdyenSettings');
        $html .= <<<HTML
<div class="button-container">
    <button type="button" class="button" id="{$element->getHtmlId()}-export" onclick="location.href='{$url}'">
        {$this->__('Export Settings')}
    </button>
</div>
HTML;

        return $html;
    }

}
