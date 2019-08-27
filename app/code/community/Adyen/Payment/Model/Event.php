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
class Adyen_Payment_Model_Event extends Mage_Core_Model_Abstract
{

    const ADYEN_EVENT_AUTHORISATION = 'AUTHORISATION';
    const ADYEN_EVENT_PENDING = 'PENDING';
    const ADYEN_EVENT_AUTHORISED = 'AUTHORISED';
    const ADYEN_EVENT_CANCELLED = 'CANCELLED';
    const ADYEN_EVENT_REFUSED = 'REFUSED';
    const ADYEN_EVENT_ERROR = 'ERROR';
    const ADYEN_EVENT_REFUND = 'REFUND';
    const ADYEN_EVENT_REFUND_FAILED = 'REFUND_FAILED';
    const ADYEN_EVENT_CANCEL_OR_REFUND = 'CANCEL_OR_REFUND';
    const ADYEN_EVENT_CAPTURE = 'CAPTURE';
    const ADYEN_EVENT_CAPTURE_FAILED = 'CAPTURE_FAILED';
    const ADYEN_EVENT_CANCELLATION = 'CANCELLATION';
    const ADYEN_EVENT_POSAPPROVED = 'POS_APPROVED';
    const ADYEN_EVENT_HANDLED_EXTERNALLY = 'HANDLED_EXTERNALLY';
    const ADYEN_EVENT_MANUAL_REVIEW_ACCEPT = 'MANUAL_REVIEW_ACCEPT';
    const ADYEN_EVENT_MANUAL_REVIEW_REJECT = 'MANUAL_REVIEW_REJECT ';
    const ADYEN_EVENT_RECURRING_CONTRACT = "RECURRING_CONTRACT";
    const ADYEN_EVENT_REPORT_AVAILABLE = "REPORT_AVAILABLE";
    const ADYEN_EVENT_ORDER_CLOSED = "ORDER_CLOSED";
    const ADYEN_EVENT_NOF = "NOTIFICATION_OF_FRAUD";
    const ADYEN_EVENT_NOC = "NOTIFICATION_OF_CHARGEBACK";
    const ADYEN_EVENT_OFFER_CLOSED = "OFFER_CLOSED";
    const ADYEN_EVENT_AUTHORISED_API = "Authorised";
    const ADYEN_EVENT_REDIRECT_SHOPPER = "RedirectShopper";
    const ADYEN_EVENT_CAPTURE_RECEIVED = "[capture-received]";
    const ADYEN_EVENT_CANCEL_OR_REFUND_RECEIVED = "[cancelOrRefund-received]";
    const ADYEN_EVENT_REFUND_RECEIVED = "[refund-received]";


    /**
     * Initialize resources
     */
    protected function _construct()
    {
        $this->_init('adyen/adyen_event');
    }

    /**
     * Check if the Adyen Notification is already stored in the system
     * @param type $dbPspReference
     * @param type $dbEventCode
     * @return boolean true if the event is a duplicate
     */
    public function isDuplicate($pspReference, $event, $success)
    {
        $success = (trim($success) == "true") ? true : false;
        $result = $this->getResource()->getEvent(trim($pspReference), trim($event), $success);
        return (empty($result)) ? false : true;
    }

    public function getEvent($pspReference, $event)
    {
        return $this->getResource()->getEvent($pspReference, $event);
    }

    public function saveData()
    {
        $this->getResource()->saveData($this);
    }

    public function getOriginalPspReference($incrementId)
    {
        $originalReference = $this->getResource()->getOriginalPspReference($incrementId);
        return (!empty($originalReference)) ? $originalReference['psp_reference'] : false;
    }
}