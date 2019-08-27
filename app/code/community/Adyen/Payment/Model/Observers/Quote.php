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
 * @author     Sander Mangel <sander@sandermangel.nl>
 * @copyright  Copyright (c) 2014 Adyen BV (http://www.adyen.com)
 */
class Adyen_Payment_Model_Observers_Quote
{
    /**
     * call all observer methods listening to the sales_quote_item_set_product event
     *
     * @param Varien_Event_Observer $observer
     */
    public function salesQuoteItemSetProduct(Varien_Event_Observer $observer)
    {
        $this->_salesQuoteItemSetAttributes($observer);
    }

    /**
     * set the quote item values based on product attribute values
     *
     * @param Varien_Event_Observer $observer
     */
    protected function _salesQuoteItemSetAttributes(Varien_Event_Observer $observer)
    {
        /** @var Mage_Sales_Model_Quote_Item $quoteItem */
        $quoteItem = $observer->getQuoteItem();
        /** @var Mage_Catalog_Model_Product $product */
        $product = $observer->getProduct();

        $quoteItem->setAdyenPreOrder((bool)$product->getAdyenPreOrder()); // set if product is pre order
    }
}
