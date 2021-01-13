<?php

namespace Cuongmits\GdprApi\Mapper;

use Magento\Framework\App\ResourceConnection;
use Magento\Eav\Model\ResourceModel\Entity\Attribute;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Cuongmits\CustomerAddressAttribute;
use Cuongmits\CustomerAttribute;

class CustomerRelatedGdprDataMapper implements GdprDataMapperInterface
{
    /** @var array */
    private $mapData = [];

    /** @var AdapterInterface */
    private $connection;

    /** @var Attribute */
    private $attributeResource;

    public function __construct(ResourceConnection $resourceConnection, Attribute $attributeResource)
    {
        $this->connection = $resourceConnection->getConnection();
        $this->attributeResource = $attributeResource;
    }

    public function map(?int $customerId): array
    {
        if (is_null($customerId) || !isset($this->mapData[$customerId])) {
            return [];
        }

        return $this->mapData[$customerId];
    }

    public function load(array $customerIds): void
    {
        if (count($customerIds) == 0) {
            return;
        }

        $query = $this->getQuery($customerIds);
        $bindData = $this->getBindData();
        $statement = $this->connection->query($query, $bindData);

        $mapData = [];
        foreach ($statement->fetchAll() as $item) {
            $dataItems = $this->getDataItems($item);
            $customerId = $item['customer_id'];
            if (empty($mapData[$customerId])) {
                $mapData[$customerId] = $dataItems;
            } else {
                $mapDataItem = array_merge($mapData[$customerId], $dataItems);
                $mapData[$customerId] = array_unique($mapDataItem, SORT_REGULAR);
            }
        }

        $this->mapData = $mapData;
    }

    private function getDataItems(array $item): array
    {
        $customerId = $item['customer_id'];
        $customerAddressType = ucwords($item['customer_address_address_type']);
        $customerAddressId = $item['customer_address_id'];

        return [
            [
                'label' => sprintf("Email (Customer %s)", $customerId),
                'value' => $item['customer_email']
            ],
            [
                'label' => sprintf("Firstname (Customer %s)", $customerId),
                'value' => $item['customer_firstname']
            ],
            [
                'label' => sprintf("Lastname (Customer %s)", $customerId),
                'value' => $item['customer_lastname']
            ],
            [
                'label' => sprintf("SAP Debitor (Customer %s)", $customerId),
                'value' => $item['customer_sap_debitor']
            ],
            [
                'label' => sprintf("Loyalty Card Number (Customer %s)", $customerId),
                'value' => $item['customer_loyalty_card_number']
            ],
            [
                'label' => sprintf("City (Customer %s, %s Address %s)", $customerId, $customerAddressType, $customerAddressId),
                'value' => $item['customer_address_city']
            ],
            [
                'label' => sprintf("Company (Customer %s, %s Address %s)", $customerId, $customerAddressType, $customerAddressId),
                'value' => $item['customer_address_company']
            ],
            [
                'label' => sprintf("Country Id (Customer %s, %s Address %s)", $customerId, $customerAddressType, $customerAddressId),
                'value' => $item['customer_address_country_id']
            ],
            [
                'label' => sprintf("Firstname (Customer %s, %s Address %s)", $customerId, $customerAddressType, $customerAddressId),
                'value' => $item['customer_address_firstname']
            ],
            [
                'label' => sprintf("Lastname (Customer %s, %s Address %s)", $customerId, $customerAddressType, $customerAddressId),
                'value' => $item['customer_address_lastname']
            ],
            [
                'label' => sprintf("Postcode (Customer %s, %s Address %s)", $customerId, $customerAddressType, $customerAddressId),
                'value' => $item['customer_address_postcode']
            ],
            [
                'label' => sprintf("Street (Customer %s, %s Address %s)", $customerId, $customerAddressType, $customerAddressId),
                'value' => $item['customer_address_street']
            ],
            [
                'label' => sprintf("Telephone (Customer %s, %s Address %s)", $customerId, $customerAddressType, $customerAddressId),
                'value' => $item['customer_address_telephone']
            ],
            [
                'label' => sprintf("Salutation (Customer %s, %s Address %s)", $customerId, $customerAddressType, $customerAddressId),
                'value' => $item['customer_address_salutation']
            ],
        ];
    }

    private function getBindData(): array
    {
        $debitorAttrId = $this->attributeResource->getIdByCode('customer', CustomerAttribute::SAP_DEBITOR);
        $loyaltyAttrId = $this->attributeResource->getIdByCode('customer', CustomerAttribute::LOYALTY_CARD);
        $addressTypeAttrId = $this->attributeResource->getIdByCode('customer_address', CustomerAddressAttribute::ADDRESS_TYPE);

        return [
            'debitor_attr_id' => $debitorAttrId,
            'loyalty_attr_id' => $loyaltyAttrId,
            'address_type_attr_id' => $addressTypeAttrId
        ];
    }

    private function getQuery(array $customerIds): string
    {
        return sprintf(
            "
                SELECT 
                    `c`.`entity_id` AS `customer_id`,
                    `c`.`email` AS `customer_email`,
                    `c`.`firstname` AS `customer_firstname`,
                    `c`.`lastname` AS `customer_lastname`,
                    `cvd`.`value` AS `customer_sap_debitor`,
                    `cvl`.`value` AS `customer_loyalty_card_number`,
                    `cae`.`entity_id` AS `customer_address_id`,
                    `cae`.`city` AS `customer_address_city`,
                    `cae`.`company` AS `customer_address_company`,
                    `cae`.`country_id` AS `customer_address_country_id`,
                    `cae`.`firstname` AS `customer_address_firstname`,
                    `cae`.`lastname` AS `customer_address_lastname`,
                    `cae`.`postcode` AS `customer_address_postcode`,
                    `cae`.`street` AS `customer_address_street`,
                    `cae`.`telephone` AS `customer_address_telephone`,
                    `cae`.`salutation` AS `customer_address_salutation`,
                    IFNULL(`caev`.`value`, 'billing & shipping') AS `customer_address_address_type`
                FROM %s AS `c`
                    LEFT JOIN %s AS `cvd` ON `cvd`.`entity_id` = `c`.`entity_id` AND `cvd`.`attribute_id` = :debitor_attr_id
                    LEFT JOIN %s AS `cvl` ON `cvl`.`entity_id` = `c`.`entity_id` AND `cvl`.`attribute_id` = :loyalty_attr_id
                    LEFT JOIN %s AS `cae` ON `cae`.`parent_id` = `c`.`entity_id`
                    LEFT JOIN %s AS `caev` ON `caev`.`entity_id` = `cae`.`entity_id` AND `caev`.`attribute_id` = :address_type_attr_id
                WHERE `c`.`entity_id` IN (%s)
            ",
            $this->connection->getTableName('customer_entity'),
            $this->connection->getTableName('customer_entity_varchar'),
            $this->connection->getTableName('customer_entity_varchar'),
            $this->connection->getTableName('customer_address_entity'),
            $this->connection->getTableName('customer_address_entity_varchar'),
            join(',', $customerIds)
        );
    }
}
