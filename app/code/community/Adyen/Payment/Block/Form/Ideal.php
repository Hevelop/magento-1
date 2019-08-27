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
 * Class Adyen_Payment_Block_Form_Ideal
 * @method Adyen_Payment_Model_Adyen_Ideal getMethod()
 */
class Adyen_Payment_Block_Form_Ideal extends Adyen_Payment_Block_Form_Hpp
{

    protected function _construct()
    {
        parent::_construct();
        if ($this->getShowIdealLogos()) {
            $this->setTemplate('adyen/form/ideal.phtml');
        } else {
            $this->setTemplate('adyen/form/hpp.phtml');
        }
    }

    public function getShowIdealLogos()
    {
        return Mage::helper('adyen')->_getConfigData('show_ideal_logos', 'adyen_ideal');
    }

    public function getIssuerImageUrl($issuer)
    {
        $_bankFile = strtoupper(str_replace(" ", '', $issuer['label']));
        return $this->getSkinUrl("images/adyen/$_bankFile.png");
    }
}
