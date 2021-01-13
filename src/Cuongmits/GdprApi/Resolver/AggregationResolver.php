<?php

namespace Cuongmits\GdprApi\Resolver;

class AggregationResolver
{
    /** @var CustomerIdResolver */
    private $quoteCustomerIdResolver;

    public function __construct(CustomerIdResolver $quoteCustomerIdResolver)
    {
        $this->quoteCustomerIdResolver = $quoteCustomerIdResolver;
    }

    public function aggregateQocSetsByUniqueCustomers(array $qocSets): array
    {
        $qocSets = $this->quoteCustomerIdResolver->setCustomerIdForQocSets($qocSets);
        $qocSetsByCustomerId = $this->getQocSetsByCustomerId($qocSets);

        return $this->getQocSetsByUniqueCustomers($qocSetsByCustomerId);
    }

    private function getQocSetsByCustomerId(array $qocSets): array
    {
        $result = [];
        foreach ($qocSets as $qocSet) {
            $result[$qocSet['customer_id']][] = empty($qocSet['quote_id']) ? [] : [
                'quote_id' => $qocSet['quote_id'],
                'order_id' => $qocSet['order_id'],
                'toom_group_id' => $qocSet['toom_group_id']
            ];
        }

        return $result;
    }

    private function getQocSetsByUniqueCustomers(array $qocSetsByCustomerId): array
    {
        $result = [];
        foreach ($qocSetsByCustomerId as $customerId => $quoteOrderSets) {
            if (empty($customerId)) {
                $quoteOrderSetsByGroupId = $this->getQuoteOrderSetsForGuestFilteredByGroupId($quoteOrderSets);
                foreach ($quoteOrderSetsByGroupId as $quoteOrderSubsets) {
                    $result[] = [
                        'customer_id' => null,
                        'quote_order_sets' => $quoteOrderSubsets,
                    ];
                }
            } else {
                $result[] = [
                    'customer_id' => $customerId,
                    'quote_order_sets' => $this->unsetGroupIdFromQuoteOrderSets($quoteOrderSets),
                ];
            }
        }

        return $result;
    }

    private function getQuoteOrderSetsForGuestFilteredByGroupId(array $quoteOrderSets): array
    {
        $result = [];
        foreach ($quoteOrderSets as $quoteOrderSet) {
            $result[$quoteOrderSet['toom_group_id']][] = [
                'quote_id' => $quoteOrderSet['quote_id'],
                'order_id' => $quoteOrderSet['order_id']
            ];
        }

        return $result;
    }

    private function unsetGroupIdFromQuoteOrderSets(array $quoteOrderSets): array
    {
        foreach (array_keys($quoteOrderSets) as $key) {
            unset($quoteOrderSets[$key]['toom_group_id']);
        }

        return $quoteOrderSets;
    }
}
