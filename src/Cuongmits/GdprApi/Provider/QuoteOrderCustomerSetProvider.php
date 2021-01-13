<?php

namespace Cuongmits\GdprApi\Provider;

use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Provider\QocSet\CustomerBasedQocSetProvider;
use Cuongmits\GdprApi\Provider\QocSet\QuoteBasedQocSetProvider;

class QuoteOrderCustomerSetProvider implements SetProviderInterface
{
    /** @var QuoteBasedQocSetProvider */
    private $quoteBasedQocSetProvider;

    /** @var CustomerBasedQocSetProvider */
    private $customerBasedQocSetProvider;

    public function __construct(
        QuoteBasedQocSetProvider $quoteBasedQocSetProvider,
        CustomerBasedQocSetProvider $customerBasedQocSetProvider
    ) {
        $this->quoteBasedQocSetProvider = $quoteBasedQocSetProvider;
        $this->customerBasedQocSetProvider = $customerBasedQocSetProvider;
    }

    public function get(GdprGetRequestData $requestData): array
    {
        $quoteBasedQocSets = $this->quoteBasedQocSetProvider->get($requestData);
        $customerBasedQocSets = $this->customerBasedQocSetProvider->get($requestData);

        return array_merge($quoteBasedQocSets, $customerBasedQocSets);
    }
}
