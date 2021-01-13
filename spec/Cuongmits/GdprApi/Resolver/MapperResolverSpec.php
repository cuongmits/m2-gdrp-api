<?php

namespace spec\Cuongmits\GdprApi\Resolver;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Filter\RemoveNullValueItemFilter;
use Cuongmits\GdprApi\Mapper\CustomerRelatedGdprDataMapper;
use Cuongmits\GdprApi\Mapper\OrderRelatedGdprDataMapper;
use Cuongmits\GdprApi\Mapper\QuoteRelatedGdprDataMapper;
use Cuongmits\GdprApi\Model\CurrentIdSets;
use Cuongmits\GdprApi\Model\CustomerQocSet;
use Cuongmits\GdprApi\Model\QuoteOrderSet;
use Cuongmits\GdprApi\Provider\CustomerAccountStatusProvider;
use Cuongmits\GdprApi\Resolver\MapperResolver;

class MapperResolverSpec extends ObjectBehavior
{
    function let(
        QuoteRelatedGdprDataMapper $quoteRelatedGdprDataMapper,
        OrderRelatedGdprDataMapper $orderRelatedGdprDataMapper,
        CustomerRelatedGdprDataMapper $customerRelatedGdprDataMapper,
        CustomerAccountStatusProvider $customerAccountStatusProvider,
        RemoveNullValueItemFilter $removeNullValueItemFilter
    ) {
        $this->beConstructedWith(
            $quoteRelatedGdprDataMapper,
            $orderRelatedGdprDataMapper,
            $customerRelatedGdprDataMapper,
            $customerAccountStatusProvider,
            $removeNullValueItemFilter
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MapperResolver::class);
    }

    function it_should_load_data_for_mappers(
        CurrentIdSets $currentIdSets,
        QuoteRelatedGdprDataMapper $quoteRelatedGdprDataMapper,
        OrderRelatedGdprDataMapper $orderRelatedGdprDataMapper,
        CustomerRelatedGdprDataMapper $customerRelatedGdprDataMapper
    ) {
        $currentIdSets->getCustomerIds()->willReturn(['customer ids']);
        $currentIdSets->getOrderIds()->willReturn(['order ids']);
        $currentIdSets->getQuoteIds()->willReturn(['quote ids']);

        $quoteRelatedGdprDataMapper->load(['quote ids'])->shouldBeCalled();
        $orderRelatedGdprDataMapper->load(['order ids'])->shouldBeCalled();
        $customerRelatedGdprDataMapper->load(['customer ids'])->shouldBeCalled();

        $this->initMappers($currentIdSets);
    }

    function it_should_return_loaded_from_mappers_data(
        QuoteRelatedGdprDataMapper $quoteRelatedGdprDataMapper,
        OrderRelatedGdprDataMapper $orderRelatedGdprDataMapper,
        CustomerRelatedGdprDataMapper $customerRelatedGdprDataMapper,
        CustomerAccountStatusProvider $customerAccountStatusProvider,
        RemoveNullValueItemFilter $removeNullValueItemFilter
    ) {
        $quoteOrderSet1 = new QuoteOrderSet(1, 1);
        $quoteOrderSet2 = new QuoteOrderSet(2, null);
        $quoteOrderSet3 = new QuoteOrderSet(3, 3);
        $customerQocSet1 = new CustomerQocSet(1, [$quoteOrderSet1, $quoteOrderSet2]);
        $customerQocSet2 = new CustomerQocSet(2, [$quoteOrderSet3]);
        $customerQocSet3 = new CustomerQocSet(3, []);

        $customerRelatedGdprDataMapper->map(1)->willReturn(['customer data 1']);
        $customerRelatedGdprDataMapper->map(2)->willReturn(['customer data 2']);
        $customerRelatedGdprDataMapper->map(3)->willReturn(['customer data 3']);

        $orderRelatedGdprDataMapper->map(1)->willReturn(['order data 1']);
        $orderRelatedGdprDataMapper->map(null)->willReturn([]);
        $orderRelatedGdprDataMapper->map(3)->willReturn(['order data 3']);

        $quoteRelatedGdprDataMapper->map(1)->willReturn(['quote data 1']);
        $quoteRelatedGdprDataMapper->map(2)->willReturn(['quote data 2']);
        $quoteRelatedGdprDataMapper->map(3)->willReturn(['quote data 3']);

        $customerAccountStatusProvider->getAccountStatus($customerQocSet1)->willReturn(['account status 1']);
        $customerAccountStatusProvider->getAccountStatus($customerQocSet2)->willReturn(['account status 2']);
        $customerAccountStatusProvider->getAccountStatus($customerQocSet3)->willReturn(['account status 3']);

        $removeNullValueItemFilter->apply(
            ['account status 1', 'customer data 1', 'order data 1', 'quote data 1', 'quote data 2']
        )->willReturn(['result 1']);
        $removeNullValueItemFilter->apply(
            ['account status 2', 'customer data 2', 'order data 3', 'quote data 3']
        )->willReturn(['result 2']);
        $removeNullValueItemFilter->apply(
            ['account status 3', 'customer data 3']
        )->willReturn(['result 3']);

        $this->getDataOfCustomerQocSetFromMappers($customerQocSet1)->shouldReturn(['result 1']);
        $this->getDataOfCustomerQocSetFromMappers($customerQocSet2)->shouldReturn(['result 2']);
        $this->getDataOfCustomerQocSetFromMappers($customerQocSet3)->shouldReturn(['result 3']);
    }
}
