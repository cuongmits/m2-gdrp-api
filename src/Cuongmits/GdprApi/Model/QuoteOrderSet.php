<?php

namespace Cuongmits\GdprApi\Model;

class QuoteOrderSet
{
    /** @var int|null */
    private $orderId;

    /** @var int */
    private $quoteId;

    public function __construct(int $quoteId, ?int $orderId)
    {
        $this->orderId = $orderId;
        $this->quoteId = $quoteId;
    }

    public function getQuoteId(): int
    {
        return $this->quoteId;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }
}
