<?php

namespace spec\Cuongmits\GdprApi\Mapper;

use Cuongmits\GdprApi\Mapper\CuongmitsGroupIdToCustomerIdMapper;
use PhpSpec\ObjectBehavior;

class CuongmitsGroupIdToCustomerIdMapperSpec extends ObjectBehavior
{
    function let()
    {
        $qocSets = ['any array'];

        $this->beConstructedThrough('create', [$qocSets]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CuongmitsGroupIdToCustomerIdMapper::class);
    }

    function it_should_map_toom_group_id_to_correct_customer_id()
    {
        $qocSets = [
            ['quote_id' => 1, 'order_id' => 1, 'customer_id' => 1, 'quote_customer_id' => 1, 'toom_group_id' => 1],
            ['quote_id' => 1, 'order_id' => 1, 'customer_id' => null, 'quote_customer_id' => 1, 'toom_group_id' => 1],
            ['quote_id' => 6, 'order_id' => 4, 'customer_id' => 2, 'quote_customer_id' => null, 'toom_group_id' => 2],
            ['quote_id' => 7, 'order_id' => 5, 'customer_id' => null, 'quote_customer_id' => null, 'toom_group_id' => 2],
            ['quote_id' => 8, 'order_id' => null, 'customer_id' => null, 'quote_customer_id' => null, 'toom_group_id' => 2]
        ];

        $this->beConstructedThrough('create', [$qocSets]);

        $this->map(1)->shouldReturn(1);
        $this->map(2)->shouldReturn(2);
    }

    function it_should_map_toom_group_id_to_null_when_no_customer_id_exist()
    {
        $qocSets = [
            ['quote_id' => 8, 'order_id' => null, 'customer_id' => null, 'quote_customer_id' => null, 'toom_group_id' => 3],
        ];

        $this->beConstructedThrough('create', [$qocSets]);

        $this->map(3)->shouldReturn(null);
        $this->map(4)->shouldReturn(null);
    }

    function it_should_map_toom_group_id_to_null_when_toom_group_id_does_not_exist()
    {
        $qocSets = [
            ['quote_id' => 8, 'order_id' => null, 'customer_id' => null, 'quote_customer_id' => null, 'toom_group_id' => 3],
        ];

        $this->beConstructedThrough('create', [$qocSets]);

        $this->map('not existing toom group id')->shouldReturn(null);
    }
}
