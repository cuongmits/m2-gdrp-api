<?php

namespace Cuongmits\GdprApi\Provider;

use Cuongmits\GdprApi\Api\Get;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Resolver\AggregationResolver;
use Cuongmits\GdprApi\Resolver\GdprGetResponseResolver;
use Cuongmits\GdprApi\Resolver\CustomerQocSetsPaginationResolver;
use Cuongmits\GdprApi\ValidationErrorCode;
use Cuongmits\GdprApi\Validator\UniqueCustomerLimitValidator;
use Cuongmits\GdprApi\Converter\CustomerQocSetArrayConverter;

class GetResultProvider
{
    /** @var QuoteOrderCustomerSetProvider */
    private $quoteOrderCustomerSetProvider;

    /** @var AggregationResolver */
    private $aggregationResolver;

    /** @var GdprGetResponseResolver */
    private $gdprGetResponseResolver;

    /** @var UniqueCustomerLimitValidator */
    private $uniqueCustomerLimitValidator;

    /** @var CustomerQocSetsPaginationResolver */
    private $paginationResolver;

    /** @var CustomerQocSetArrayConverter */
    private $customerQocSetArrayConverter;

    public function __construct(
        QuoteOrderCustomerSetProvider $quoteOrderCustomerSetProvider,
        AggregationResolver $aggregationResolver,
        UniqueCustomerLimitValidator $uniqueCustomerLimitValidator,
        GdprGetResponseResolver $gdprGetResponseResolver,
        CustomerQocSetsPaginationResolver $paginationResolver,
        CustomerQocSetArrayConverter $customerQocSetArrayConverter
    ) {
        $this->quoteOrderCustomerSetProvider = $quoteOrderCustomerSetProvider;
        $this->aggregationResolver = $aggregationResolver;
        $this->gdprGetResponseResolver = $gdprGetResponseResolver;
        $this->uniqueCustomerLimitValidator = $uniqueCustomerLimitValidator;
        $this->paginationResolver = $paginationResolver;
        $this->customerQocSetArrayConverter = $customerQocSetArrayConverter;
    }

    public function get(GdprGetRequestData $requestData): array
    {
        $qocSets = $this->quoteOrderCustomerSetProvider->get($requestData);
        $uniqueCustomerQocSets = $this->aggregationResolver->aggregateQocSetsByUniqueCustomers($qocSets);

        if (!$this->uniqueCustomerLimitValidator->isValid($uniqueCustomerQocSets)) {
            return [
                Get::RESPONSE_ERROR_KEY => ValidationErrorCode::INVALID_RESPONSE_LIMIT,
                Get::RESPONSE_RECORD_NUMBER => count($uniqueCustomerQocSets)
            ];
        }

        $currentCustomerQocSets = $this->paginationResolver->getCustomerQocSetsByCursor($requestData, $uniqueCustomerQocSets);
        $currentCustomerQocSets = $this->customerQocSetArrayConverter->convert($currentCustomerQocSets);

        return $this->gdprGetResponseResolver->getResponse($requestData, $currentCustomerQocSets)
            + [ //for testing purpose only, remove later.
                'qoc_set' => $qocSets,
                'all_unique_customer_qoc_set' => $uniqueCustomerQocSets,
                'current_customer_qoc_set' => $currentCustomerQocSets
            ];
    }
}
