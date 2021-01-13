<?php

namespace spec\Cuongmits\GdprApi\Provider;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Provider\CustomerSetProvider;
use Cuongmits\GdprApi\Provider\GetResultProvider;
use Cuongmits\GdprApi\Provider\OrderSetProvider;
use Cuongmits\GdprApi\Provider\QuoteOrderCustomerSetProvider;
use Cuongmits\GdprApi\Provider\QuoteSetProvider;
use Cuongmits\GdprApi\Resolver\AggregationResolver;
use Cuongmits\GdprApi\Resolver\CustomerQocSetsPaginationResolver;
use Cuongmits\GdprApi\Resolver\GdprGetResponseResolver;
use Cuongmits\GdprApi\ValidationErrorCode;
use Cuongmits\GdprApi\Validator\UniqueCustomerLimitValidator;
use Cuongmits\GdprApi\Converter\CustomerQocSetArrayConverter;

class GetResultProviderSpec extends ObjectBehavior
{
    function let(
        QuoteOrderCustomerSetProvider $quoteOrderCustomerSetProvider,
        AggregationResolver $aggregationResolver,
        UniqueCustomerLimitValidator $uniqueCustomerLimitValidator,
        GdprGetResponseResolver $gdprGetResponseResolver,
        CustomerQocSetsPaginationResolver $customerQocSetsPaginationResolver,
        GdprGetRequestData $requestData,
        CustomerQocSetArrayConverter $customerQocSetArrayConverter
    ) {
        $quoteOrderCustomerSetProvider->get($requestData)->willReturn(['qoc set']);
        $aggregationResolver->aggregateQocSetsByUniqueCustomers(['qoc set'])->willReturn(['unique customer set']);

        $this->beConstructedWith(
            $quoteOrderCustomerSetProvider,
            $aggregationResolver,
            $uniqueCustomerLimitValidator,
            $gdprGetResponseResolver,
            $customerQocSetsPaginationResolver,
            $customerQocSetArrayConverter
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GetResultProvider::class);
    }

    function it_should_return_error_array_when_result_reach_limit_number(
        UniqueCustomerLimitValidator $uniqueCustomerLimitValidator,
        GdprGetRequestData $requestData
    ) {
        $uniqueCustomerLimitValidator->isValid(['unique customer set'])->willReturn(false);

        $this->get($requestData)->shouldReturn([
            'error' => ValidationErrorCode::INVALID_RESPONSE_LIMIT,
            'record_number' => 1
        ]);
    }

    function it_should_return_correct_result(
        GdprGetResponseResolver $gdprGetResponseResolver,
        UniqueCustomerLimitValidator $uniqueCustomerLimitValidator,
        CustomerQocSetsPaginationResolver $customerQocSetsPaginationResolver,
        GdprGetRequestData $requestData,
        CustomerQocSetArrayConverter $customerQocSetArrayConverter
    ) {
        $uniqueCustomerLimitValidator->isValid(['unique customer set'])->willReturn(true);

        $customerQocSetsPaginationResolver->getCustomerQocSetsByCursor($requestData, ['unique customer set'])
            ->willReturn(['current customer set by plain array']);
        $customerQocSetArrayConverter->convert(['current customer set by plain array'])
            ->willReturn(['current customer set by array ob customer qoc set object']);

        $gdprGetResponseResolver->getResponse($requestData, ['current customer set by array ob customer qoc set object'])
            ->willReturn(['the last result']);

        $this->get($requestData)->shouldReturn([
            'the last result',
            'qoc_set' => ['qoc set'],
            'all_unique_customer_qoc_set' => ['unique customer set'],
            'current_customer_qoc_set' => ['current customer set by array ob customer qoc set object']
        ]);
    }
}
