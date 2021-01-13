<?php

namespace spec\Cuongmits\GdprApi\Response;

use Cuongmits\GdprApi\Response\Result;
use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Response\Result\QueryResults;

final class ResultSpec extends ObjectBehavior
{
    function let(QueryResults $queryResults)
    {
        $this->beConstructedThrough('create', [['value'], $queryResults]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Result::class);
    }

    function it_should_serialize_its_values(QueryResults $queryResults)
    {
        $serialized = $this->jsonSerialize();
        $serialized->offsetGet('data')->shouldBeLike(['value']);
        $serialized->offsetGet('query_results')->shouldBe($queryResults);
    }
}
