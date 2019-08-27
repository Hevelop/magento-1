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
class Adyen_Payment_Model_Adyen_Data_Server_Openinvoice
{

    public function retrieveDetail($request)
    {
        //TEST USING THE ADYEN TEST GUI:
//        if ($request->request->reference == 'testMerchantRef1')
//            $request->request->reference = '100000065';

        /**
         * authenticate data before return invoice lines
         */
        $status = Mage::getModel('adyen/authenticate')
            ->authenticate(null, new Varien_Object(array('merchantAccountCode' => $request->request->merchantAccount)));
        if (!$status) {
            return false;
        }

        Mage::log($request, Zend_Log::INFO, 'openinvoice-request.log', true);

        return Mage::getModel('adyen/adyen_data_openInvoiceDetailResult')->create($request);
    }

}