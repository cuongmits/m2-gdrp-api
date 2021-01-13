<?php

namespace spec\Cuongmits\GdprApi\Filter;

use Cuongmits\GdprApi\Filter\RemoveNullValueItemFilter;
use PhpSpec\ObjectBehavior;

class RemoveNullValueItemFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveNullValueItemFilter::class);
    }

    function it_should_filter_all_null_value_item_from_array()
    {
        $array = [
            ['label' => 'Konto', 'value' => 'ja'],
            ['label' => 'SAP Debitor', 'value' => null],
            ['label' => 'Loyalty Card Number', 'value' => null],
        ];

        $this->apply($array)->shouldReturn([['label' => 'Konto', 'value' => 'ja'],]);
    }
}
