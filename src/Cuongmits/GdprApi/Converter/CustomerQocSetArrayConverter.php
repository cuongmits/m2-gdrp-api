<?php

namespace Cuongmits\GdprApi\Converter;

use Cuongmits\GdprApi\Model\CustomerQocSet;
use Cuongmits\GdprApi\Model\QuoteOrderSet;

class CustomerQocSetArrayConverter implements ConverterInterface
{
    /**
     * @param array $plainQocArray
     *
     * @return CustomerQocSet[]
     */
    public function convert(array $plainQocArray): array
    {
        $result = [];
        foreach ($plainQocArray as $customerQocSet) {
            $customerId = $customerQocSet['customer_id'];
            $quoteOrderSets = [];
            foreach ($customerQocSet['quote_order_sets'] as $quoteOrderSet) {
                if (isset($quoteOrderSet['quote_id']) && !is_null($quoteOrderSet['quote_id'])) {
                    $quoteOrderSets[] = new QuoteOrderSet($quoteOrderSet['quote_id'], $quoteOrderSet['order_id']);
                }
            }
            $result[] = new CustomerQocSet($customerId, $quoteOrderSets);
        }

        return $result;
    }
}
