<?php

namespace spec\Cuongmits\GdprApi\Model;

use Cuongmits\GdprApi\Model\QuoteOrderSet;
use PhpSpec\ObjectBehavior;

class QuoteOrderSetSpec extends ObjectBehavior
{
    function let()
    {
        $orderId = 1;
        $quoteId = 2;

        $this->beConstructedWith($orderId, $quoteId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QuoteOrderSet::class);
    }

    function it_should_return_correct_data()
    {
        $this->getQuoteId()->shouldReturn(1);
        $this->getOrderId()->shouldReturn(2);
    }
}
