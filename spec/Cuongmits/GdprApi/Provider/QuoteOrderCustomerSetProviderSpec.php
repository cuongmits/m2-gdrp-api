<?php

namespace spec\Cuongmits\GdprApi\Provider;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Provider\CustomerSetProvider;
use Cuongmits\GdprApi\Provider\QocSet\CustomerBasedQocSetProvider;
use Cuongmits\GdprApi\Provider\QocSet\QuoteBasedQocSetProvider;
use Cuongmits\GdprApi\Provider\QuoteOrderCustomerSetProvider;
use Cuongmits\GdprApi\Provider\SetProviderInterface;

class QuoteOrderCustomerSetProviderSpec extends ObjectBehavior
{
    function let(
        QuoteBasedQocSetProvider $quoteBasedQocSetProvider,
        CustomerBasedQocSetProvider $customerBasedQocSetProvider
    ) {
        $this->beConstructedWith($quoteBasedQocSetProvider, $customerBasedQocSetProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QuoteOrderCustomerSetProvider::class);
    }

    function it_implements_interface()
    {
        $this->shouldImplement(SetProviderInterface::class);
    }

    function it_should_return_correct_customer_set(
        QuoteBasedQocSetProvider $quoteBasedQocSetProvider,
        CustomerBasedQocSetProvider $customerBasedQocSetProvider,
        GdprGetRequestData $requestData
    ) {
        $quoteBasedQocSetProvider->get($requestData)->willReturn([
            ['qoc set 1']
        ]);
        $customerBasedQocSetProvider->get($requestData)->willReturn([
            ['qoc set 2']
        ]);

        $this->get($requestData)->shouldReturn([
            ['qoc set 1'],
            ['qoc set 2']
        ]);
    }
}
