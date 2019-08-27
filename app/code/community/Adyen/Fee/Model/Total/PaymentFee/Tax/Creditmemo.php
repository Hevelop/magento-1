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
class Adyen_Fee_Model_Total_PaymentFee_Tax_Creditmemo extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Creditmemo $creditmemo)
    {
        $order = $creditmemo->getOrder();

        //recalculate tax amounts in case if refund shipping value was changed
        if ((float)$creditmemo->getBasePaymentFeeAmount() > 0 && (float)$order->getBasePaymentFeeAmount() > 0) {
            $taxFactor = $creditmemo->getBasePaymentFeeAmount() / $order->getBasePaymentFeeAmount();
            $paymentFeeTax = $creditmemo->getPaymentFeeTax() * $taxFactor;
            $paymentBaseFeeTax = $creditmemo->getBasePaymentFeeTax() * $taxFactor;
        } else {
            $paymentFeeTax = $creditmemo->getPaymentFeeTax();
            $paymentBaseFeeTax = $creditmemo->getBasePaymentFeeTax();
        }

        // set the tax fee
        $creditmemo->setPaymentFeeTax($paymentFeeTax);
        $creditmemo->setBasePaymentFeeTax($paymentBaseFeeTax);

        // use the tax fee to calculate total tax amount
        $creditmemo->setTaxAmount($creditmemo->getTaxAmount() + $creditmemo->getPaymentFeeTax());
        $creditmemo->setBaseTaxAmount($creditmemo->getBaseTaxAmount() + $creditmemo->getBasePaymentFeeTax());

        return $this;
    }
}