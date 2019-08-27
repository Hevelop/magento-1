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
 * @copyright  Copyright (c) 2019 Adyen BV (http://www.adyen.com)
 */
class Adyen_Payment_ThreeDS2ProcessController extends Mage_Core_Controller_Front_Action
{

    /**
     * Execute 3DS 2.0 request
     *
     * @return mixed
     * @throws Adyen_Payment_Exception
     */
    public function indexAction()
    {
        $payload = $this->getRequest()->getParams();
        $payloadDetails = $payload['details'];

        // get current order
        $session = Mage::getSingleton('checkout/session');
        $order = Mage::getModel('sales/order')->loadByIncrementId($session->getLastRealOrderId());
        $storeId = $order->getStoreId();

        // get payment details
        $payment = $order->getPayment();

        try {
            $result = Mage::getSingleton('adyen/api')->authoriseThreeDS2Payment($payloadDetails, $payment, $storeId);
        } catch (Exception $e){
            Mage::logException($e);
            $this->cancelThreeds2();
            $this->getResponse()->setBody(json_encode("Error"));
            return;
        }

        //If the result is ChallengeShopper, send the full response to the threeds2 page
        if (!empty($result["resultCode"]) && strcmp("ChallengeShopper", $result["resultCode"]) === 0) {
            $this->getResponse()->setBody(json_encode($result));
        } else {
            $this->getResponse()->setBody(json_encode($result["resultCode"]));
            if ($result["resultCode"] == 'Authorised') {
                $order->addStatusHistoryComment(Mage::helper('adyen')->__('3D-secure 2 validation was successful'),
                    $order->getStatus())->save();

                $session->unsAdyenRealOrderId();
                $session->setQuoteId($session->getAdyenQuoteId(true));
                $session->getQuote()->setIsActive(false)->save();

                // add success to additionalData so you know that for this order 3D was successful
                $order->getPayment()->setAdditionalInformation('3d_successful', true);
                $order->save();
            } else {
                // In case of refused or during IdentifyShopper or ChallengeShopper cancel the order
                $this->cancelThreeds2();
                $this->getResponse()->setBody(json_encode($result["resultCode"]));
            }
        }
    }

    /**
     * @desc reloads the items in the cart && cancel the order
     * @since v009
     */
    public function cancelThreeds2()
    {
        $session = $this->getCheckout();

        // clear session for email shopper
        $session->setAdyenEmailShopper("");

        $order = Mage::getModel('sales/order');
        $incrementId = $session->getLastRealOrderId();

        if (empty($incrementId)) {
            $session->addError($this->__('Your payment failed, Please try again later'));
            return;
        }

        $order->loadByIncrementId($incrementId);

        // Don't cancel if the order had been authorised
        if ($order->getAdyenEventCode() == Adyen_Payment_Model_Event::ADYEN_EVENT_AUTHORISED) {
            $session->addError($this->__('Your payment has been already processed'));
            return;
        }

        // reactivate the quote again
        $quoteId = $order->getQuoteId();
        $quote = Mage::getModel('sales/quote')
            ->load($quoteId)
            ->setIsActive(1)
            ->save();

        // reset reserverOrderId because already used by previous order
        $quote->setReservedOrderId(null);
        $session->replaceQuote($quote);

        // if setting failed_attempt_disable is on and the payment method is openinvoice ignore this payment mehthod the second time
        if ($this->getConfigData(
                'failed_attempt_disable',
                'adyen_openinvoice'
            ) && $order->getPayment()->getMethod() == "adyen_openinvoice") {
            // check if payment failed
            $response = $this->getRequest()->getParams();
            if ($response['authResult'] == "REFUSED") {
                $session->setOpenInvoiceInactiveForThisQuoteId($quoteId);
            }
        }

        //handle the old order here
        $orderStatus = $this->getConfigData('payment_cancelled', 'adyen_abstract', $order->getStoreId());

        try {
            $order->setActionFlag($orderStatus, true);
            switch ($orderStatus) {
                case Mage_Sales_Model_Order::STATE_HOLDED:
                    if ($order->canHold()) {
                        $order->hold()->save();
                    }
                    break;
                default:
                    if ($order->canCancel()) {
                        $order->cancel()->save();
                    }
                    break;
            }
        } catch (Mage_Core_Exception $e) {
            Adyen_Payment_Exception::logException($e);
        }

        $params = $this->getRequest()->getParams();
        if (isset($params['authResult']) && $params['authResult'] == Adyen_Payment_Model_Event::ADYEN_EVENT_CANCELLED) {
            $session->addError($this->__('You have cancelled the order. Please try again'));
        } elseif ($order->getPayment()->getMethod() == "adyen_openinvoice") {
            $session->addError($this->__('Your openinvoice payment failed'));
        } else {
            $session->addError($this->__('Your payment failed, Please try again later'));
        }
    }

    protected function getCheckout()
    {
        return Mage::getSingleton('checkout/session');
    }
    protected function getConfigData($code, $paymentMethodCode = null, $storeId = null)
    {
        return Mage::helper('adyen')->_getConfigData($code, $paymentMethodCode, $storeId);
    }


}