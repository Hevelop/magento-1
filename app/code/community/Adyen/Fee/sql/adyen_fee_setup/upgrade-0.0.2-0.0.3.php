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
    $this->getTable('sales/quote_address'), 'payment_percentage_fee',
    "decimal(12,4) null default null"
);
$installer->getConnection()->addColumn(
    $this->getTable('sales/quote_address'), 'base_payment_percentage_fee',
    "decimal(12,4) null default null"
);

$installer->getConnection()->addColumn(
    $this->getTable('sales/order'), 'payment_percentage_fee',
    "decimal(12,4) null default null"
);
$installer->getConnection()->addColumn(
    $this->getTable('sales/order'), 'base_payment_percentage_fee',
    "decimal(12,4) null default null"
);

$installer->getConnection()->addColumn(
    $this->getTable('sales/invoice'), 'payment_percentage_fee',
    "decimal(12,4) null default null"
);
$installer->getConnection()->addColumn(
    $this->getTable('sales/invoice'), 'base_payment_percentage_fee',
    "decimal(12,4) null default null"
);

$installer->getConnection()->addColumn(
    $this->getTable('sales/creditmemo'), 'payment_percentage_fee',
    "decimal(12,4) null default null"
);
$installer->getConnection()->addColumn(
    $this->getTable('sales/creditmemo'), 'base_payment_percentage_fee',
    "decimal(12,4) null default null"
);

$installer->endSetup();