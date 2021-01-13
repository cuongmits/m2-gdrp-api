<?php

namespace spec\Cuongmits\GdprApi\Resolver;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Resolver\CustomerIdResolver;

class CustomerIdResolverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CustomerIdResolver::class);
    }

    function it_should_return_original_qoc_sets_when_no_empty_customer_id_exists()
    {
        $qocSets = [
            ['quote_id' => 1, 'order_id' => 1, 'customer_id' => 1, 'quote_customer_id' => 1, 'toom_group_id' => 1],
            ['quote_id' => 2, 'order_id' => null, 'customer_id' => 2, 'quote_customer_id' => 1, 'toom_group_id' => 1],
        ];

        $this->setCustomerIdForQocSets($qocSets)->shouldReturn($qocSets);
    }

    function it_should_fill_customer_id_empty_field_with_quote_customer_id_if_it_exists()
    {
        $qocSets = [
            ['quote_id' => 1, 'order_id' => 1, 'customer_id' => 1, 'quote_customer_id' => 1, 'toom_group_id' => 1],
            ['quote_id' => 2, 'order_id' => 2, 'customer_id' => null, 'quote_customer_id' => 2, 'toom_group_id' => 2],
            ['quote_id' => 3, 'order_id' => null, 'customer_id' => null, 'quote_customer_id' => 3, 'toom_group_id' => 3],
        ];

        $this->setCustomerIdForQocSets($qocSets)->shouldReturn([
            ['quote_id' => 1, 'order_id' => 1, 'customer_id' => 1, 'quote_customer_id' => 1, 'toom_group_id' => 1],
            ['quote_id' => 2, 'order_id' => 2, 'customer_id' => 2, 'quote_customer_id' => 2, 'toom_group_id' => 2],
            ['quote_id' => 3, 'order_id' => null, 'customer_id' => 3, 'quote_customer_id' => 3, 'toom_group_id' => 3],
        ]);
    }

    function it_should_fill_customer_id_empty_field_with_existing_customer_id_regarding_similar_toom_group_id()
    {
        $qocSets = [
            ['quote_id' => 3, 'order_id' => 3, 'customer_id' => 2, 'quote_customer_id' => null, 'toom_group_id' => 2],
            ['quote_id' => 4, 'order_id' => 4, 'customer_id' => null, 'quote_customer_id' => null, 'toom_group_id' => 2],
            ['quote_id' => 5, 'order_id' => null, 'customer_id' => null, 'quote_customer_id' => null, 'toom_group_id' => 2],
        ];

        $this->setCustomerIdForQocSets($qocSets)->shouldReturn([
            ['quote_id' => 3, 'order_id' => 3, 'customer_id' => 2, 'quote_customer_id' => null, 'toom_group_id' => 2],
            ['quote_id' => 4, 'order_id' => 4, 'customer_id' => 2, 'quote_customer_id' => null, 'toom_group_id' => 2],
            ['quote_id' => 5, 'order_id' => null, 'customer_id' => 2, 'quote_customer_id' => null, 'toom_group_id' => 2],
        ]);
    }
}
