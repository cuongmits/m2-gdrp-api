<?php

namespace Cuongmits\GdprApi\Provider\QocSet;

use Cuongmits\GdprApi\Model\GdprGetRequestData;

class ConditionsProvider
{
    public function getQuoteAddressNameCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getFirstname()) && empty($requestData->getLastname())
            ? null : "(qa.`firstname` = :first_name AND qa.`lastname` = :last_name)";
    }

    public function getQuoteAddressEmailCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getEmail()) ? null : "qa.`email` = :email";
    }

    public function getQuoteNameCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getFirstname()) && empty($requestData->getLastname())
            ? null : "(q.`customer_firstname` = :first_name AND q.`customer_lastname` = :last_name)";
    }

    public function getQuoteEmailCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getEmail()) ? null : "q.`customer_email` = :email";
    }

    public function getQuoteLoyaltyNumberCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getLoyaltyCardNumber()) ? null : "q.`loyalty_card_number` = :loyalty_card_number";
    }

    public function getOrderNameCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getFirstname()) && empty($requestData->getLastname())
            ? null : "(`o`.`customer_firstname` = :first_name AND `o`.`customer_lastname` = :last_name)";
    }

    public function getOrderEmailCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getEmail()) ? null : "`o`.`customer_email` = :email";
    }

    public function getOrderDebitorNumberCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getSapDebitor()) ? null : "`o`.`sap_debitor` = :sap_debitor";
    }

    public function getOrderLoyaltyNumberCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getLoyaltyCardNumber()) ? null : "`o`.`loyalty_card_number` = :loyalty_card_number";
    }

    public function getOrderAddressNameCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getFirstname()) && empty($requestData->getLastname())
            ? null : "(`oa`.`firstname` = :first_name AND `oa`.`lastname` = :last_name)";
    }

    public function getOrderAddressEmailCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getEmail()) ? null : "`oa`.`email` = :email";
    }

    public function getCustomerNameCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getFirstname()) && empty($requestData->getLastname())
            ? null : "(`c`.`firstname` = :first_name AND `c`.`lastname` = :last_name)";
    }

    public function getCustomerEmailCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getEmail()) ? null : "`c`.`email` = :email";
    }

    public function getCustomerDebitorAttributeCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getSapDebitor())
            ? null : "(`cv`.`attribute_id` = :debitor_attr_id AND `cv`.`value` = :sap_debitor)";
    }

    public function getCustomerLoyaltyAttributeCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getLoyaltyCardNumber())
            ? null : "(`cv`.`attribute_id` = :loyalty_attr_id AND `cv`.`value` = :loyalty_card_number)";
    }

    public function getCustomerAddressNameCondition(GdprGetRequestData $requestData): ?string
    {
        return empty($requestData->getFirstname()) && empty($requestData->getLastname())
            ? null : "(`cae`.`firstname` = :first_name AND `cae`.`lastname` = :last_name)";
    }
}
