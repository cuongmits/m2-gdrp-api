<?php

namespace Cuongmits\GdprApi\Resolver;

use Cuongmits\GdprApi\Model\CurrentIdSets;
use Cuongmits\GdprApi\Model\CustomerQocSet;

class CurrentIdSetsResolver
{
    /**
     * @param CustomerQocSet[] $currentCustomerQocSets
     *
     * @return CurrentIdSets
     */
    public function getCurrentIdSets(array $currentCustomerQocSets): CurrentIdSets
    {
        $quoteIds = $orderIds = $customerIds = [];
        foreach ($currentCustomerQocSets as $customerQocSet) {
            if (!empty($customerQocSet->getCustomerId())) {
                $customerIds[] = $customerQocSet->getCustomerId();
            }

            foreach ($customerQocSet->getQuoteOrderSets() as $quoteOrderSet) {
                if (!empty($quoteOrderSet->getOrderId())) {
                    $orderIds[] = $quoteOrderSet->getOrderId();
                }

                $quoteIds[] = $quoteOrderSet->getQuoteId();
            }
        }

        return new CurrentIdSets($customerIds, $orderIds, $quoteIds);
    }
}
