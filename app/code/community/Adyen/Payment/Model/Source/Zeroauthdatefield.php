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
class Adyen_Payment_Model_Source_Zeroauthdatefield
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        /* @var $resource Mage_Core_Model_Resource */
        $resource = Mage::getSingleton('core/resource');
        /* @var $resource Varien_Db_Adapter_Interface */
        $readConnection = $resource->getConnection('core_read');

        $dbname = (string)Mage::getConfig()->getNode('global/resources/default_setup/connection/dbname');

        $results = $readConnection->fetchAll(
            "
SELECT
  `column_name`
FROM
  `information_schema`.`columns`
WHERE
  `table_schema` = '{$dbname}'
   AND `table_name` = '{$resource->getTableName('sales/order')}'
   AND `data_type` IN ('date','datetime','timestamp')
ORDER BY
  `table_name`, `ordinal_position`
        "
        );

        $rows = array();
        foreach ($results as $row) {
            $rows[] = array('value' => $row['column_name'], 'label' => $row['column_name']);
        }

        return $rows;
    }

}