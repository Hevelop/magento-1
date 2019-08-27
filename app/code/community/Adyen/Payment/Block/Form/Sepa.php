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
class Adyen_Payment_Block_Form_Sepa extends Adyen_Payment_Block_Form_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('adyen/form/sepa.phtml');
    }

    public function getCountries()
    {
        $sepaCountriesAllowed = array(
            "AT",
            "BE",
            "BG",
            "CH",
            "CY",
            "CZ",
            "DE",
            "DK",
            "EE",
            "ES",
            "FI",
            "FR",
            "GB",
            "GF",
            "GI",
            "GP",
            "GR",
            "HR",
            "HU",
            "IE",
            "IS",
            "IT",
            "LI",
            "LT",
            "LU",
            "LV",
            "MC",
            "MQ",
            "MT",
            "NL",
            "NO",
            "PL",
            "PT",
            "RE",
            "RO",
            "SE",
            "SI",
            "SK"
        );
        $countryList = Mage::getResourceModel('directory/country_collection')
            ->loadData()
            ->toOptionArray(false);
        foreach ($countryList as $key => $country) {
            $value = $country['value'];
            if (!in_array($value, $sepaCountriesAllowed)) {
                unset($countryList[$key]);
            }
        }

        return $countryList;
    }

    /**
     * @return string
     */
    public function getCountryValue()
    {
        if ($country = $this->getMethod()->getInfoInstance()->getAdditionalInformation('country')) {
            return $country;
        }

        $quote = $this->_getQuote();
        if (!$quote || !$quote->getBillingAddress()) {
            return '';
        }

        return $quote->getBillingAddress()->getCountryId();
    }

    /**
     * @return string
     */
    public function getBankHolderValue()
    {
        if ($accountName = $this->getMethod()->getInfoInstance()->getAdditionalInformation('account_name')) {
            return $accountName;
        }

        $quote = $this->_getQuote();
        if (!$quote || !$quote->getBillingAddress()) {
            return '';
        }

        return $quote->getBillingAddress()->getName();
    }

    /**
     * @return string
     */
    public function getIbanValue()
    {
        if ($iban = $this->getMethod()->getInfoInstance()->getAdditionalInformation('iban')) {
            return $iban;
        }

        return '';
    }
}
