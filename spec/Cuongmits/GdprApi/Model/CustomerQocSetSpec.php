<?php

namespace spec\Cuongmits\GdprApi\Model;

use Cuongmits\GdprApi\Model\CustomerQocSet;
use Cuongmits\GdprApi\Model\QuoteOrderSet;
use PhpSpec\ObjectBehavior;

class CustomerQocSetSpec extends ObjectBehavior
{
    function let(QuoteOrderSet $quoteOrderSet1, QuoteOrderSet $quoteOrderSet2)
    {
        $customerId = 1;

        $this->beConstructedWith($customerId, [$quoteOrderSet1, $quoteOrderSet2]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CustomerQocSet::class);
    }

    function it_should_return_correct_data(QuoteOrderSet $quoteOrderSet1, QuoteOrderSet $quoteOrderSet2)
    {
        $this->getCustomerId()->shouldReturn(1);
        $this->getQuoteOrderSets()->shouldReturn([$quoteOrderSet1, $quoteOrderSet2]);
    }
}
