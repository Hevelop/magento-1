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
class Adyen_Payment_Model_Adyen_Data_InvoiceRow extends Adyen_Payment_Model_Adyen_Data_Abstract
{

    public $currency;
    public $description;
    public $itemPrice;
    public $itemVAT;
    public $lineReference;
    public $numberOfItems;
    public $vatCategory;

    public function create($item, $count, $order)
    {
        $currency = $order->getOrderCurrencyCode();
        $this->currency = $currency;
        $this->description = $item->getName();
        $this->itemPrice = Mage::helper('adyen')->formatAmount($item->getPrice(), $currency);
        $this->itemVAT = ($item->getTaxAmount() > 0 && $item->getPriceInclTax() > 0) ?
            Mage::helper('adyen')->formatAmount($item->getPriceInclTax(), $currency) -
            Mage::helper('adyen')->formatAmount($item->getPrice(), $currency) :
            Mage::helper('adyen')->formatAmount($item->getTaxAmount(), $currency);
        $this->lineReference = $count;
        $this->numberOfItems = (int)$item->getQtyOrdered();
        $this->vatCategory = "None";
        return $this;
    }

}