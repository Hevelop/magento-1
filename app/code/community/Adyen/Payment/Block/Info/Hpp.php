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
class Adyen_Payment_Block_Info_Hpp extends Mage_Payment_Block_Info
{

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('adyen/info/hpp.phtml');
    }

    public function toPdf()
    {
        $this->setTemplate('adyen/pdf/hpp.phtml');
        return $this->toHtml();
    }


    public function getSplitPayments()
    {
        // retrieve split payments of the order
        $orderPaymentCollection = Mage::getModel('adyen/order_payment')->getCollection();
        $orderPaymentCollection->addPaymentFilterAscending($this->getInfo()->getId());

        if ($orderPaymentCollection->getSize() > 0) {
            return $orderPaymentCollection;
        } else {
            return null;
        }
    }

}
