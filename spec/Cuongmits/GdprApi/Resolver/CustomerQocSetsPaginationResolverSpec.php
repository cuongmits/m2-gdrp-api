<?php

namespace spec\Cuongmits\GdprApi\Resolver;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Resolver\CustomerQocSetsPaginationResolver;

class CustomerQocSetsPaginationResolverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CustomerQocSetsPaginationResolver::class);
    }

    function it_should_return_correct_current_customer_qoc_sets_in_different_cases()
    {
        $customerQocSet1 = ['customer_id' => 4, 'quote_order_sets' => [['quote_id' => 4, 'order_id' => 4]]];
        $customerQocSet2 = ['customer_id' => 3, 'quote_order_sets' => [['quote_id' => 3, 'order_id' => 3]]];
        $customerQocSet3 = ['customer_id' => 2, 'quote_order_sets' => [['quote_id' => 2, 'order_id' => 2]]];
        $customerQocSet4 = ['customer_id' => 1, 'quote_order_sets' => [['quote_id' => 1, 'order_id' => 1]]];
        $customerQocSet5 = ['customer_id' => null, 'quote_order_sets' => [['quote_id' => 6, 'order_id' => 6]]];
        $customerQocSet6 = ['customer_id' => null, 'quote_order_sets' => [['quote_id' => 5, 'order_id' => 5]]];
        $allCustomerQocSets = [
            $customerQocSet3,
            $customerQocSet1,
            $customerQocSet2,
            $customerQocSet6,
            $customerQocSet4,
            $customerQocSet5,
        ];

        $requestData = new GdprGetRequestData('firstname', 'lastname', 'email', 'debitor', 'loyalty', 4, 0);

        $this->getCustomerQocSetsByCursor($requestData, $allCustomerQocSets)->shouldReturn([$customerQocSet1, $customerQocSet2, $customerQocSet3, $customerQocSet4]);

        $requestData = new GdprGetRequestData('firstname', 'lastname', 'email', 'debitor', 'loyalty', 4, 1);

        $this->getCustomerQocSetsByCursor($requestData, $allCustomerQocSets)->shouldReturn([$customerQocSet2, $customerQocSet3, $customerQocSet4, $customerQocSet5]);

        $requestData = new GdprGetRequestData('firstname', 'lastname', 'email', 'debitor', 'loyalty', 4, 2);

        $this->getCustomerQocSetsByCursor($requestData, $allCustomerQocSets)->shouldReturn([$customerQocSet3, $customerQocSet4, $customerQocSet5, $customerQocSet6]);

        $requestData = new GdprGetRequestData('firstname', 'lastname', 'email', 'debitor', 'loyalty', 4, 3);

        $this->getCustomerQocSetsByCursor($requestData, $allCustomerQocSets)->shouldReturn([$customerQocSet4, $customerQocSet5, $customerQocSet6]);

        $requestData = new GdprGetRequestData('firstname', 'lastname', 'email', 'debitor', 'loyalty', 4, 4);

        $this->getCustomerQocSetsByCursor($requestData, $allCustomerQocSets)->shouldReturn([$customerQocSet5, $customerQocSet6]);

        $requestData = new GdprGetRequestData('firstname', 'lastname', 'email', 'debitor', 'loyalty', 4, 5);

        $this->getCustomerQocSetsByCursor($requestData, $allCustomerQocSets)->shouldReturn([$customerQocSet6]);

        $requestData = new GdprGetRequestData('firstname', 'lastname', 'email', 'debitor', 'loyalty', 4, 6);

        $this->getCustomerQocSetsByCursor($requestData, $allCustomerQocSets)->shouldReturn([]);

        $requestData = new GdprGetRequestData('firstname', 'lastname', 'email', 'debitor', 'loyalty', 4, 100);

        $this->getCustomerQocSetsByCursor($requestData, $allCustomerQocSets)->shouldReturn([]);
    }
}
