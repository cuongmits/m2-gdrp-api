<?php

namespace spec\Cuongmits\GdprApi\Response\Result;

use Cuongmits\GdprApi\Response\Result\QueryResults;
use PhpSpec\ObjectBehavior;

final class QueryResultsSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('create', [
            'first', 'last', 'email', '123', '789'
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QueryResults::class);
    }

    function it_should_serialize_all_its_values()
    {
        $serialized = $this->jsonSerialize();

        $serialized->offsetGet('first_name')->shouldBe('first');
        $serialized->offsetGet('last_name')->shouldBe('last');
        $serialized->offsetGet('email_address')->shouldBe('email');
        $serialized->offsetGet('debitor_number')->shouldBe('123');
        $serialized->offsetGet('debitor_card_number')->shouldBe('789');
    }

    function it_should_omit_empty_values()
    {
        $this->beConstructedThrough('create', [
            null, null, 'email', null, null
        ]);

        $serialized = $this->jsonSerialize();

        $serialized->shouldNotHaveKey('first_name');
        $serialized->shouldNotHaveKey('last_name');
        $serialized->offsetGet('email_address')->shouldBe('email');
        $serialized->shouldNotHaveKey('debitor_number');
        $serialized->shouldNotHaveKey('debitor_card_number');
    }
}
