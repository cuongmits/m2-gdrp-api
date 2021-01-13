<?php

namespace spec\Cuongmits\GdprApi\Resolver;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Resolver\AggregationResolver;
use Cuongmits\GdprApi\Resolver\CustomerIdResolver;

class AggregationResolverSpec extends ObjectBehavior
{
    function let(CustomerIdResolver $quoteCustomerIdResolver)
    {
        $this->beConstructedWith($quoteCustomerIdResolver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AggregationResolver::class);
    }

    function it_should_return_correct_result(CustomerIdResolver $quoteCustomerIdResolver)
    {
        $qocSet = ['any array'];
        $qocSetAfterFillingCustomerId = [
            ['quote_id' => 1, 'order_id' => 1, 'customer_id' => 1, 'quote_customer_id' => 1, 'toom_group_id' => 1],
            ['quote_id' => 2, 'order_id' => 2, 'customer_id' => 1, 'quote_customer_id' => 1, 'toom_group_id' => 2],
            ['quote_id' => 3, 'order_id' => 3, 'customer_id' => 3, 'quote_customer_id' => 3, 'toom_group_id' => 3],
        ];
        $quoteCustomerIdResolver->setCustomerIdForQocSets($qocSet)->willReturn($qocSetAfterFillingCustomerId);

        $this->aggregateQocSetsByUniqueCustomers($qocSet)->shouldReturn([
            [
                'customer_id' => 1,
                'quote_order_sets' => [
                    ['quote_id' => 1, 'order_id' => 1],
                    ['quote_id' => 2, 'order_id' => 2],
                ]
            ],
            [
                'customer_id' => 3,
                'quote_order_sets' => [
                    ['quote_id' => 3, 'order_id' => 3],
                ]
            ],
        ]);
    }

    function it_should_merge_qoc_sets_which_have_the_same_quote_customer_id(
        CustomerIdResolver $quoteCustomerIdResolver
    ) {
        $qocSet = ['any array'];
        $qocSetAfterFillingCustomerId = [
            ['quote_id' => 4, 'order_id' => 4, 'customer_id' => 4, 'quote_customer_id' => 4, 'toom_group_id' => 3],
            ['quote_id' => 7, 'order_id' => null, 'customer_id' => 4, 'quote_customer_id' => 4, 'toom_group_id' => 5],
            ['quote_id' => 8, 'order_id' => null, 'customer_id' => 4, 'quote_customer_id' => 4, 'toom_group_id' => 6],
        ];
        $quoteCustomerIdResolver->setCustomerIdForQocSets($qocSet)->willReturn($qocSetAfterFillingCustomerId);

        $this->aggregateQocSetsByUniqueCustomers($qocSet)->shouldReturn([
            [
                'customer_id' => 4,
                'quote_order_sets' => [
                    ['quote_id' => 4, 'order_id' => 4],
                    ['quote_id' => 7, 'order_id' => null],
                    ['quote_id' => 8, 'order_id' => null],
                ]
            ],
        ]);
    }

    function it_should_merge_qoc_sets_which_have_the_same_group_id(CustomerIdResolver $quoteCustomerIdResolver)
    {
        $qocSet = ['any array'];
        $qocSetAfterFillingCustomerId = [
            ['quote_id' => 5, 'order_id' => 5, 'customer_id' => null, 'quote_customer_id' => null, 'toom_group_id' => 4],
            ['quote_id' => 6, 'order_id' => 6, 'customer_id' => null, 'quote_customer_id' => null, 'toom_group_id' => 4],
        ];
        $quoteCustomerIdResolver->setCustomerIdForQocSets($qocSet)->willReturn($qocSetAfterFillingCustomerId);

        $this->aggregateQocSetsByUniqueCustomers($qocSet)->shouldReturn([
            [
                'customer_id' => null,
                'quote_order_sets' => [
                    ['quote_id' => 5, 'order_id' => 5],
                    ['quote_id' => 6, 'order_id' => 6],
                ]
            ],
        ]);
    }
}
