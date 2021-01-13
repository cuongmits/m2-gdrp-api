<?php

namespace spec\Cuongmits\GdprApi\Validator;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Validator\OneEmptyNameValidator;
use Cuongmits\GdprApi\Validator\SingleValidatorInterface;

final class OneEmptyNameValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OneEmptyNameValidator::class);
    }

    function it_should_implements_single_validator_interface()
    {
        $this->shouldImplement(SingleValidatorInterface::class);
    }

    function it_should_return_true_when_names_are_empty(GdprGetRequestData $requestData)
    {
        $requestData->getFirstname()->willReturn(null);
        $requestData->getLastname()->willReturn('');

        $this->isValid($requestData)->shouldReturn(true);
    }

    function it_should_return_true_when_both_names_are_not_empty(GdprGetRequestData $requestData)
    {
        $requestData->getFirstname()->willReturn('firstname');
        $requestData->getLastname()->willReturn('lastname');

        $this->isValid($requestData)->shouldReturn(true);
    }

    function it_should_return_false_when_only_one_name_is_empty(GdprGetRequestData $requestData)
    {
        $requestData->getFirstname()->willReturn(null);
        $requestData->getLastname()->willReturn('last-name');

        $this->isValid($requestData)->shouldReturn(false);

        $requestData->getFirstname()->willReturn('first-name');
        $requestData->getLastname()->willReturn('');

        $this->isValid($requestData)->shouldReturn(false);
    }
}
