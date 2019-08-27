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
$installer = $this;
$installer->startSetup();


/** @var Magento_Db_Adapter_Pdo_Mysql $connection */
$connection = $installer->getConnection();

$adyenOrderPaymentTable = $installer->getTable('adyen/order_payment');

$connection->dropTable($adyenOrderPaymentTable);

$table = $connection
    ->newTable($adyenOrderPaymentTable)
    ->addColumn(
        'entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'auto_increment' => true,
        ), 'Adyen Payment ID'
    )
    ->addColumn(
        'pspreference', Varien_Db_Ddl_Table::TYPE_VARCHAR, 55, array(
        'unsigned' => true,
        'nullable' => false,
        ), 'Pspreference'
    )
    ->addColumn(
        'merchant_reference', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => true,
        ), 'Merchant Reference'
    )
    ->addColumn(
        'payment_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => true,
        ), 'Order Payment Id'
    )
    ->addColumn(
        'payment_method', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'unsigned' => true,
        'nullable' => false,
        ), 'Payment Method'
    )
    ->addColumn(
        'amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, '11,2', array(
        'unsigned' => true,
        'nullable' => false,
        ), 'Amount'
    )
    ->addColumn(
        'total_refunded', Varien_Db_Ddl_Table::TYPE_DECIMAL, '11,2', array(
        'unsigned' => true,
        'nullable' => false,
        ), 'Total Refunded'
    )
    ->addColumn(
        'created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => false,
        ), 'Date'
    )
    ->addColumn(
        'updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => false,
        ), 'Date'
    )
    ->addForeignKey(
        $installer->getFkName(
            'adyen/order_payment',
            'payment_id',
            'sales/order_payment',
            'entity_id'
        ),
        'payment_id', $installer->getTable('sales/order_payment'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Adyen Order Payment');

$connection->createTable($table);

$installer->endSetup();
