<?php

namespace spec\Cuongmits\GdprApi\Provider;

use Magento\Framework\App\Request\Http;
use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Provider\ParametersProvider;

class ParametersProviderSpec extends ObjectBehavior
{
    function let(Http $request)
    {
        $this->beConstructedWith($request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ParametersProvider::class);
    }

    function it_should_return_correct_first_name(Http $request)
    {
        $request->getParam('first_name')->willReturn('firstname');
        $this->getFirstname()->shouldReturn('firstname');

        $request->getParam('first_name')->willReturn(null);
        $this->getFirstname()->shouldReturn(null);

        $request->getParam('first_name')->willReturn('');
        $this->getFirstname()->shouldReturn('');
    }

    function it_should_return_correct_last_name(Http $request)
    {
        $request->getParam('last_name')->willReturn('last_name');
        $this->getLastname()->shouldReturn('last_name');

        $request->getParam('last_name')->willReturn(null);
        $this->getLastname()->shouldReturn(null);

        $request->getParam('last_name')->willReturn('');
        $this->getLastname()->shouldReturn('');
    }

    function it_should_return_correct_email(Http $request)
    {
        $request->getParam('email_address')->willReturn('email_address');
        $this->getEmail()->shouldReturn('email_address');

        $request->getParam('email_address')->willReturn(null);
        $this->getEmail()->shouldReturn(null);

        $request->getParam('email_address')->willReturn('');
        $this->getEmail()->shouldReturn('');
    }

    function it_should_return_correct_debitor_name(Http $request)
    {
        $request->getParam('debitor_number')->willReturn('debitor_number');
        $this->getDebitorNumber()->shouldReturn('debitor_number');

        $request->getParam('debitor_number')->willReturn(null);
        $this->getDebitorNumber()->shouldReturn(null);

        $request->getParam('debitor_number')->willReturn('');
        $this->getDebitorNumber()->shouldReturn('');
    }

    function it_should_return_correct_debitor_card_number(Http $request)
    {
        $request->getParam('debitor_card_number')->willReturn('debitor_card_number');
        $this->getLoyaltyNumber()->shouldReturn('debitor_card_number');

        $request->getParam('debitor_card_number')->willReturn(null);
        $this->getLoyaltyNumber()->shouldReturn(null);

        $request->getParam('debitor_card_number')->willReturn('');
        $this->getLoyaltyNumber()->shouldReturn('');
    }

    function it_should_return_correct_limit(Http $request)
    {
        $request->getParam('limit')->willReturn('99');
        $this->getLimit()->shouldReturn(99);

        $request->getParam('limit')->willReturn(null);
        $this->getLimit()->shouldReturn(ParametersProvider::DEFAULT_LIMIT);

        $request->getParam('limit')->willReturn('');
        $this->getLimit()->shouldReturn(ParametersProvider::DEFAULT_LIMIT);

        $request->getParam('limit')->willReturn('-99');
        $this->getLimit()->shouldReturn(ParametersProvider::DEFAULT_LIMIT);
    }

    function it_should_return_correct_cursor(Http $request)
    {
        $request->getParam('cursor')->willReturn('99');
        $this->getCursor()->shouldReturn(99);

        $request->getParam('cursor')->willReturn(null);
        $this->getCursor()->shouldReturn(ParametersProvider::DEFAULT_CURSOR);

        $request->getParam('cursor')->willReturn('');
        $this->getCursor()->shouldReturn(ParametersProvider::DEFAULT_CURSOR);

        $request->getParam('cursor')->willReturn('-99');
        $this->getCursor()->shouldReturn(0);
    }
}
