<?php

namespace spec\Cuongmits\GdprApi\Response;

use Magento\Framework\Phrase;
use Cuongmits\GdprApi\Response\GetResponse;
use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Response\Pagination;

final class GetResponseSpec extends ObjectBehavior
{
    function let(Pagination $pagination)
    {
        $this->beConstructedThrough('create', [['query'], $pagination, ['results']]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GetResponse::class);
    }

    function it_should_serialize_all_its_values(Pagination $pagination)
    {
        $pagination->jsonSerialize()->willReturn(['pagination']);

        $serialized = $this->jsonSerialize();

        $serialized->offsetGet('label')->shouldBeAnInstanceOf(Phrase::class);
        $serialized->offsetGet('description')->shouldBeAnInstanceOf(Phrase::class);
        $serialized->offsetGet('results')->shouldBe(['results']);
        $serialized->offsetGet('query')->shouldBe(['query']);
        $serialized->offsetGet('page')->shouldBe(['pagination']);
    }
}
