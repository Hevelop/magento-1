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
class Adyen_Payment_Model_Resource_Order_Payment_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('adyen/order_payment');
    }

    public function addPaymentFilterAscending($paymentId)
    {
        if ($paymentId instanceof Mage_Sales_Model_Order_Payment) {
            $paymentId = $paymentId->getId();
        }

        $this->addFieldToFilter('payment_id', $paymentId);
        $this->getSelect()->order(array('created_at ASC'));

        return $this;
    }

    public function addPaymentFilterDescending($paymentId)
    {
        if ($paymentId instanceof Mage_Sales_Model_Order_Payment) {
            $paymentId = $paymentId->getId();
        }

        $this->addFieldToFilter('payment_id', $paymentId);
        $this->getSelect()->order(array('created_at DESC'));

        return $this;
    }
}
