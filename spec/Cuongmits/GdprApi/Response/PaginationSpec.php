<?php

namespace spec\Cuongmits\GdprApi\Response;

use Cuongmits\GdprApi\Response\Pagination;
use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Model\Pagination as PaginationModel;

final class PaginationSpec extends ObjectBehavior
{
    function let(PaginationModel $paginationModel)
    {
        $this->beConstructedThrough('create', [$paginationModel]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Pagination::class);
    }

    function it_should_serialize_all_its_values()
    {
        $this->beConstructedThrough('create', [PaginationModel::create(30, 10, 10)]);

        $serialized = $this->jsonSerialize();

        $serialized->offsetGet('limit')->shouldBe(10);
        $serialized->offsetGet('size')->shouldBe(10);
        $serializedCursor = $serialized->offsetGet('cursor');
        $serializedCursor->offsetGet('current')->shouldBe(10);
        $serializedCursor->offsetGet('prev')->shouldBe(0);
        $serializedCursor->offsetGet('next')->shouldBe(20);
    }

    function it_should_omit_a_missing_prev_key()
    {
        $this->beConstructedThrough('create', [PaginationModel::create(30, 10, 0)]);

        $serialized = $this->jsonSerialize();

        $serializedCursor = $serialized->offsetGet('cursor');
        $serializedCursor->shouldNotHaveKey('prev');
    }

    function it_should_omit_a_missing_next_key()
    {
        $this->beConstructedThrough('create', [PaginationModel::create(30, 10, 20)]);

        $serialized = $this->jsonSerialize();

        $serializedCursor = $serialized->offsetGet('cursor');
        $serializedCursor->shouldNotHaveKey('next');
    }
}
