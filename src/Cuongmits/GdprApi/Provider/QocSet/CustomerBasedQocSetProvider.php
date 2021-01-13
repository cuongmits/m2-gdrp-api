<?php

namespace Cuongmits\GdprApi\Provider\QocSet;

use Component\Functor\NotNullFilter;
use Cuongmits\GdprApi\Model\GdprGetRequestData;

class CustomerBasedQocSetProvider extends AbstractQocSetProvider
{
    protected function getQuery(GdprGetRequestData $requestData): string
    {
        $conditions = implode(' OR ', array_filter([
            $this->conditionsProvider->getCustomerNameCondition($requestData),
            $this->conditionsProvider->getCustomerEmailCondition($requestData),
            $this->conditionsProvider->getCustomerDebitorAttributeCondition($requestData),
            $this->conditionsProvider->getCustomerLoyaltyAttributeCondition($requestData),
            $this->conditionsProvider->getCustomerAddressNameCondition($requestData)
        ], new NotNullFilter()));

        return sprintf(
            "
                SELECT
                    NULL AS `quote_id`,
                    NULL AS `order_id`,
                    `c`.`entity_id` AS `customer_id`,
                    NULL AS `quote_customer_id`,
                    NULL AS `toom_group_id`
                FROM %s AS `c`
                    LEFT JOIN %s AS `o` ON `o`.`customer_id` = `c`.`entity_id`
                    LEFT JOIN %s AS `cv` ON `cv`.`entity_id` = `c`.`entity_id`
                    LEFT JOIN %s AS `cae` ON `cae`.`parent_id` = `c`.`entity_id`
                WHERE `o`.`entity_id` IS NULL 
                    AND ( %s )
                GROUP BY `c`.`entity_id`
            ",
            $this->connection->getTableName('customer_entity'),
            $this->connection->getTableName('sales_order'),
            $this->connection->getTableName('customer_entity_varchar'),
            $this->connection->getTableName('customer_address_entity'),
            $conditions
        );
    }
}
