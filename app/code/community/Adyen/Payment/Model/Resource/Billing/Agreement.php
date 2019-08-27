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
 * @copyright  Copyright (c) 2015 Adyen BV (http://www.adyen.com)
 */
class Adyen_Payment_Model_Resource_Billing_Agreement
    extends Mage_Sales_Model_Resource_Billing_Agreement
{

    /**
     * Add order relation to billing agreement
     *
     * @param int $agreementId
     * @param int $orderId
     * @return Mage_Sales_Model_Resource_Billing_Agreement
     */
    public function addOrderRelation($agreementId, $orderId)
    {
        /*
         * needed for subscription module, only available in version >= 1.8
         */
        if (method_exists($this->_getWriteAdapter(), 'insertIgnore')) {
            $this->_getWriteAdapter()->insertIgnore(
                $this->getTable('sales/billing_agreement_order'), array(
                    'agreement_id' => $agreementId,
                    'order_id' => $orderId
                )
            );
        } else {
            // use the default insert for <= 1.7 version
            // @codingStandardsIgnoreStart
            try {
                parent::addOrderRelation($agreementId, $orderId);
            } catch (Exception $e) {
                // do not log this because this is a Integrity constraint violation solved in 1.8 by insertIgnore
            }
            // @codingStandardsIgnoreEnd
        }

        return $this;
    }
}