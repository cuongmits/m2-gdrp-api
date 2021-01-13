<?php

namespace spec\Cuongmits\GdprApi\Model;

use Cuongmits\GdprApi\Model\CurrentIdSets;
use PhpSpec\ObjectBehavior;

class CurrentIdSetsSpec extends ObjectBehavior
{
    function let()
    {
        $orderIds = [1, 2, 3, 4];
        $quoteIds = [1, 2, 3];
        $customerIds = [1, 3, 5];

        $this->beConstructedWith($customerIds, $orderIds, $quoteIds);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CurrentIdSets::class);
    }

    function it_should_return_correct_ids_set()
    {
        $this->getCustomerIds()->shouldReturn([1, 3, 5]);
        $this->getQuoteIds()->shouldReturn([1, 2, 3]);
        $this->getOrderIds()->shouldReturn([1, 2, 3, 4]);
    }
}
