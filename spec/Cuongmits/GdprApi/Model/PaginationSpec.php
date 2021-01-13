<?php

namespace spec\Cuongmits\GdprApi\Model;

use Cuongmits\GdprApi\Model\Pagination;
use PhpSpec\ObjectBehavior;

final class PaginationSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('create', [100, 10, 0]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Pagination::class);
    }

    function it_should_return_correct_values()
    {
        $this->beConstructedThrough('create', [100, 10, 89]);

        $this->getTotalSize()->shouldBe(100);
        $this->getPageSize()->shouldbe(10);
        $this->getCursor()->shouldBe(89);
        $this->getCurrentSize()->shouldBe(10);
        $this->getPreviousCursor()->shouldBe(79);
        $this->getNextCursor()->shouldBe(99);
    }

    function it_should_omit_previous_when_at_start()
    {
        $this->beConstructedThrough('create', [100, 10, 0]);

        $this->getPreviousCursor()->shouldBeNull();
    }

    function it_should_not_set_previous_to_negative()
    {
        $this->beConstructedThrough('create', [100, 20, 10]);

        $this->getPreviousCursor()->shouldBe(0);
    }

    function it_should_omit_next_when_at_end()
    {
        $this->beConstructedThrough('create', [100, 25, 75]);

        $this->getNextCursor()->shouldBeNull();
    }
}
