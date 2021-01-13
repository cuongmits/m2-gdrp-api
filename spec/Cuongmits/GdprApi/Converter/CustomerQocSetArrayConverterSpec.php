<?php

namespace spec\Cuongmits\GdprApi\Converter;

use PHPUnit\Framework\Assert;
use Cuongmits\GdprApi\Converter\ConverterInterface;
use Cuongmits\GdprApi\Converter\CustomerQocSetArrayConverter;
use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Model\CustomerQocSet;

class CustomerQocSetArrayConverterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CustomerQocSetArrayConverter::class);
    }

    function it_implements_interface()
    {
        $this->shouldImplement(ConverterInterface::class);
    }

    function it_should_return_empty_array_of_customer_qoc_sets_when_the_input_is_empty()
    {
        $this->convert([])->shouldReturn([]);
    }

    function it_should_return_correct_array_of_customer_qoc_sets_when_input_is_not_null()
    {
        $result = $this->convert([
            [
                'customer_id' => 1,
                'quote_order_sets' => [
                    ['quote_id' => 1, 'order_id' => 1],
                    ['quote_id' => 2, 'order_id' => null],
                ]
            ],
            [
                'customer_id' => 2,
                'quote_order_sets' => [
                    ['quote_id' => 3, 'order_id' => 3],
                ]
            ],
            [
                'customer_id' => 3,
                'quote_order_sets' => []
            ]
        ]);

        $result->shouldBeArray();

        $item1 = $result->offsetGet(0);
        $item1->shouldBeAnInstanceOf(CustomerQocSet::class);
        Assert::assertEquals($item1->getWrappedObject()->getCustomerId(), 1);
        Assert::assertEquals(count($item1->getWrappedObject()->getQuoteOrderSets()), 2);

        $item2 = $result->offsetGet(1);
        $item2->shouldBeAnInstanceOf(CustomerQocSet::class);
        Assert::assertEquals($item2->getWrappedObject()->getCustomerId(), 2);
        Assert::assertEquals(count($item2->getWrappedObject()->getQuoteOrderSets()), 1);

        $item3 = $result->offsetGet(2);
        $item3->shouldBeAnInstanceOf(CustomerQocSet::class);
        Assert::assertEquals($item3->getWrappedObject()->getCustomerId(), 3);
        Assert::assertEquals(count($item3->getWrappedObject()->getQuoteOrderSets()), 0);
    }
}
