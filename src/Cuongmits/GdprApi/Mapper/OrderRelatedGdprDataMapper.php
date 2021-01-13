<?php

namespace Cuongmits\GdprApi\Mapper;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;

class OrderRelatedGdprDataMapper implements GdprDataMapperInterface
{
    /** @var array */
    private $mapData = [];

    /** @var AdapterInterface */
    private $connection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->connection = $resourceConnection->getConnection();
    }

    public function map(?int $orderId): array
    {
        if (is_null($orderId) || !isset($this->mapData[$orderId])) {
            return [];
        }

        return $this->mapData[$orderId];
    }

    public function load(array $orderIds): void
    {
        if (count($orderIds) == 0) {
            return;
        }

        $query = $this->getQuery($orderIds);
        $statement = $this->connection->query($query);

        $mapData = [];
        foreach ($statement->fetchAll() as $item) {
            $dataItems = $this->getDataItems($item);
            $orderId = $item['order_id'];
            if (empty($mapData[$orderId])) {
                $mapData[$orderId] = $dataItems;
            } else {
                $mapDataItem = array_merge($mapData[$orderId], $dataItems);
                $mapData[$orderId] = array_unique($mapDataItem, SORT_REGULAR);
            }
        }

        $this->mapData = $mapData;
    }

    private function getDataItems(array $item): array
    {
        $orderId = $item['order_id'];
        $orderAddressType = $item['order_address_address_type'];
        $orderInvoiceId = $item['order_invoice_id'];
        $orderShipmentId = $item['order_shipment_id'];
        $orderShipmentTrackId = $item['order_shipment_track_id'];

        return [
            [
                'label' => sprintf("Email (Order %s)", $orderId),
                'value' => $item['order_customer_email']
            ],
            [
                'label' => sprintf("Firstname (Order %s)", $orderId),
                'value' => $item['order_customer_firstname']
            ],
            [
                'label' => sprintf("Lastname (Order %s)", $orderId),
                'value' => $item['order_customer_lastname']
            ],
            [
                'label' => sprintf("Remote IP (Order %s)", $orderId),
                'value' => $item['order_remote_ip']
            ],
            [
                'label' => sprintf("X Forward For (Order %s)", $orderId),
                'value' => $item['order_x_forwarded_for']
            ],
            [
                'label' => sprintf("SAP Debitor (Order %s)", $orderId),
                'value' => $item['order_sap_debitor']
            ],
            [
                'label' => sprintf("Loyalty Card Number (Order %s)", $orderId),
                'value' => $item['order_loyalty_card_number']
            ],
            [
                'label' => sprintf("Email (Order %s, %s Address)", $orderId, $orderAddressType),
                'value' => $item['order_address_email']
            ],
            [
                'label' => sprintf("Firstname (Order %s, %s Address)", $orderId, $orderAddressType),
                'value' => $item['order_address_firstname']
            ],
            [
                'label' => sprintf("Lastname (Order %s, %s Address)", $orderId, $orderAddressType),
                'value' => $item['order_address_lastname']
            ],
            [
                'label' => sprintf("Company (Order %s, %s Address)", $orderId, $orderAddressType),
                'value' => $item['order_address_company']
            ],
            [
                'label' => sprintf("Street (Order %s, %s Address)", $orderId, $orderAddressType),
                'value' => $item['order_address_street']
            ],
            [
                'label' => sprintf("City (Order %s, %s Address)", $orderId, $orderAddressType),
                'value' => $item['order_address_city']
            ],
            [
                'label' => sprintf("Postcode (Order %s, %s Address)", $orderId, $orderAddressType),
                'value' => $item['order_address_postcode']
            ],
            [
                'label' => sprintf("Country Id (Order %s, %s Address)", $orderId, $orderAddressType),
                'value' => $item['order_address_country_id']
            ],
            [
                'label' => sprintf("Telephone (Order %s, %s Address)", $orderId, $orderAddressType),
                'value' => $item['order_address_telephone']
            ],
            [
                'label' => sprintf("Salutation (Order %s, %s Address)", $orderId, $orderAddressType),
                'value' => $item['order_address_salutation']
            ],
            [
                'label' => sprintf("Cuongmits Invoice Id (Order %s, Invoice %s)", $orderId, $orderInvoiceId),
                'value' => $item['order_invoice_toom_invoice_id']
            ],
            [
                'label' => sprintf("Cuongmits Filenet Id (Order %s, Invoice %s)", $orderId, $orderInvoiceId),
                'value' => $item['order_invoice_toom_filenet_id']
            ],
            [
                'label' => sprintf("Cuongmits Invoice Id (Order %s, Shipment %s)", $orderId, $orderShipmentId),
                'value' => $item['order_shipment_toom_invoice_id']
            ],
            [
                'label' => sprintf("Track number (Order %s, Track %s)", $orderId, $orderShipmentTrackId),
                'value' => $item['order_shipment_track_track_number']
            ],
        ];
    }

    private function getQuery(array $orderIds): string
    {
        return sprintf(
            "
                SELECT
                    `o`.`entity_id` AS `order_id`,
                    `o`.`customer_email` AS `order_customer_email`,
                    `o`.`customer_firstname` AS `order_customer_firstname`,
                    `o`.`customer_lastname` AS `order_customer_lastname`,
                    `o`.`remote_ip` AS `order_remote_ip`,
                    `o`.`x_forwarded_for` AS `order_x_forwarded_for`,
                    `o`.`sap_debitor` AS `order_sap_debitor`,
                    `o`.`loyalty_card_number` AS `order_loyalty_card_number`,
                    `oa`.`address_type` AS `order_address_address_type`,
                    `oa`.`email` AS `order_address_email`,
                    `oa`.`firstname` AS `order_address_firstname`,
                    `oa`.`lastname` AS `order_address_lastname`,
                    `oa`.`company` AS `order_address_company`,
                    `oa`.`street` AS `order_address_street`,
                    `oa`.`city` AS `order_address_city`,
                    `oa`.`postcode` AS `order_address_postcode`,
                    `oa`.`country_id` AS `order_address_country_id`,                    
                    `oa`.`telephone` AS `order_address_telephone`,
                    `oa`.`salutation` AS `order_address_salutation`,
                    `si`.`entity_id` AS `order_invoice_id`,
                    `si`.`toom_invoice_id` AS `order_invoice_toom_invoice_id`,
                    `si`.`toom_filenet_id` AS `order_invoice_toom_filenet_id`,
                    `ss`.`entity_id` AS `order_shipment_id`,
                    `ss`.`toom_invoice_id` AS `order_shipment_toom_invoice_id`,
                    `sst`.`entity_id` AS `order_shipment_track_id`,
                    `sst`.`track_number` AS `order_shipment_track_track_number`
                FROM %s AS `o`
                    LEFT JOIN %s AS `oa` ON `oa`.`parent_id` = `o`.`entity_id`
                    LEFT JOIN %s AS `si` ON `si`.`order_id` = `o`.`entity_id`
                    LEFT JOIN %s AS `ss` ON `ss`.`order_id` = `o`.`entity_id`
                    LEFT JOIN %s AS `sst` ON `sst`.`parent_id` = `ss`.`entity_id`
                WHERE `o`.`entity_id` IN (%s)
            ",
            $this->connection->getTableName('sales_order'),
            $this->connection->getTableName('sales_order_address'),
            $this->connection->getTableName('sales_invoice'),
            $this->connection->getTableName('sales_shipment'),
            $this->connection->getTableName('sales_shipment_track'),
            join(',', $orderIds)
        );
    }
}
