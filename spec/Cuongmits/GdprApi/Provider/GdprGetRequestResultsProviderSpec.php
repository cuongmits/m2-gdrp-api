<?php

namespace spec\Cuongmits\GdprApi\Provider;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Model\CurrentIdSets;
use Cuongmits\GdprApi\Model\CustomerQocSet;
use Cuongmits\GdprApi\Model\QuoteOrderSet;
use Cuongmits\GdprApi\Provider\GdprGetRequestResultsProvider;
use Cuongmits\GdprApi\Resolver\CurrentIdSetsResolver;
use Cuongmits\GdprApi\Resolver\MapperResolver;
use PHPUnit\Framework\Assert;

class GdprGetRequestResultsProviderSpec extends ObjectBehavior
{
    function let(
        CurrentIdSetsResolver $currentIdsResolver,
        MapperResolver $mapperResolver
    ) {
        $this->beConstructedWith($currentIdsResolver, $mapperResolver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GdprGetRequestResultsProvider::class);
    }

    function it_should_return_correct_result(
        CurrentIdSetsResolver $currentIdsResolver,
        MapperResolver $mapperResolver,
        CurrentIdSets $currentIdSets
    ) {
        $quoteOrderSet1 = new QuoteOrderSet(1, 1);
        $quoteOrderSet2 = new QuoteOrderSet(2, 2);
        $quoteOrderSet3 = new QuoteOrderSet(3, 3);
        $quoteOrderSet4 = new QuoteOrderSet(4, 4);
        $quoteOrderSet5 = new QuoteOrderSet(5, 5);
        $customerQocSet1 = new CustomerQocSet(1, [$quoteOrderSet1, $quoteOrderSet2]);
        $customerQocSet2 = new CustomerQocSet(2, [$quoteOrderSet3, $quoteOrderSet4]);
        $customerQocSet3 = new CustomerQocSet(3, [$quoteOrderSet5]);
        $currentCustomerQocSets = [$customerQocSet1, $customerQocSet2, $customerQocSet3];

        $currentIdsResolver->getCurrentIdSets($currentCustomerQocSets)->willReturn($currentIdSets);
        $mapperResolver->initMappers($currentIdSets)->shouldBeCalled();
        $mapperResolver->getDataOfCustomerQocSetFromMappers($customerQocSet1)->willReturn(['data 1']);
        $mapperResolver->getDataOfCustomerQocSetFromMappers($customerQocSet2)->willReturn(['data 2']);
        $mapperResolver->getDataOfCustomerQocSetFromMappers($customerQocSet3)->willReturn(['data 3']);

        $result = $this->get($currentCustomerQocSets);
        $result->shouldBeArray();
        Assert::assertEquals($result->getWrappedObject()[0]['data'], ['data 1']);
        Assert::assertEquals($result->getWrappedObject()[1]['data'], ['data 2']);
        Assert::assertEquals($result->getWrappedObject()[2]['data'], ['data 3']);
    }
}
