<?php

namespace spec\Cuongmits\GdprApi\Provider;

use Magento\Framework\Phrase;
use Cuongmits\GdprApi\Model\CustomerQocSet;
use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Provider\CustomerAccountStatusProvider;

final class CustomerAccountStatusProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CustomerAccountStatusProvider::class);
    }

    function it_should_return_array_with_value_yes_when_customer_set_has_customer_id(CustomerQocSet $customerQocSet)
    {
        $customerQocSet->getCustomerId()->willReturn(123);

        $result = $this->getAccountStatus($customerQocSet);
        $result->offsetGet(0)->offsetGet('value')->shouldBeLike(new Phrase('yes'));
    }

    function it_should_return_array_with_value_no_when_customer_set_has_empty_customer_id(CustomerQocSet $customerQocSet)
    {
        $customerQocSet->getCustomerId()->willReturn(null);

        $result = $this->getAccountStatus($customerQocSet);
        $result->offsetGet(0)->offsetGet('value')->shouldBeLike(new Phrase('no'));
    }
}
