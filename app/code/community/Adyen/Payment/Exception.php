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
class Adyen_Payment_Exception extends Mage_Core_Exception
{
    /**
     * Throw an Adyen_Payment_Exception and log it.
     * @param      $message
     * @param null $messageStorage
     *
     * @throws Adyen_Payment_Exception
     */
    public static function throwException($message, $messageStorage = null)
    {
        if ($messageStorage && ($storage = Mage::getSingleton($messageStorage))) {
            $storage->addError($message);
        }

        $exception = new Adyen_Payment_Exception($message);
        self::logException($exception);

        throw $exception;
    }


    /**
     * Log an Adyen_Payment_Exception
     * @param Exception $e
     */
    public static function logException(Exception $e)
    {
        Mage::log("\n" . $e->__toString(), Zend_Log::ERR, 'adyen_exception.log');
    }

    /**
     * Throw an Adyen_Payment_Exception on Curl errors and log it.
     * @param      $message
     * @param null $messageStorage
     *
     * @throws Adyen_Payment_Exception
     */
    public static function throwCurlException($errorMessage, $errorCode)
    {
        $exception = new Adyen_Payment_Exception($errorMessage, $errorCode);
        self::logException($exception);

        throw $exception;
    }
}
