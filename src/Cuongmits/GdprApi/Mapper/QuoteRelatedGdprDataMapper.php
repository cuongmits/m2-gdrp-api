<?php

namespace Cuongmits\GdprApi\Mapper;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;

class QuoteRelatedGdprDataMapper implements GdprDataMapperInterface
{
    /** @var array */
    private $mapData = [];

    /** @var AdapterInterface */
    private $connection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->connection = $resourceConnection->getConnection();
    }

    public function map(?int $quoteId): array
    {
        if (is_null($quoteId) || !isset($this->mapData[$quoteId])) {
            return [];
        }

        return $this->mapData[$quoteId];
    }

    public function load(array $quoteIds): void
    {
        if (count($quoteIds) == 0) {
            return;
        }

        $query = $this->getQuery($quoteIds);
        $statement = $this->connection->query($query);

        $mapData = [];
        foreach ($statement->fetchAll() as $item) {
            $dataItems = $this->getDataItems($item);
            if (empty($mapData[$item['quote_id']])) {
                $mapData[$item['quote_id']] = $dataItems;
            } else {
                $mapDataItem = array_merge($mapData[$item['quote_id']], $dataItems);
                $mapData[$item['quote_id']] = array_unique($mapDataItem, SORT_REGULAR);
            }
        }

        $this->mapData = $mapData;
    }

    private function getDataItems(array $item): array
    {
        $quoteId = $item['quote_id'];
        $quoteAddressType = ucwords($item['quote_address_address_type']);

        return [
            [
                'label' => sprintf("Email (Quote %s)", $quoteId),
                'value' => $item['quote_customer_email']
            ],
            [
                'label' => sprintf("Firstname (Quote %s)", $quoteId),
                'value' => $item['quote_customer_firstname']
            ],
            [
                'label' => sprintf("Lastname (Quote %s)", $quoteId),
                'value' => $item['quote_customer_lastname']
            ],
            [
                'label' => sprintf("Remote IP (Quote %s)", $quoteId),
                'value' => $item['quote_remote_ip']
            ],
            [
                'label' => sprintf("Loyalty Card Number (Quote %s)", $quoteId),
                'value' => $item['quote_loyalty_card_number']
            ],
            [
                'label' => sprintf("Email (Quote %s, %s Address)", $quoteId, $quoteAddressType),
                'value' => $item['quote_address_email']
            ],
            [
                'label' => sprintf("Firstname (Quote %s, %s Address)", $quoteId, $quoteAddressType),
                'value' => $item['quote_address_firstname']
            ],
            [
                'label' => sprintf("Lastname (Quote %s, %s Address)", $quoteId, $quoteAddressType),
                'value' => $item['quote_address_lastname']
            ],
            [
                'label' => sprintf("Company (Quote %s, %s Address)", $quoteId, $quoteAddressType),
                'value' => $item['quote_address_company']
            ],
            [
                'label' => sprintf("Street (Quote %s, %s Address)", $quoteId, $quoteAddressType),
                'value' => $item['quote_address_street']
            ],
            [
                'label' => sprintf("City (Quote %s, %s Address)", $quoteId, $quoteAddressType),
                'value' => $item['quote_address_city']
            ],
            [
                'label' => sprintf("Postcode (Quote %s, %s Address)", $quoteId, $quoteAddressType),
                'value' => $item['quote_address_postcode']
            ],
            [
                'label' => sprintf("Country Id (Quote %s, %s Address)", $quoteId, $quoteAddressType),
                'value' => $item['quote_address_country_id']
            ],
            [
                'label' => sprintf("Telephone (Quote %s, %s Address)", $quoteId, $quoteAddressType),
                'value' => $item['quote_address_telephone']
            ],
            [
                'label' => sprintf("Salutation (Quote %s, %s Address)", $quoteId, $quoteAddressType),
                'value' => $item['quote_address_salutation']
            ],
        ];
    }

    private function getQuery(array $quoteIds): string
    {
        return sprintf(
            "
                SELECT
                    `q`.`entity_id` AS `quote_id`,
                    `q`.`customer_email` AS `quote_customer_email`,
                    `q`.`customer_firstname` AS `quote_customer_firstname`,
                    `q`.`customer_lastname` AS `quote_customer_lastname`,
                    `q`.`remote_ip` AS `quote_remote_ip`,
                    `q`.`loyalty_card_number` AS `quote_loyalty_card_number`,
                    `qa`.`address_type` AS `quote_address_address_type`,
                    `qa`.`email` AS `quote_address_email`,
                    `qa`.`firstname` AS `quote_address_firstname`,
                    `qa`.`lastname` AS `quote_address_lastname`,
                    `qa`.`company` AS `quote_address_company`,
                    `qa`.`street` AS `quote_address_street`,
                    `qa`.`city` AS `quote_address_city`,
                    `qa`.`postcode` AS `quote_address_postcode`,
                    `qa`.`country_id` AS `quote_address_country_id`,                    
                    `qa`.`telephone` AS `quote_address_telephone`,
                    `qa`.`salutation` AS `quote_address_salutation`
                FROM %s AS `q`
                    LEFT JOIN %s AS `qa` ON `q`.`entity_id` = `qa`.`quote_id`
                WHERE `q`.`entity_id` IN (%s)
            ",
            $this->connection->getTableName('quote'),
            $this->connection->getTableName('quote_address'),
            join(',', $quoteIds)
        );
    }
}
