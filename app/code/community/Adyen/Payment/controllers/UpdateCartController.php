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
class Adyen_Payment_UpdateCartController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {

        $params = $this->getRequest()->getParams();
        $code = (isset($params['code'])) ? $params['code'] : "";
        $customCode = (isset($params['customcode'])) ? $params['customcode'] : "";

        // check if barcdoe is from scanner or filled in manually
        if ($code != "") {
            $sku = $code;
        } elseif ($customCode != "") {
            $sku = $customCode;
        } else {
            // no barcode
            $sku = "";
        }

        if ($sku != "") {
            $productId = Mage::getModel('catalog/product')
                ->getIdBySku(trim($sku));

            if ($productId > 0) {
                // Initiate product model
                $product = Mage::getModel('catalog/product');

                // Load specific product whose tier price want to update
                $product->load($productId);

                if ($product) {
                    $cart = Mage::getSingleton('checkout/cart');
                    $cart->addProduct($product, array('qty' => '1'));
                    $cart->save();
                }
            }
        }

        // render the content so ajax call can update template
        $this->loadLayout();
        $layout = $this->getLayout();
        $block = $layout->getBlock("content");

        $this->getResponse()->setBody($block->toHtml());
    }

}