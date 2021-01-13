<?php

namespace Cuongmits\GdprApi\Provider\QocSet;

use Component\Functor\NotNullFilter;
use Cuongmits\GdprApi\Model\GdprGetRequestData;

class QuoteBasedQocSetProvider extends AbstractQocSetProvider
{
    protected function getQuery(GdprGetRequestData $requestData): string
    {
        $conditions = implode(' OR ', array_filter([
            $this->conditionsProvider->getQuoteNameCondition($requestData),
            $this->conditionsProvider->getQuoteEmailCondition($requestData),
            $this->conditionsProvider->getQuoteLoyaltyNumberCondition($requestData),
            $this->conditionsProvider->getQuoteAddressNameCondition($requestData),
            $this->conditionsProvider->getQuoteAddressEmailCondition($requestData),
            $this->conditionsProvider->getOrderNameCondition($requestData),
            $this->conditionsProvider->getOrderEmailCondition($requestData),
            $this->conditionsProvider->getOrderDebitorNumberCondition($requestData),
            $this->conditionsProvider->getOrderLoyaltyNumberCondition($requestData),
            $this->conditionsProvider->getOrderAddressNameCondition($requestData),
            $this->conditionsProvider->getOrderAddressEmailCondition($requestData),
            $this->conditionsProvider->getCustomerNameCondition($requestData),
            $this->conditionsProvider->getCustomerEmailCondition($requestData),
            $this->conditionsProvider->getCustomerDebitorAttributeCondition($requestData),
            $this->conditionsProvider->getCustomerLoyaltyAttributeCondition($requestData),
            $this->conditionsProvider->getCustomerAddressNameCondition($requestData)
        ], new NotNullFilter()));

        return sprintf(
            "
                SELECT
                    `q`.`entity_id` AS `quote_id`,
                    `o`.`entity_id` AS `order_id`,
                    `c`.`entity_id` AS `customer_id`,
                    `q`.`customer_id` AS `quote_customer_id`,
                    `q`.`toom_group_id` AS `toom_group_id`
                FROM %s AS `q`
                    LEFT JOIN %s AS `qa` ON `q`.`entity_id` = `qa`.`quote_id`
                    LEFT JOIN %s AS `o` ON `o`.quote_id = `q`.`entity_id`
                    LEFT JOIN %s AS `oa` ON `o`.`entity_id` = `oa`.`parent_id`
                    LEFT JOIN %s AS `c` ON `c`.entity_id = `o`.`customer_id`
                    LEFT JOIN %s AS `cv` ON `cv`.`entity_id` = `c`.`entity_id`
                    LEFT JOIN %s AS `cae` ON `cae`.`parent_id` = `c`.`entity_id`
                WHERE %s
                GROUP BY `q`.`entity_id`, `o`.`entity_id`, `c`.`entity_id`
            ",
            $this->connection->getTableName('quote'),
            $this->connection->getTableName('quote_address'),
            $this->connection->getTableName('sales_order'),
            $this->connection->getTableName('sales_order_address'),
            $this->connection->getTableName('customer_entity'),
            $this->connection->getTableName('customer_entity_varchar'),
            $this->connection->getTableName('customer_address_entity'),
            $conditions
        );
    }
}
