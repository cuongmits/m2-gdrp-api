<?php

namespace Cuongmits\GdprApi\Model;

class CustomerQocSet
{
    /** @var int|null */
    private $customerId;

    /** @var QuoteOrderSet[] */
    private $quoteOrderSets;

    public function __construct(?int $customerId, array $quoteOrderSets)
    {
        $this->customerId = $customerId;
        $this->quoteOrderSets = $quoteOrderSets;
    }

    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    /**
     * @return QuoteOrderSet[]
     */
    public function getQuoteOrderSets(): array
    {
        return $this->quoteOrderSets;
    }
}
