<?php

namespace Cuongmits\GdprApi\Model;

class CurrentIdSets
{
    /** @var int[] */
    private $customerIds;

    /** @var int[] */
    private $orderIds;

    /** @var int[] */
    private $quoteIds;

    public function __construct(array $customerIds, array $orderIds, array $quoteIds)
    {
        $this->customerIds = $customerIds;
        $this->orderIds = $orderIds;
        $this->quoteIds = $quoteIds;
    }

    public function getCustomerIds(): array
    {
        return $this->customerIds;
    }

    public function getOrderIds(): array
    {
        return $this->orderIds;
    }

    public function getQuoteIds(): array
    {
        return $this->quoteIds;
    }
}
