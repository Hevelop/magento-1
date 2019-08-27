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
/** @var Mage_Sales_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn(
    $this->getTable('sales/quote_address'), 'payment_fee_amount',
    "decimal(12,4) null default null"
);
$installer->getConnection()->addColumn(
    $this->getTable('sales/quote_address'), 'base_payment_fee_amount',
    "decimal(12,4) null default null"
);

$installer->getConnection()->addColumn(
    $this->getTable('sales/order'), 'payment_fee_amount',
    "decimal(12,4) null default null"
);
$installer->getConnection()->addColumn(
    $this->getTable('sales/order'), 'base_payment_fee_amount',
    "decimal(12,4) null default null"
);

$installer->getConnection()->addColumn(
    $this->getTable('sales/invoice'), 'payment_fee_amount',
    "decimal(12,4) null default null"
);
$installer->getConnection()->addColumn(
    $this->getTable('sales/invoice'), 'base_payment_fee_amount',
    "decimal(12,4) null default null"
);

$installer->getConnection()->addColumn(
    $this->getTable('sales/creditmemo'), 'payment_fee_amount',
    "decimal(12,4) null default null"
);
$installer->getConnection()->addColumn(
    $this->getTable('sales/creditmemo'), 'base_payment_fee_amount',
    "decimal(12,4) null default null"
);

$installer->getConnection()->addColumn($this->getTable('adyen/event'), 'success', "tinyint(1) null default null");

$installer->addAttribute('order_payment', 'adyen_klarna_number', array());

$installer->getConnection()->addColumn(
    $this->getTable('sales/quote_address'), 'payment_installment_fee_amount',
    "decimal(12,4) null default null"
);
$installer->getConnection()->addColumn(
    $this->getTable('sales/quote_address'), 'base_payment_installment_fee_amount',
    "decimal(12,4) null default null"
);

$installer->getConnection()->addColumn(
    $this->getTable('sales/order'), 'payment_installment_fee_amount',
    "decimal(12,4) null default null"
);
$installer->getConnection()->addColumn(
    $this->getTable('sales/order'), 'base_payment_installment_fee_amount',
    "decimal(12,4) null default null"
);

$installer->getConnection()->addColumn(
    $this->getTable('sales/invoice'), 'payment_installment_fee_amount',
    "decimal(12,4) null default null"
);
$installer->getConnection()->addColumn(
    $this->getTable('sales/invoice'), 'base_payment_installment_fee_amount',
    "decimal(12,4) null default null"
);

$installer->getConnection()->addColumn(
    $this->getTable('sales/creditmemo'), 'payment_installment_fee_amount',
    "decimal(12,4) null default null"
);
$installer->getConnection()->addColumn(
    $this->getTable('sales/creditmemo'), 'base_payment_installment_fee_amount',
    "decimal(12,4) null default null"
);

$installer->addAttribute('order_payment', 'adyen_avs_result', array());
$installer->addAttribute('order_payment', 'adyen_cvc_result', array());

$installer->addAttribute('order_payment', 'adyen_boleto_paid_amount', array());

$installer->endSetup();