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
class Adyen_Payment_Model_Adyen_Ideal
    extends Adyen_Payment_Model_Adyen_Hpp
{
    protected $_code = 'adyen_ideal';
    protected $_formBlockType = 'adyen/form_ideal';

    /**
     * @return mixed
     */
    public function getShowIdealLogos()
    {
        return $this->_getConfigData('show_ideal_logos', 'adyen_ideal');
    }

    public function validate()
    {
        parent::validate();
        $info = $this->getInfoInstance();
        $hppType = $info->getCcType();
        // validate if the ideal bank is chosen
        if ($hppType == "ideal") {
            if ($info->getAdditionalInformation("hpp_issuer_id") == "") {
                // hpp type is empty throw error
                Mage::throwException(Mage::helper('adyen')->__('You chose an invalid bank'));
            }
        }
    }
}
